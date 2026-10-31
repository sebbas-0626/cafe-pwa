<script setup lang="ts">
import 'maplibre-gl/dist/maplibre-gl.css'
import maplibreWorkerUrl from 'maplibre-gl/dist/maplibre-gl-worker.mjs?worker&url'
import type { FeatureCollection, Point } from 'geojson'
import type { GeoJSONSource, Map as MapLibreMap, Marker as MapLibreMarker } from 'maplibre-gl'
import { createApp, type App } from 'vue'
import type { CoffeeMapPoint, CoffeeUserLocation } from '~/types/coffee'
import { formatPricePerKg } from '~/services/coffeeBuyerService'
import CoffeeMapMarker from './CoffeeMapMarker.vue'

const props = withDefaults(defineProps<{
  points: CoffeeMapPoint[]
  selectedBuyerId: number | null
  center: [number, number]
  userLocation: CoffeeUserLocation | null
  showLabels?: boolean
  showWater?: boolean
}>(), {
  showLabels: true,
  showWater: true
})

const emit = defineEmits<{ select: [buyerId: number] }>()

const MAP_STYLE = 'https://tiles.openfreemap.org/styles/positron'
const CLUSTER_THRESHOLD = 60
const LABEL_SOURCE_LAYERS = new Set(['place', 'transportation_name', 'water_name', 'waterway', 'aerodrome_label'])
const WATER_SOURCE_LAYERS = new Set(['water', 'waterway', 'water_name'])

const container = ref<HTMLDivElement | null>(null)
const map = shallowRef<MapLibreMap | null>(null)
const ready = ref(false)

let markerInstances: { marker: MapLibreMarker; app: App }[] = []
let userMarker: MapLibreMarker | null = null
let clusterInitialized = false
let renderVersion = 0

type StyleLayerLike = {
  id: string
  type: string
  'source-layer'?: string
}

function sourceLayerOf(layer: StyleLayerLike): string {
  return layer['source-layer'] ?? ''
}

type PaintSetter = {
  setPaintProperty: (layerId: string, property: string, value: unknown) => void
}

type LayoutSetter = {
  setLayoutProperty: (layerId: string, property: string, value: unknown) => void
}

function setPaint(target: MapLibreMap, layerId: string, property: string, value: unknown): void {
  try {
    (target as unknown as PaintSetter).setPaintProperty(layerId, property, value)
  } catch {
    return
  }
}

function setLayout(target: MapLibreMap, layerId: string, property: string, value: unknown): void {
  try {
    (target as unknown as LayoutSetter).setLayoutProperty(layerId, property, value)
  } catch {
    return
  }
}

function applyWarmStyle(target: MapLibreMap): void {
  const layers = (target.getStyle().layers ?? []) as unknown as StyleLayerLike[]

  layers.forEach((layer) => {
    const sourceLayer = sourceLayerOf(layer)

    if (layer.type === 'background') {
      setPaint(target, layer.id, 'background-color', '#E9DFD0')
      return
    }

    if (layer.type === 'fill') {
      if (sourceLayer === 'water') {
        setPaint(target, layer.id, 'fill-color', '#A7C9BC')
        setPaint(target, layer.id, 'fill-opacity', 0.94)
      } else if (sourceLayer === 'park') {
        setPaint(target, layer.id, 'fill-color', '#DDE1C6')
        setPaint(target, layer.id, 'fill-opacity', 0.7)
      } else if (sourceLayer === 'landcover') {
        setPaint(target, layer.id, 'fill-color', '#DFE1C8')
        setPaint(target, layer.id, 'fill-opacity', 0.55)
      } else if (sourceLayer === 'landuse') {
        setPaint(target, layer.id, 'fill-color', '#E3D7C6')
        setPaint(target, layer.id, 'fill-opacity', 0.5)
      } else if (sourceLayer === 'building') {
        setPaint(target, layer.id, 'fill-color', '#E1D2C1')
        setPaint(target, layer.id, 'fill-opacity', 0.62)
      } else if (sourceLayer === 'aeroway') {
        setPaint(target, layer.id, 'fill-color', '#D8CCBA')
      }
      return
    }

    if (layer.type === 'line') {
      if (sourceLayer === 'waterway') {
        setPaint(target, layer.id, 'line-color', '#A7C9BC')
        setPaint(target, layer.id, 'line-opacity', 0.95)
      } else if (sourceLayer === 'transportation') {
        const color = layer.id.includes('casing')
          ? '#D9CDBB'
          : layer.id.includes('path')
            ? '#D3C6B2'
            : '#C9BFAF'

        setPaint(target, layer.id, 'line-color', color)
        setPaint(target, layer.id, 'line-opacity', 0.96)
      } else if (sourceLayer === 'boundary') {
        setPaint(target, layer.id, 'line-color', '#D4C2AC')
        setPaint(target, layer.id, 'line-opacity', 0.6)
      } else if (sourceLayer === 'railway') {
        setPaint(target, layer.id, 'line-color', '#CDBFAE')
        setPaint(target, layer.id, 'line-opacity', 0.7)
      } else if (sourceLayer === 'aeroway') {
        setPaint(target, layer.id, 'line-color', '#D8CCBA')
      }
      return
    }

    if (layer.type === 'symbol') {
      setPaint(target, layer.id, 'text-color', '#6B5446')
      setPaint(target, layer.id, 'text-halo-color', '#E9DFD0')
      setPaint(target, layer.id, 'text-halo-width', 1.4)

      if (WATER_SOURCE_LAYERS.has(sourceLayer)) {
        setPaint(target, layer.id, 'text-color', '#6F8F86')
      }
    }
  })
}

