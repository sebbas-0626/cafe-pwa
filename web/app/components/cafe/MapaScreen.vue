<script setup lang="ts">
import CoffeeMap from '~/components/coffee-map/CoffeeMap.vue'
import CoffeeMapHeader from '~/components/coffee-map/CoffeeMapHeader.vue'
import CoffeeMapControls from '~/components/coffee-map/CoffeeMapControls.vue'
import CoffeeMapDetails from '~/components/coffee-map/CoffeeMapDetails.vue'
import CoffeeMapLegend from '~/components/coffee-map/CoffeeMapLegend.vue'
import CoffeeMapList from '~/components/coffee-map/CoffeeMapList.vue'

const {
  selectedVarieties,
  selectedBuyerId,
  viewMode,
  radiusKm,
  showLabels,
  showWater,
  toast,
  userLocation,
  locating,
  center,
  locationLabel,
  toggleVariety,
  resetVarieties,
  selectBuyer,
  clearSelection,
  setRadius,
  toggleLabels,
  toggleWater,
  toggleViewMode,
  locate
} = useCoffeeMap()

const {
  source,
  loading,
  error,
  loaded,
  mapPoints,
  selectedPoint,
  loadBuyers
} = useCoffeeBuyers()

const mapRef = ref<{ zoomIn: () => void; zoomOut: () => void } | null>(null)

onMounted(() => {
  void loadBuyers()
})

function handleListSelect(buyerId: number): void {
  selectBuyer(buyerId)
  viewMode.value = 'map'
}

function expandRadius(): void {
  setRadius(1000)
}

function retry(): void {
  void loadBuyers(true)
}
</script>

