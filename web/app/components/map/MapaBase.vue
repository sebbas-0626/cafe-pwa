<script setup lang="ts">
import 'maplibre-gl/dist/maplibre-gl.css'
import type { Map, Marker } from 'maplibre-gl'
import type { Buyer } from '~/types'

const props = withDefaults(defineProps<{
  buyers?: Buyer[]
  center?: [number, number]
  zoom?: number
}>(), {
  buyers: () => [],
  center: () => [-75.6, 2.9],
  zoom: 6
})

const emit = defineEmits<{ select: [buyer: Buyer] }>()

const container = ref<HTMLDivElement | null>(null)
const map = shallowRef<Map | null>(null)
const markers = shallowRef<Marker[]>([])

async function renderMarkers(): Promise<void> {
  if (!map.value) {
    return
  }

  const { Marker, Popup } = await import('maplibre-gl')

  markers.value.forEach(marker => marker.remove())
  markers.value = []

  props.buyers.forEach((buyer) => {
    const offer = buyer.price_offers?.[0]
    const price = offer ? `$ ${Number(offer.price_per_kg).toLocaleString('es-CO')}` : buyer.name

    const element = document.createElement('button')
    element.type = 'button'
    element.className = 'px-2.5 py-1 rounded-full bg-surface text-on-surface text-label-lg font-bold shadow-[0_4px_12px_rgba(68,21,10,0.18)] hover:bg-primary hover:text-on-primary transition-colors'
    element.textContent = price

    const popup = new Popup({ offset: 20, closeButton: false }).setHTML(
      `<div class="flex flex-col gap-1">
        <span class="font-label-lg text-label-lg font-bold text-on-surface">${buyer.name}</span>
        <span class="font-label-md text-label-md text-primary font-bold">${price}${offer ? ` / ${offer.unit}` : ''}</span>
        ${buyer.phone ? `<a class="font-label-md text-label-md text-secondary font-bold" href="tel:${buyer.phone.replace(/\D/g, '')}">Llamar ${buyer.phone}</a>` : ''}
      </div>`
    )

    element.addEventListener('click', () => {
      map.value?.flyTo({ center: [Number(buyer.longitude), Number(buyer.latitude)], zoom: 12 })
      emit('select', buyer)
    })

    const marker = new Marker({ element, anchor: 'bottom' })
      .setLngLat([Number(buyer.longitude), Number(buyer.latitude)])
      .setPopup(popup)
      .addTo(map.value!)

    markers.value = [...markers.value, marker]
  })
}

onMounted(async () => {
  if (!container.value) {
    return
  }

  const maplibregl = await import('maplibre-gl')

  map.value = new maplibregl.Map({
    container: container.value,
    style: 'https://tiles.openfreemap.org/styles/liberty',
    center: props.center,
    zoom: props.zoom,
    attributionControl: { compact: true }
  })

  map.value.addControl(new maplibregl.NavigationControl({ showCompass: false }), 'top-right')

  await new Promise<void>((resolve) => {
    map.value?.once('load', () => resolve())
  })

  await renderMarkers()
})

watch(() => props.buyers, () => {
  void renderMarkers()
}, { deep: true })

onBeforeUnmount(() => {
  markers.value.forEach(marker => marker.remove())
  markers.value = []
  map.value?.remove()
  map.value = null
})
</script>

<template>
  <div ref="container" class="w-full h-full" />
</template>