function applyLayerVisibility(target: MapLibreMap): void {
  const layers = (target.getStyle().layers ?? []) as unknown as StyleLayerLike[]

  layers.forEach((layer) => {
    const sourceLayer = sourceLayerOf(layer)
    const isLabel = LABEL_SOURCE_LAYERS.has(sourceLayer)
    const isWater = WATER_SOURCE_LAYERS.has(sourceLayer)

    if (isLabel || isWater) {
      const visible = (!isLabel || props.showLabels) && (!isWater || props.showWater)
      setLayout(target, layer.id, 'visibility', visible ? 'visible' : 'none')
    }
  })
}

function clearMarkers(): void {
  markerInstances.forEach(({ marker, app }) => {
    app.unmount()
    marker.remove()
  })
  markerInstances = []
}

function removeClusterLayers(): void {
  const target = map.value

  if (!target || !clusterInitialized) {
    return
  }

  ['coffee-cluster-count', 'coffee-clusters', 'coffee-point-prices', 'coffee-points'].forEach((layerId) => {
    if (target.getLayer(layerId)) {
      target.removeLayer(layerId)
    }
  })

  if (target.getSource('coffee-buyers')) {
    target.removeSource('coffee-buyers')
  }

  clusterInitialized = false
}

function buildClusterFeatureCollection(): FeatureCollection<Point, { id: number; priceLabel: string; best: boolean }> {
  return {
    type: 'FeatureCollection',
    features: props.points.map(point => ({
      type: 'Feature',
      geometry: {
        type: 'Point',
        coordinates: [point.buyer.longitude, point.buyer.latitude]
      },
      properties: {
        id: point.buyer.id,
        priceLabel: formatPricePerKg(point.pricePerKg),
        best: point.isBest
      }
    }))
  }
}

