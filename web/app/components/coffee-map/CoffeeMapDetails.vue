<script setup lang="ts">
import type { CoffeeMapPoint, CoffeeUserLocation } from '~/types/coffee'
import { BUYER_TYPE_META } from '~/types/coffee'
import { formatDistance, formatPricePerKg, formatPriceUpdatedAt } from '~/services/coffeeBuyerService'

const props = defineProps<{
  point: CoffeeMapPoint
  origin: CoffeeUserLocation | null
}>()

const emit = defineEmits<{ close: [] }>()

const typeMeta = computed(() => BUYER_TYPE_META[props.point.buyer.type] ?? BUYER_TYPE_META.private_buyer)

const directionsUrl = computed(() => {
  const destination = `${props.point.buyer.latitude},${props.point.buyer.longitude}`
  const from = props.origin ? `${props.origin.latitude},${props.origin.longitude}` : ''

  return `https://www.openstreetmap.org/directions?engine=fossgis_osrm_car&route=${from};${destination}`
})

const distanceHint = computed(() => (
  props.origin ? 'desde tu ubicación' : 'desde Pitalito'
))
</script>

<template>
  <aside class="coffee-details pointer-events-auto relative flex max-h-[82dvh] w-full flex-col overflow-y-auto rounded-t-3xl border border-white/70 bg-[#FFFAF6] px-4 pb-[max(1rem,env(safe-area-inset-bottom))] pt-2.5 shadow-[0_-14px_44px_-12px_rgba(64,35,24,0.4)] md:max-h-none md:w-[520px] md:rounded-3xl md:p-6 md:shadow-[0_20px_60px_-18px_rgba(64,35,24,0.45)]">
    <div class="mx-auto mb-2 h-1.5 w-12 shrink-0 rounded-full bg-[#DCC1B8]/80 md:hidden" />

    <button
      class="absolute right-3 top-3 flex min-h-9 min-w-9 items-center justify-center rounded-full bg-[#F3E3D8]/80 text-[#402318] transition-colors hover:bg-[#EBD6C8] md:right-5 md:top-5"
      type="button"
      aria-label="Cerrar información del comprador"
      @click="emit('close')"
    >
      <span class="material-symbols-outlined text-[19px]">close</span>
    </button>

    <div class="flex items-start gap-3 pr-8 md:gap-5 md:pr-10">
      <div class="grid h-16 w-16 shrink-0 place-items-center rounded-full bg-[#F3E3D8] text-[#783719] md:h-[86px] md:w-[86px]">
        <span class="material-symbols-outlined text-[30px] md:text-[40px]" style="font-variation-settings: 'FILL' 1">
          {{ point.isBest ? 'eco' : typeMeta.icon }}
        </span>
      </div>

      <div class="flex min-w-0 flex-1 flex-col">
        <div class="flex flex-wrap items-center gap-1.5">
          <span class="rounded-full bg-[#F3E3D8] px-2 py-0.5 font-label-md text-[10px] font-bold text-[#783719]">
            {{ typeMeta.label }}
          </span>
          <span
            v-if="point.isBest"
            class="flex items-center gap-1 rounded-full bg-[#E3F4EB] px-2 py-0.5 font-label-md text-[10px] font-bold text-[#087D50]"
          >
            <span class="material-symbols-outlined text-[12px]" style="font-variation-settings: 'FILL' 1">star</span>
            Mejor precio
          </span>
        </div>

        <h2 class="mt-1 font-headline-lg-mobile text-[19px] font-bold leading-tight text-[#402318] md:text-[23px]">
          {{ point.buyer.name }}
        </h2>

        <div class="mt-2 flex flex-wrap items-center gap-2">
          <span
            class="inline-flex items-baseline gap-1 rounded-lg px-2.5 py-1 font-price-hero-mobile text-[20px] font-bold leading-none text-white md:text-[23px]"
            :class="point.isBest ? 'bg-[#087D50]' : 'bg-[#783719]'"
          >
            {{ formatPricePerKg(point.pricePerKg) }}
            <span class="text-[10px] font-semibold opacity-80">/{{ point.offer.unit }}</span>
          </span>
        </div>

        <div class="mt-2 flex flex-wrap items-center gap-x-2 gap-y-1 text-[#7A6558]">
          <span class="flex min-w-0 items-center gap-1 font-label-md text-[11px]">
            <span class="material-symbols-outlined text-[14px] text-[#783719]" style="font-variation-settings: 'FILL' 1">location_on</span>
            <span class="truncate">{{ point.buyer.address ?? 'Dirección no disponible' }}</span>
          </span>
          <span class="rounded-full bg-[#F3E3D8] px-2 py-0.5 font-label-md text-[10px] font-bold text-[#402318]">
            {{ formatDistance(point.distanceKm) }}
          </span>
        </div>
      </div>
    </div>

    <div class="mt-4 border-t border-[#402318]/10 pt-3 md:mt-5">
      <div class="flex flex-col gap-2">
        <div class="flex items-start gap-2 font-label-md text-[11px] text-[#402318] md:text-[12px]">
          <span class="material-symbols-outlined text-[16px] text-[#783719]" style="font-variation-settings: 'FILL' 1">eco</span>
          <span>
            <span class="font-bold">Variedades:</span>
            {{ point.buyer.varieties.join(' · ') }}
          </span>
        </div>
        <div class="flex items-start gap-2 font-label-md text-[11px] text-[#402318] md:text-[12px]">
          <span class="material-symbols-outlined text-[16px] text-[#783719]">schedule</span>
          <span>
            <span class="font-bold">Actualizado:</span>
            {{ formatPriceUpdatedAt(point.offer.updatedAt) }}
          </span>
        </div>
      </div>

      <div class="mt-3 flex items-center justify-between gap-3">
        <div class="flex min-w-0 items-center gap-1.5 font-label-md text-[10px] text-[#7A6558]">
          <span class="material-symbols-outlined text-[14px] text-[#087D50]">near_me</span>
          <span class="truncate">A {{ formatDistance(point.distanceKm) }} {{ distanceHint }}</span>
        </div>

        <a
          class="flex min-h-11 shrink-0 items-center justify-center gap-2 rounded-xl bg-[#783719] px-4 font-label-lg text-label-lg font-bold text-[#FFFAF6] shadow-[0_6px_16px_-6px_rgba(120,55,25,0.6)] transition-colors hover:bg-[#5E2B14] active:scale-95"
          :href="directionsUrl"
          target="_blank"
          rel="noopener noreferrer"
        >
          <span class="material-symbols-outlined text-[17px]" style="font-variation-settings: 'FILL' 1">navigation</span>
          Cómo llegar
        </a>
      </div>
    </div>
  </aside>
</template>
