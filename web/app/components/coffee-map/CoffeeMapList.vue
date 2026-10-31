<script setup lang="ts">
import type { CoffeeBuyerSource, CoffeeMapPoint } from '~/types/coffee'
import { BUYER_TYPE_META } from '~/types/coffee'
import { formatDistance, formatPricePerKg, formatPriceUpdatedAt } from '~/services/coffeeBuyerService'

const props = defineProps<{
  points: CoffeeMapPoint[]
  selectedId: number | null
  source: CoffeeBuyerSource | null
  loading: boolean
  error: string | null
}>()

const emit = defineEmits<{
  select: [buyerId: number]
  close: []
  retry: []
}>()

const sortedPoints = computed(() => (
  [...props.points].sort((left, right) => right.pricePerKg - left.pricePerKg)
))
</script>

<template>
  <section class="flex h-full w-full flex-col overflow-hidden rounded-3xl border border-white/70 bg-[#FFFAF6] shadow-[0_24px_60px_-20px_rgba(64,35,24,0.5)]">
    <header class="flex items-start justify-between gap-3 border-b border-[#402318]/10 px-4 py-4">
      <div class="flex min-w-0 flex-col">
        <span class="font-headline-md text-[18px] font-bold leading-tight text-[#402318]">Compradores cerca</span>
        <span class="mt-0.5 flex items-center gap-1.5 font-label-md text-[11px] text-[#7A6558]">
          {{ sortedPoints.length }} {{ sortedPoints.length === 1 ? 'punto activo' : 'puntos activos' }}
          <span v-if="source === 'mock'" class="rounded-full bg-[#F3E3D8] px-1.5 py-0.5 text-[9px] font-bold text-[#783719]">Demo</span>
        </span>
      </div>
      <button
        class="flex min-h-9 min-w-9 shrink-0 items-center justify-center rounded-full bg-[#F3E3D8] text-[#402318] transition-colors hover:bg-[#EBD6C8]"
        type="button"
        aria-label="Volver al mapa"
        @click="emit('close')"
      >
        <span class="material-symbols-outlined text-[19px]">close</span>
      </button>
    </header>

    <div class="coffee-list flex flex-1 flex-col gap-2 overflow-y-auto p-2.5">
      <div v-if="loading" class="flex flex-1 flex-col items-center justify-center gap-2 py-16 text-[#7A6558]">
        <span class="material-symbols-outlined animate-spin text-[26px] text-[#783719]">progress_activity</span>
        <span class="font-label-lg text-label-lg font-semibold">Cargando compradores…</span>
      </div>

      <div v-else-if="error" class="m-1 flex flex-col gap-3 rounded-2xl bg-[#FDEBE4] p-4">
        <p class="font-label-lg text-label-lg font-bold text-[#7A2E18]">No pudimos cargar los compradores</p>
        <p class="font-label-md text-[11px] text-[#7A2E18]/80">{{ error }}</p>
        <button
          class="min-h-10 self-start rounded-xl bg-[#783719] px-3 font-label-lg text-label-lg font-bold text-[#FFFAF6]"
          type="button"
          @click="emit('retry')"
        >
          Reintentar
        </button>
      </div>

      <div v-else-if="sortedPoints.length === 0" class="flex flex-1 flex-col items-center justify-center gap-2 px-6 py-16 text-center">
        <span class="material-symbols-outlined text-[34px] text-[#B9A99B]">location_off</span>
        <p class="font-label-lg text-label-lg font-bold text-[#402318]">No hay compradores con estos filtros</p>
        <p class="font-label-md text-[11px] text-[#7A6558]">Prueba otra variedad o amplía el radio de búsqueda.</p>
      </div>

      <template v-else>
        <button
          v-for="point in sortedPoints"
          :key="point.buyer.id"
          class="flex w-full items-center gap-3 rounded-2xl border p-2.5 text-left transition-colors"
          :class="point.buyer.id === selectedId
            ? 'border-[#783719]/30 bg-[#FFF0E7]'
            : 'border-transparent bg-[#FBF3EA] hover:bg-[#FFF0E7]'"
          type="button"
          @click="emit('select', point.buyer.id)"
        >
          <span
            class="grid h-10 w-10 shrink-0 place-items-center rounded-full text-white"
            :class="point.isBest ? 'bg-[#087D50]' : 'bg-[#783719]'"
          >
            <span class="material-symbols-outlined text-[19px]" style="font-variation-settings: 'FILL' 1">
              {{ point.isBest ? 'eco' : BUYER_TYPE_META[point.buyer.type].icon }}
            </span>
          </span>

          <span class="flex min-w-0 flex-1 flex-col">
            <span class="line-clamp-2 font-label-lg text-[13px] font-bold text-[#402318]">{{ point.buyer.name }}</span>
            <span class="truncate font-label-md text-[10px] text-[#7A6558]">
              {{ BUYER_TYPE_META[point.buyer.type].label }} · {{ point.offer.variety }}
            </span>
            <span class="mt-0.5 flex items-center gap-1 truncate font-label-md text-[10px] text-[#7A6558]">
              <span class="material-symbols-outlined text-[12px] text-[#783719]">near_me</span>
              {{ formatDistance(point.distanceKm) }}
              <span aria-hidden="true">·</span>
              {{ formatPriceUpdatedAt(point.offer.updatedAt) }}
            </span>
          </span>

          <span class="flex shrink-0 flex-col items-end">
            <span
              class="rounded-lg px-2 py-1 font-label-lg text-[12px] font-bold text-white"
              :class="point.isBest ? 'bg-[#087D50]' : 'bg-[#783719]'"
            >{{ formatPricePerKg(point.pricePerKg) }}</span>
            <span v-if="point.isBest" class="mt-1 text-[9px] font-bold text-[#087D50]">Mejor precio</span>
          </span>
        </button>
      </template>
    </div>
  </section>
</template>

<style scoped>
.coffee-list {
  scrollbar-width: thin;
  scrollbar-color: #dcc1b8 transparent;
}
</style>