function renderClustered(): void {
  const target = map.value

  if (!target) {
    return
  }

  const data = buildClusterFeatureCollection()
  const existingSource = target.getSource('coffee-buyers') as GeoJSONSource | undefined

  if (existingSource) {
    existingSource.setData(data)
    return
  }

  target.addSource('coffee-buyers', {
    type: 'geojson',
    data,
    cluster: true,
    clusterRadius: 54,
    clusterMaxZoom: 13
  })

  target.addLayer({
    id: 'coffee-clusters',
    type: 'circle',
    source: 'coffee-buyers',
    filter: ['has', 'point_count'],
    paint: {
      'circle-color': '#783719',
      'circle-radius': ['step', ['get', 'point_count'], 18, 10, 24, 30, 30],
      'circle-stroke-color': '#FFFAF6',
      'circle-stroke-width': 3,
      'circle-opacity': 0.96
    }
  })

  target.addLayer({
    id: 'coffee-cluster-count',
    type: 'symbol',
    source: 'coffee-buyers',
    filter: ['has', 'point_count'],
    layout: {
      'text-field': ['get', 'point_count_abbreviated'],
      'text-size': 12
    },
    paint: {
      'text-color': '#FFFAF6',
      'text-halo-color': 'rgba(120, 55, 25, 0)',
      'text-halo-width': 0
    }
  })

  target.addLayer({
    id: 'coffee-points',
    type: 'circle',
    source: 'coffee-buyers',
    filter: ['!', ['has', 'point_count']],
    paint: {
      'circle-color': ['case', ['get', 'best'], '#087D50', '#783719'],
      'circle-radius': 9,
      'circle-stroke-color': '#FFFAF6',
      'circle-stroke-width': 2.5
    }
  })

  target.addLayer({
    id: 'coffee-point-prices',
    type: 'symbol',
    source: 'coffee-buyers',
    filter: ['!', ['has', 'point_count']],
    layout: {
      'text-field': ['get', 'priceLabel'],
      'text-size': 11,
      'text-offset': [0, -1.8],
      'text-anchor': 'bottom'
    },
    paint: {
      'text-color': '#402318',
      'text-halo-color': '#FFFAF6',
      'text-halo-width': 2
    }
  })

  target.on('click', 'coffee-clusters', (event) => {
    const feature = event.features?.[0]
    const clusterId = Number(feature?.properties?.cluster_id)

    if (!Number.isFinite(clusterId)) {
      return
    }

    const source = target.getSource('coffee-buyers') as GeoJSONSource | undefined

    void source?.getClusterExpansionZoom(clusterId).then((zoom) => {
      target.easeTo({ center: event.lngLat, zoom: zoom + 0.2 })
    })
  })

  target.on('click', 'coffee-points', (event) => {
    const buyerId = Number(event.features?.[0]?.properties?.id)

    if (Number.isFinite(buyerId)) {
      emit('select', buyerId)
    }
  })

  target.on('mouseenter', 'coffee-clusters', () => {
    target.getCanvas().style.cursor = 'pointer'
  })

  target.on('mouseleave', 'coffee-clusters', () => {
    target.getCanvas().style.cursor = ''
  })

  target.on('mouseenter', 'coffee-points', () => {
    target.getCanvas().style.cursor = 'pointer'
  })

  target.on('mouseleave', 'coffee-points', () => {
    target.getCanvas().style.cursor = ''
  })

  clusterInitialized = true
}

function fitToPoints(animate: boolean): void {
  const target = map.value

  if (!target || props.points.length === 0) {
    return
  }

  const coordinates = props.points.map(point => [point.buyer.longitude, point.buyer.latitude] as [number, number])
  const mobile = (container.value?.clientWidth ?? 1024) < 768
  const padding = mobile
    ? { top: 220, bottom: 280, left: 80, right: 80 }
    : { top: 200, bottom: 160, left: 80, right: 110 }

  if (coordinates.length === 1) {
    target.easeTo({ center: coordinates[0]!, zoom: 13.2, padding, duration: animate ? 600 : 0 })
    return
  }

  const bounds = coordinates.reduce<[[number, number], [number, number]]>((current, coordinate) => [
    [Math.min(current[0][0], coordinate[0]), Math.min(current[0][1], coordinate[1])],
    [Math.max(current[1][0], coordinate[0]), Math.max(current[1][1], coordinate[1])]
  ], [coordinates[0]!, coordinates[0]!])

  target.fitBounds(bounds, {
    padding,
    maxZoom: 13.2,
    duration: animate ? 650 : 0
  })
}

async function renderMarkers(): Promise<void> {
  const target = map.value

  if (!target || !ready.value) {
    return
  }

  const version = ++renderVersion
  clearMarkers()

  if (props.points.length === 0) {
    removeClusterLayers()
    return
  }

  if (props.points.length > CLUSTER_THRESHOLD) {
    renderClustered()
    return
  }

  removeClusterLayers()

  const { Marker } = await import('maplibre-gl')

  if (version !== renderVersion || !map.value) {
    return
  }

  props.points.forEach((point) => {
    const host = document.createElement('div')
    host.className = 'coffee-marker-host'
    host.style.zIndex = props.selectedBuyerId === point.buyer.id
      ? '6'
      : point.isBest
        ? '5'
        : '1'

    const app = createApp(CoffeeMapMarker, {
      point,
      isSelected: props.selectedBuyerId === point.buyer.id,
      onSelect: () => emit('select', point.buyer.id)
    })

    app.mount(host)

    const marker = new Marker({ element: host, anchor: 'bottom' })
      .setLngLat([point.buyer.longitude, point.buyer.latitude])
      .addTo(map.value!)

    markerInstances.push({ marker, app })
  })
}

function focusBuyer(buyerId: number): void {
  const target = map.value
  const point = props.points.find(item => item.buyer.id === buyerId)

  if (!target || !point) {
    return
  }

  target.flyTo({
    center: [point.buyer.longitude, point.buyer.latitude],
    zoom: Math.max(target.getZoom(), 12.2),
    duration: 700
  })
}

