<script setup lang="ts">
import type { OfferCardProps } from '~/types'
import type { CoffeePoint, CoffeeVarietyFilter } from '~/types/coffee'
import { COFFEE_STATE_OPTIONS, PITALITO_CENTER } from '~/types/coffee'
import { distanceInKm, useGeolocation } from '~/composables/useGeolocation'
import { matchesVariety } from '~/services/coffeeBuyerService'
import { sortFilters, varietyFilters } from './data'
import OfferCard from './OfferCard.vue'

interface OfferListItem extends OfferCardProps {
  distanceKm: number
}

const props = withDefaults(defineProps<{ selectable?: boolean }>(), {
  selectable: false
})

const emit = defineEmits<{
  select: [buyerId: number]
}>()

const { buyers, loading, error, fetchBuyers } = useBuyers()
const { position } = useGeolocation()
const { coffeeState, setCoffeeState } = useCoffeeMap()

fetchBuyers(coffeeState.value)

watch(coffeeState, () => {
  void fetchBuyers(coffeeState.value)
})

const activeSort = ref<string>('Mejor precio')
const activeVariety = ref<string>('Todas las variedades')

const varietyFilterMap: Record<string, CoffeeVarietyFilter> = {
  'Todas las variedades': 'Todas',
  Castillo: 'Castillo',
  Caturra: 'Caturra',
  'Bourbon Rosado': 'Borbón Rosado',
  Geisha: 'Geisha'
}

const referencePoint = computed<CoffeePoint>(() =>
  position.value
    ? { latitude: position.value.latitude, longitude: position.value.longitude }
    : { latitude: PITALITO_CENTER[1], longitude: PITALITO_CENTER[0] }
)

const offers = computed<OfferListItem[]>(() => {
  const reference = referencePoint.value
  const varietyFilter = varietyFilterMap[activeVariety.value] ?? 'Todas'

  const list = buyers.value.flatMap((buyer): OfferListItem[] => {
    const offer = buyer.price_offers?.[0]

    if (!offer) {
      return []
    }

    const point: CoffeePoint = {
      latitude: Number(buyer.latitude),
      longitude: Number(buyer.longitude)
    }

    return [{
      buyerId: buyer.id,
      buyerName: buyer.name,
      price: offer.price_per_kg,
      unit: offer.unit,
      variety: offer.coffee_variety?.name ?? 'Sin variedad',
      updatedAt: offer.updated_at,
      distanceKm: distanceInKm(reference, point)
    }]
  }).filter(item => matchesVariety(item.variety, varietyFilter))

  return [...list].sort((a, b) => {
    if (activeSort.value === 'Más cercano') {
      return a.distanceKm - b.distanceKm
    }

    return Number(b.price) - Number(a.price)
  })
})
</script>