<template>
  <main class="fixed inset-0 overflow-hidden bg-[#E9DFD0] font-body-md text-[#402318]">
    <ClientOnly>
      <CoffeeMap
        ref="mapRef"
        :points="mapPoints"
        :selected-buyer-id="selectedBuyerId"
        :center="center"
        :user-location="userLocation"
        :show-labels="showLabels"
        :show-water="showWater"
        @select="selectBuyer"
      />

      <template #fallback>
        <div class="h-full w-full bg-[#E9DFD0]" />
      </template>
    </ClientOnly>

    <CoffeeMapHeader
      :count="mapPoints.length"
      :radius-km="radiusKm"
      :loading="locating"
      :source="source"
      :location-label="locationLabel"
      :selected-varieties="selectedVarieties"
      @locate="locate"
      @toggle-variety="toggleVariety"
    />

    <div class="absolute right-3 top-[9.5rem] z-20 md:right-4 md:top-[9.75rem]">
      <CoffeeMapControls
        :view-mode="viewMode"
        :show-labels="showLabels"
        :show-water="showWater"
        :locating="locating"
        @locate="locate"
        @zoom-in="mapRef?.zoomIn()"
        @zoom-out="mapRef?.zoomOut()"
        @toggle-list="toggleViewMode"
        @toggle-labels="toggleLabels"
        @toggle-water="toggleWater"
      />
    </div>

    <div
      class="absolute bottom-[max(1rem,env(safe-area-inset-bottom))] left-3 z-20 md:bottom-6 md:left-6"
      :class="selectedPoint ? 'hidden md:block' : 'block'"
    >
      <CoffeeMapLegend />
    </div>

    <div
      v-if="viewMode === 'list'"
      class="absolute inset-0 z-30 bg-[#402318]/10 backdrop-blur-[1px]"
      @click="toggleViewMode"
    />

    <div
      v-if="viewMode === 'list'"
      class="absolute inset-y-3 left-3 z-40 w-[calc(100%-1.5rem)] max-w-sm md:inset-y-4 md:left-4"
    >
      <CoffeeMapList
        :points="mapPoints"
        :selected-id="selectedBuyerId"
        :source="source"
        :loading="loading"
        :error="error"
        @select="handleListSelect"
        @close="toggleViewMode"
        @retry="retry"
      />
    </div>

    <div
      v-if="selectedPoint"
      class="absolute inset-x-0 bottom-0 z-40 px-2 pb-2 md:inset-x-auto md:bottom-6 md:right-6 md:px-0 md:pb-0"
    >
      <CoffeeMapDetails
        :point="selectedPoint"
        :origin="userLocation"
        @close="clearSelection"
      />
    </div>

    <div v-if="loading" class="pointer-events-none absolute inset-0 z-20 flex items-center justify-center px-4">
      <div class="flex items-center gap-2.5 rounded-full border border-white/70 bg-[#FFFAF6]/95 px-4 py-2.5 shadow-[0_14px_34px_-12px_rgba(64,35,24,0.4)] backdrop-blur-md">
        <span class="material-symbols-outlined animate-spin text-[18px] text-[#783719]">progress_activity</span>
        <span class="font-label-lg text-label-lg font-semibold text-[#402318]">Buscando los mejores precios…</span>
      </div>
    </div>

    <div
      v-else-if="error"
      class="absolute inset-0 z-20 flex items-center justify-center px-4"
    >
      <div class="pointer-events-auto flex w-full max-w-md flex-col items-center gap-3 rounded-3xl border border-white/70 bg-[#FFFAF6] p-6 text-center shadow-[0_22px_60px_-18px_rgba(64,35,24,0.45)]">
        <span class="material-symbols-outlined text-[34px] text-[#B4552F]">cloud_off</span>
        <h2 class="font-headline-md text-[18px] font-bold text-[#402318]">No pudimos cargar los compradores</h2>
        <p class="font-label-md text-[11px] text-[#7A6558]">{{ error }}</p>
        <button
          class="min-h-11 rounded-xl bg-[#783719] px-5 font-label-lg text-label-lg font-bold text-[#FFFAF6] transition-colors hover:bg-[#5E2B14] active:scale-95"
          type="button"
          @click="retry"
        >
          Reintentar
        </button>
      </div>
    </div>

    <div
      v-else-if="loaded && mapPoints.length === 0"
      class="absolute inset-0 z-20 flex items-center justify-center px-4"
    >
      <div class="pointer-events-auto flex w-full max-w-md flex-col items-center gap-3 rounded-3xl border border-white/70 bg-[#FFFAF6] p-6 text-center shadow-[0_22px_60px_-18px_rgba(64,35,24,0.45)]">
        <span class="material-symbols-outlined text-[34px] text-[#B9A99B]">location_off</span>
        <h2 class="font-headline-md text-[18px] font-bold text-[#402318]">
          No hay compradores en {{ radiusKm }} km
        </h2>
        <p class="font-label-md text-[11px] text-[#7A6558]">
          Prueba con otra variedad, quita los filtros o amplía el radio de búsqueda.
        </p>
        <div class="flex flex-wrap justify-center gap-2">
          <button
            v-if="selectedVarieties.length > 0"
            class="min-h-10 rounded-xl bg-[#F3E3D8] px-4 font-label-lg text-label-lg font-bold text-[#783719] transition-colors hover:bg-[#EBD6C8]"
            type="button"
            @click="resetVarieties"
          >
            Quitar filtros
          </button>
          <button
            v-if="radiusKm < 1000"
            class="min-h-10 rounded-xl bg-[#783719] px-4 font-label-lg text-label-lg font-bold text-[#FFFAF6] transition-colors hover:bg-[#5E2B14]"
            type="button"
            @click="expandRadius"
          >
            Ampliar radio
          </button>
        </div>
      </div>
    </div>

    <Transition name="toast">
      <div
        v-if="toast"
        class="absolute bottom-24 left-1/2 z-50 flex max-w-[92vw] -translate-x-1/2 items-center gap-2 rounded-full bg-[#402318] px-4 py-2.5 text-[#FFFAF6] shadow-[0_14px_34px_-10px_rgba(64,35,24,0.6)]"
        role="status"
      >
        <span class="material-symbols-outlined text-[17px] text-[#9AF5C0]">my_location</span>
        <span class="truncate font-label-md text-[11px] font-semibold">{{ toast }}</span>
      </div>
    </Transition>
  </main>
</template>

<style scoped>
.toast-enter-active,
.toast-leave-active {
  transition: opacity 180ms ease, transform 180ms ease;
}

.toast-enter-from,
.toast-leave-to {
  opacity: 0;
  transform: translate(-50%, 8px);
}
</style>
