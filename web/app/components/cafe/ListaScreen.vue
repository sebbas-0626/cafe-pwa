<script setup lang="ts">
import type { OfferCardProps } from '~/types'
import { sortFilters, varietyFilters } from './data'
import OfferCard from './OfferCard.vue'

const { buyers, loading, error, fetchBuyers } = useBuyers()

await fetchBuyers()

const offers = computed<OfferCardProps[]>(() =>
  buyers.value.flatMap((buyer) => {
    const offer = buyer.price_offers?.[0]

    if (!offer) {
      return []
    }

    return [{
      buyerName: buyer.name,
      price: offer.price_per_kg,
      unit: offer.unit,
      variety: offer.coffee_variety?.name ?? 'Sin variedad',
      updatedAt: offer.updated_at
    }]
  })
)
</script>

<template>
  <main class="flex flex-col relative w-full pt-16 pb-28 bg-background min-h-screen">
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
            :class="filter.active
              ? 'bg-secondary text-on-secondary shadow-sm font-bold'
              : 'bg-surface-container text-on-surface hover:bg-surface-container-high font-semibold'"
            type="button"
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
            :class="filter.active
              ? 'bg-primary text-on-primary font-bold'
              : 'bg-surface-container text-on-surface hover:bg-surface-container-high font-medium'"
            type="button"
          >
            {{ filter.label }}
          </button>
        </div>
      </div>

      <div class="px-margin flex flex-col gap-space-md pb-space-xl grid-cols-1 md:grid md:grid-cols-2 lg:grid-cols-3">
        <div v-if="loading" class="flex items-center justify-center gap-2 py-space-xl text-on-surface-variant font-label-lg text-label-lg">
          <span class="material-symbols-outlined animate-spin">progress_activity</span>
          Cargando precios…
        </div>

        <div v-else-if="error" class="rounded-xl bg-error-container text-on-error-container p-space-md flex flex-col gap-space-sm md:col-span-2 lg:col-span-3">
          <p class="font-label-lg text-label-lg font-bold">No pudimos cargar los precios</p>
          <p class="font-label-md text-label-md">{{ error.message }}</p>
          <button
            class="self-start min-h-[44px] px-space-md rounded-lg bg-primary text-on-primary font-label-lg text-label-lg font-bold active:scale-95 transition-all"
            type="button"
            @click="fetchBuyers()"
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
        />

        <div class="rounded-2xl p-space-md bg-surface-container shadow-md flex flex-col gap-space-sm md:col-span-2 lg:col-span-3">
          <div class="flex items-center gap-space-sm">
            <div class="w-12 h-12 rounded-xl bg-primary text-on-primary flex items-center justify-center shrink-0 shadow-sm">
              <span class="material-symbols-outlined text-2xl">calculate</span>
            </div>
            <div class="flex flex-col">
              <span class="font-headline-md text-headline-md font-bold text-on-surface">Calculadora de Lote</span>
              <span class="font-label-md text-label-md text-on-surface-variant">Liquida arrobas o kilos con el mejor precio</span>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-space-sm pt-space-xs">
            <div class="flex flex-col gap-1">
              <label class="font-label-md text-label-md text-on-surface-variant font-bold" for="input-arrobas">Tus Arrobas (@)</label>
              <div class="flex items-center bg-surface-container-lowest rounded-xl p-1 shadow-sm">
                <button class="w-10 h-10 rounded-lg flex items-center justify-center bg-surface-container hover:bg-surface-container-high text-on-surface font-bold text-lg active:scale-90 transition-all" type="button">-</button>
                <input id="input-arrobas" class="w-full text-center bg-transparent font-headline-md text-headline-md font-bold text-on-surface focus:outline-none" type="number" value="20">
                <button class="w-10 h-10 rounded-lg flex items-center justify-center bg-surface-container hover:bg-surface-container-high text-on-surface font-bold text-lg active:scale-90 transition-all" type="button">+</button>
              </div>
            </div>
            <div class="flex flex-col gap-1 justify-end">
              <label class="font-label-md text-label-md text-secondary font-bold">Valor Estimado</label>
              <div class="h-12 bg-secondary-container rounded-xl px-space-sm flex items-center justify-center shadow-sm">
                <span class="font-headline-md text-headline-md font-bold text-on-secondary-container truncate">$ 3.800.000</span>
              </div>
            </div>
          </div>
          <button class="w-full mt-1 min-h-[48px] rounded-xl bg-primary text-on-primary font-label-lg text-label-lg font-bold flex items-center justify-center gap-space-xs shadow-sm active:scale-98 transition-all" type="button">
            <span class="material-symbols-outlined text-body-lg">receipt_long</span>
            <span>Simular con factor de rendimiento</span>
          </button>
        </div>
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

  <nav class="fixed bottom-0 w-full z-50 pb-safe bg-surface/90 backdrop-blur-xl shadow-[0_-4px_16px_rgba(68,21,10,0.06)]">
    <div class="flex justify-around items-center h-20 px-space-sm max-w-md mx-auto">
      <a class="flex flex-col items-center justify-center gap-space-xs min-h-[48px] min-w-[64px] rounded-xl text-on-surface-variant hover:text-on-surface transition-all" href="/">
        <span class="material-symbols-outlined text-headline-md">explore</span>
        <span class="font-label-md text-label-md">Mapa</span>
      </a>
      <a class="flex flex-col items-center justify-center gap-space-xs min-h-[48px] min-w-[64px] rounded-xl transition-all relative text-primary font-bold" aria-current="page" href="/lista">
        <div class="relative flex items-center justify-center">
          <span class="material-symbols-outlined text-headline-md">trending_up</span>
          <span class="absolute -top-1 -right-3 px-1.5 py-0.2 rounded-full bg-secondary text-on-secondary font-label-md text-[10px] leading-tight font-bold tracking-tight uppercase">En vivo</span>
        </div>
        <span class="font-label-md text-label-md">Precios</span>
      </a>
      <a class="flex flex-col items-center justify-center gap-space-xs min-h-[48px] min-w-[64px] rounded-xl text-on-surface-variant hover:text-on-surface transition-all" href="/cooperativa/1">
        <span class="material-symbols-outlined text-headline-md">store</span>
        <span class="font-label-md text-label-md">Cooperativas</span>
      </a>
    </div>
  </nav>
</template>