<template>
  <main class="flex flex-col relative w-full pt-4 pb-28 bg-background min-h-screen md:min-h-0 md:pb-6">
    <div class="flex flex-col w-full max-w-7xl mx-auto lg:px-8">
      <div class="px-margin pt-space-sm pb-space-xs flex items-center justify-between">
        <div class="flex items-center gap-space-xs">
          <span class="inline-flex w-2.5 h-2.5 rounded-full bg-secondary animate-pulse" />
          <span class="font-headline-md text-headline-md text-on-surface lg:text-display-lg-mobile">Mercado Huila Sur</span>
        </div>
        <div class="flex items-center gap-space-xs px-2.5 py-1 rounded-full bg-surface-container shadow-sm">
          <span class="material-symbols-outlined text-label-md text-secondary" style="font-variation-settings: 'FILL' 1">verified</span>
          <span class="font-label-md text-label-md text-on-surface-variant font-bold">4 Puntos activos</span>
        </div>
      </div>

      <div class="mx-margin mb-space-md flex flex-col gap-1.5">
        <span class="font-label-md text-label-md text-on-surface-variant font-bold uppercase tracking-wider">Estado del café</span>
        <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar py-0.5">
          <button
            v-for="state in COFFEE_STATE_OPTIONS"
            :key="state.value"
            class="shrink-0 px-3.5 py-1.5 rounded-full font-label-md text-label-md transition-all"
            :class="coffeeState === state.value
              ? 'bg-secondary text-on-secondary shadow-sm font-bold'
              : 'bg-surface-container text-on-surface hover:bg-surface-container-high font-semibold'"
            type="button"
            :aria-pressed="coffeeState === state.value"
            @click="setCoffeeState(state.value)"
          >
            {{ state.label }}
          </button>
        </div>
      </div>

      <div class="mx-margin mb-space-md p-space-sm rounded-xl bg-surface-container-high shadow-sm flex flex-col gap-space-xs">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-space-xs">
            <span class="material-symbols-outlined text-body-md text-primary">analytics</span>
            <span class="font-label-md text-label-md font-bold uppercase tracking-wider text-primary">Indicadores FNC Hoy</span>
          </div>
          <span class="px-2 py-0.5 rounded-full bg-secondary text-on-secondary font-label-md text-label-md font-bold flex items-center gap-0.5">
            <span class="material-symbols-outlined text-xs">arrow_upward</span> +2.4% NY
          </span>
        </div>
        <div class="flex flex-wrap items-baseline gap-x-space-sm gap-y-0.5">
          <span class="font-body-md text-body-md font-bold text-on-surface">Base FNC Carga (125kg): <span class="text-primary">$1.885.000</span></span>
          <span class="font-label-md text-label-md text-on-surface-variant">· TRM: $4.180 COP</span>
        </div>
      </div>

      <div class="px-margin flex flex-col gap-space-sm mb-space-md">
        <div class="flex items-center justify-between bg-surface-container p-1 rounded-xl shadow-sm">
          <span class="font-label-md text-label-md text-on-surface-variant pl-space-xs font-bold">Unidad visualizada:</span>
          <div class="flex items-center gap-1 bg-surface-container-lowest p-0.5 rounded-lg shadow-sm">
            <button class="px-3 py-1.5 rounded-md font-label-lg text-label-lg transition-all bg-primary text-on-primary font-bold shadow-sm" type="button">
              $ / Kilo (kg)
            </button>
            <button class="px-3 py-1.5 rounded-md font-label-lg text-label-lg transition-all text-on-surface-variant hover:text-on-surface font-semibold" type="button">
              $ / Arroba (@)
            </button>
          </div>
        </div>

        <div class="flex items-center gap-space-xs overflow-x-auto no-scrollbar py-0.5">
          <button
            v-for="filter in sortFilters"
            :key="filter.label"
            class="shrink-0 px-3.5 py-1.5 rounded-full font-label-md text-label-md transition-all flex items-center gap-1"
            :class="activeSort === filter.label
              ? 'bg-secondary text-on-secondary shadow-sm font-bold'
              : 'bg-surface-container text-on-surface hover:bg-surface-container-high font-semibold'"
            type="button"
            :aria-pressed="activeSort === filter.label"
            @click="activeSort = filter.label"
          >
            <span
              v-if="filter.icon"
              class="material-symbols-outlined text-sm"
              style="font-variation-settings: 'FILL' 1"
            >{{ filter.icon }}</span>
            {{ filter.label }}
          </button>
        </div>

        <div class="flex items-center gap-space-xs overflow-x-auto no-scrollbar py-0.5">
          <button
            v-for="filter in varietyFilters"
            :key="filter.label"
            class="shrink-0 px-3 py-1 rounded-full font-label-md text-label-md"
            :class="activeVariety === filter.label
              ? 'bg-primary text-on-primary font-bold'
              : 'bg-surface-container text-on-surface hover:bg-surface-container-high font-medium'"
            type="button"
            :aria-pressed="activeVariety === filter.label"
            @click="activeVariety = filter.label"
          >
            {{ filter.label }}
          </button>
        </div>
      </div>

      <div class="px-margin flex flex-col gap-space-md pb-space-xl">
        <template v-if="loading">
          <div
            v-for="n in 6"
            :key="`skeleton-${n}`"
            class="rounded-2xl p-space-md bg-surface-container-lowest shadow-sm flex flex-col gap-space-sm animate-pulse"
          >
            <div class="flex items-start justify-between gap-space-sm">
              <div class="h-5 rounded-md bg-surface-container-high w-2/3" />
              <div class="h-4 rounded-md bg-surface-container-high w-16" />
            </div>
            <div class="h-12 rounded-xl bg-surface-container-high" />
            <div class="h-5 rounded-full bg-surface-container-high w-24" />
            <div class="h-12 rounded-xl bg-surface-container-high" />
          </div>
        </template>

        <div v-else-if="error" class="rounded-xl bg-error-container text-on-error-container p-space-md flex flex-col gap-space-sm md:col-span-2 lg:col-span-3">
          <p class="font-label-lg text-label-lg font-bold">No pudimos cargar los precios</p>
          <p class="font-label-md text-label-md">{{ error.message }}</p>
          <button
            class="self-start min-h-[44px] px-space-md rounded-lg bg-primary text-on-primary font-label-lg text-label-lg font-bold active:scale-95 transition-all"
            type="button"
            @click="fetchBuyers(coffeeState)"
          >
            Reintentar
          </button>
        </div>

        <p v-else-if="offers.length === 0" class="font-label-lg text-label-lg text-on-surface-variant py-space-xl md:col-span-2 lg:col-span-3">
          No hay ofertas vigentes por ahora.
        </p>

        <OfferCard
          v-for="offer in offers"
          :key="offer.buyerName"
          v-bind="offer"
          :selectable="props.selectable"
          @select="emit('select', $event)"
        />
      </div>

      <div class="mx-margin mb-space-lg p-space-sm rounded-xl bg-primary text-on-primary flex items-center justify-between shadow-sm md:col-span-2 lg:col-span-3">
        <div class="flex items-center gap-space-xs min-w-0">
          <span class="w-2.5 h-2.5 rounded-full bg-secondary-fixed shrink-0" />
          <span class="font-label-md text-label-md truncate">Precios locales actualizados · Modo offline sincronizado</span>
        </div>
        <span class="material-symbols-outlined text-body-md shrink-0">wifi_off</span>
      </div>
    </div>
  </main>
</template>
