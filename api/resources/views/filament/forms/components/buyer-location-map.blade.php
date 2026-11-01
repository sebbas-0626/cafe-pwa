<div
    wire:ignore
    x-data="{
        map: null,
        marker: null,
        interval: null,
        latitudeInput: null,
        longitudeInput: null,
        latitudeStatePath: 'data.latitude',
        longitudeStatePath: 'data.longitude',
        latitude: null,
        longitude: null,
        init() {
            this.loadLeaflet().then(() => {
                this.mountMap();
                this.interval = window.setInterval(() => this.syncFromInputs(), 600);
            });
        },
        loadLeaflet() {
            if (window.L) {
                return Promise.resolve();
            }

            if (! document.getElementById('leaflet-css')) {
                const link = document.createElement('link');
                link.id = 'leaflet-css';
                link.rel = 'stylesheet';
                link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
                document.head.appendChild(link);
            }

            return new Promise((resolve) => {
                const script = document.createElement('script');
                script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                script.onload = resolve;
                document.head.appendChild(script);
            });
        },
        mountMap() {
            this.latitudeInput = document.querySelector('input[id$=latitude]');
            this.longitudeInput = document.querySelector('input[id$=longitude]');
            this.latitudeStatePath = this.statePathOf(this.latitudeInput, 'data.latitude');
            this.longitudeStatePath = this.statePathOf(this.longitudeInput, 'data.longitude');
            this.latitude = this.numberOrNull(this.latitudeInput?.value);
            this.longitude = this.numberOrNull(this.longitudeInput?.value);

            const hasCoordinates = this.latitude !== null && this.longitude !== null;
            const center = hasCoordinates ? [this.latitude, this.longitude] : [4.5709, -74.2973];

            this.map = L.map(this.$refs.map, {
                center,
                zoom: hasCoordinates ? 13 : 5,
                scrollWheelZoom: true,
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap',
            }).addTo(this.map);

            if (hasCoordinates) {
                this.setMarker(this.latitude, this.longitude);
            }

            this.map.on('click', (event) => {
                this.setMarker(event.latlng.lat, event.latlng.lng);
                this.pushCoordinates(event.latlng.lat, event.latlng.lng);
            });
        },
        setMarker(latitude, longitude) {
            if (! this.map) {
                return;
            }

            if (! this.marker) {
                this.marker = L.marker([latitude, longitude], { draggable: true }).addTo(this.map);
                this.marker.on('dragend', () => {
                    const position = this.marker.getLatLng();
                    this.pushCoordinates(position.lat, position.lng);
                });
            } else {
                this.marker.setLatLng([latitude, longitude]);
            }

            this.map.setView([latitude, longitude], Math.max(this.map.getZoom(), 13));
        },
        pushCoordinates(latitude, longitude) {
            this.latitude = latitude;
            this.longitude = longitude;

            const formattedLatitude = latitude.toFixed(7);
            const formattedLongitude = longitude.toFixed(7);

            this.writeInput(this.latitudeInput, formattedLatitude);
            this.writeInput(this.longitudeInput, formattedLongitude);
            this.writeState(this.latitudeStatePath, formattedLatitude);
            this.writeState(this.longitudeStatePath, formattedLongitude);
        },
        syncFromInputs() {
            const latitude = this.numberOrNull(this.latitudeInput?.value);
            const longitude = this.numberOrNull(this.longitudeInput?.value);

            if (latitude === null || longitude === null) {
                return;
            }

            if (latitude === this.latitude && longitude === this.longitude) {
                return;
            }

            this.latitude = latitude;
            this.longitude = longitude;
            this.setMarker(latitude, longitude);
        },
        writeInput(input, value) {
            if (! input) {
                return;
            }

            input.value = value;
            input.dispatchEvent(new Event('input', { bubbles: true }));
            input.dispatchEvent(new Event('change', { bubbles: true }));
        },
        writeState(path, value) {
            const element = this.$el.closest('[wire\\:id]');

            if (! element || ! window.Livewire) {
                return;
            }

            const component = window.Livewire.find(element.getAttribute('wire:id'));
            component?.set(path, value);
        },
        statePathOf(input, fallback) {
            if (! input) {
                return fallback;
            }

            const attribute = input.getAttributeNames().find(name => name.startsWith('wire:model'));

            return attribute ? input.getAttribute(attribute) : fallback;
        },
        numberOrNull(value) {
            if (value === undefined || value === null || value === '') {
                return null;
            }

            const number = Number(value);

            return Number.isFinite(number) ? number : null;
        },
        destroy() {
            if (this.interval) {
                window.clearInterval(this.interval);
            }

            if (this.map) {
                this.map.remove();
            }
        },
    }"
    x-init="init()"
    class="w-full"
>
    <div class="mb-2 flex items-center justify-between gap-2">
        <div>
            <p class="text-sm font-medium text-gray-950 dark:text-white">Ubicación en el mapa</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">Haz clic en el mapa o arrastra el pin para ajustar la ubicación.</p>
        </div>
        <span
            class="text-xs text-gray-500 dark:text-gray-400"
            x-text="latitude !== null && longitude !== null ? `${latitude.toFixed(5)}, ${longitude.toFixed(5)}` : 'Sin coordenadas'"
        ></span>
    </div>

    <div
        x-ref="map"
        class="w-full rounded-lg border border-gray-200 dark:border-white/10"
        style="height: 320px; z-index: 0;"
    ></div>
</div>