async function updateUserMarker(): Promise<void> {
  const target = map.value

  if (!target) {
    return
  }

  userMarker?.remove()
  userMarker = null

  if (!props.userLocation) {
    return
  }

  const { Marker } = await import('maplibre-gl')
  const element = document.createElement('div')
  element.className = 'coffee-user-marker'
  element.innerHTML = '<span class="coffee-user-marker__pulse"></span><span class="coffee-user-marker__dot"><span class="material-symbols-outlined">person_pin_circle</span></span>'

  userMarker = new Marker({ element, anchor: 'center' })
    .setLngLat([props.userLocation.longitude, props.userLocation.latitude])
    .addTo(target)
}

function zoomIn(): void {
  map.value?.zoomIn({ duration: 250 })
}

function zoomOut(): void {
  map.value?.zoomOut({ duration: 250 })
}

defineExpose({ zoomIn, zoomOut })

onMounted(async () => {
  if (!container.value) {
    return
  }

  const maplibregl = await import('maplibre-gl')

  maplibregl.setWorkerUrl(maplibreWorkerUrl)

  const instance = new maplibregl.Map({
    container: container.value,
    style: MAP_STYLE,
    center: props.center,
    zoom: 11.2,
    minZoom: 4,
    maxZoom: 17,
    attributionControl: false,
    dragRotate: false,
    pitchWithRotate: false
  })

  map.value = instance
  instance.addControl(new maplibregl.AttributionControl({ compact: true }), 'bottom-right')

  instance.on('style.load', () => {
    applyWarmStyle(instance)
    applyLayerVisibility(instance)
  })

  instance.once('load', () => {
    ready.value = true
    applyWarmStyle(instance)
    applyLayerVisibility(instance)
    void updateUserMarker()
    void renderMarkers()
    fitToPoints(false)
  })
})

watch(() => props.points, () => {
  void renderMarkers()
  fitToPoints(true)
}, { deep: true })

watch(() => props.selectedBuyerId, (buyerId) => {
  void renderMarkers()

  if (buyerId !== null) {
    focusBuyer(buyerId)
  }
})

watch(() => props.showLabels, () => {
  if (map.value) {
    applyLayerVisibility(map.value)
  }
})

watch(() => props.showWater, () => {
  if (map.value) {
    applyLayerVisibility(map.value)
  }
})

watch(() => props.userLocation, () => {
  void updateUserMarker()
})

watch(() => props.center, (center) => {
  map.value?.flyTo({ center, zoom: 12.6, duration: 900 })
})

onBeforeUnmount(() => {
  renderVersion += 1
  clearMarkers()
  userMarker?.remove()
  userMarker = null
  map.value?.remove()
  map.value = null
  ready.value = false
})
</script>

<template>
  <div ref="container" class="coffee-map h-full w-full" aria-label="Mapa interactivo de precios del café" />
</template>

<style scoped>
.coffee-map {
  background: #e9dfd0;
}

:deep(.coffee-marker-host) {
  display: flex;
  flex-direction: column;
  align-items: center;
}

:deep(.coffee-user-marker) {
  position: relative;
  display: grid;
  place-items: center;
  width: 26px;
  height: 26px;
}

:deep(.coffee-user-marker__pulse) {
  position: absolute;
  inset: -8px;
  border-radius: 9999px;
  background: rgba(8, 125, 80, 0.18);
  animation: user-pulse 2.2s ease-out infinite;
}

:deep(.coffee-user-marker__dot) {
  position: relative;
  display: grid;
  place-items: center;
  width: 26px;
  height: 26px;
  border: 2px solid #fffaf6;
  border-radius: 9999px;
  background: #087d50;
  color: #ffffff;
  box-shadow: 0 4px 12px rgba(8, 125, 80, 0.4);
}

:deep(.coffee-user-marker__dot .material-symbols-outlined) {
  font-size: 15px;
}

:deep(.maplibregl-ctrl-attrib) {
  border-radius: 8px;
  background: rgba(255, 250, 246, 0.88);
  color: #6b5446;
  font-family: Quicksand, sans-serif;
  font-size: 9px;
}

:deep(.maplibregl-ctrl-attrib a) {
  color: #6b5446;
}

@keyframes user-pulse {
  0% {
    transform: scale(0.75);
    opacity: 0.9;
  }
  100% {
    transform: scale(1.5);
    opacity: 0;
  }
}

@media (prefers-reduced-motion: reduce) {
  :deep(.coffee-user-marker__pulse) {
    animation: none;
  }
}
</style>
