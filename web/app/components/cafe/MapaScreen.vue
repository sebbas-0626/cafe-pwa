<script setup lang="ts">
import type { Buyer } from '~/types'
import { mapFilters } from './data'
import MapaBase from '~/components/map/MapaBase.vue'

const { buyers, fetchBuyers } = useBuyers()

await fetchBuyers()

const selected = ref<Buyer | null>(buyers.value.find(buyer => (buyer.price_offers?.length ?? 0) > 0) ?? buyers.value[0] ?? null)

const dateFormatter = new Intl.DateTimeFormat('es-CO', {
  day: '2-digit',
  month: 'short',
  hour: '2-digit',
  minute: '2-digit'
})

const sheet = computed(() => {
  const buyer = selected.value

  if (!buyer) {
    return null
  }

  const offers = buyer.price_offers ?? []
  const offer = offers[0]
  const phone = (buyer.phone ?? '').replace(/\D/g, '')

  return {
    name: buyer.name,
    location: buyer.address ?? 'Dirección no disponible',
    badge: offer ? 'Oferta vigente' : 'Sin oferta vigente',
    price: offer ? `$ ${Number(offer.price_per_kg).toLocaleString('es-CO')}` : '—',
    unit: offer ? `/ ${offer.unit}` : '',
    varieties: offers.map(item => item.coffee_variety?.name ?? 'Sin variedad'),
    updated: offer ? dateFormatter.format(new Date(offer.updated_at)) : 'Sin actualización',
    phone,
    whatsapp: phone ? `https://wa.me/${phone}` : '',
    call: phone ? `tel:${phone}` : '',
    maps: `https://maps.google.com/?q=${buyer.latitude},${buyer.longitude}`,
    detail: `/cooperativa/${buyer.id}`
  }
})
</script>

<template>
  <main class="flex flex-col relative w-full pt-16 pb-28 bg-background min-h-screen">
    <div class="flex flex-col w-full relative select-none lg:grid lg:grid-cols-3 lg:gap-space-md lg:max-w-7xl lg:mx-auto lg:items-start">
      <div class="relative w-full h-[742px] overflow-hidden bg-[#e8ded1] flex items-center justify-center lg:col-span-2 lg:rounded-2xl">
        <MapaBase :buyers="buyers" @select="selected = $event" />

        <div class="absolute top-3 left-0 right-0 px-margin z-20 flex flex-col gap-space-xs pointer-events-auto">
          <div class="bg-surface/95 backdrop-blur-md rounded-xl p-space-xs shadow-[0_8px_20px_-4px_rgba(68,21,10,0.12)] flex items-center justify-between gap-space-xs">
            <button class="flex items-center gap-space-xs min-h-[44px] px-space-sm rounded-lg hover:bg-surface-container transition-colors text-left flex-1 min-w-0" type="button">
              <span class="material-symbols-outlined text-primary text-headline-md shrink-0" style="font-variation-settings: 'FILL' 1">my_location</span>
              <div class="flex flex-col min-w-0">
                <span class="font-headline-md text-headline-md text-on-surface font-bold truncate">Pitalito, Huila</span>
                <span class="font-label-md text-label-md text-on-surface-variant truncate">Cooperativas en 25 km</span>
              </div>
            </button>
            <button class="min-h-[44px] min-w-[44px] px-space-xs flex items-center justify-center rounded-lg bg-surface-container-high text-on-surface hover:bg-primary hover:text-on-primary transition-all" type="button" aria-label="Filtro de variedades">
              <span class="material-symbols-outlined text-body-lg">tune</span>
            </button>
          </div>

          <div class="flex items-center gap-space-xs overflow-x-auto pb-1 no-scrollbar">
            <button
              v-for="filter in mapFilters"
              :key="filter.label"
              class="px-3 py-1 rounded-full font-label-md text-label-md shrink-0 flex items-center gap-1"
              :class="filter.active ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface/90 text-on-surface shadow-sm hover:bg-surface-container'"
              type="button"
            >
              <span v-if="filter.icon" class="material-symbols-outlined text-label-md">{{ filter.icon }}</span>
              {{ filter.label }}
            </button>
          </div>
        </div>

        <div class="absolute right-margin top-28 z-20 flex flex-col gap-space-sm pointer-events-auto">
          <button class="min-h-[48px] min-w-[48px] rounded-xl bg-surface/95 text-primary shadow-[0_4px_16px_rgba(68,21,10,0.14)] backdrop-blur-md flex items-center justify-center hover:bg-primary hover:text-on-primary active:scale-95 transition-all" type="button" aria-label="Centrar en mi ubicación">
            <span class="material-symbols-outlined text-headline-md" style="font-variation-settings: 'FILL' 1">gps_fixed</span>
          </button>
          <button class="min-h-[48px] min-w-[48px] rounded-xl bg-surface/95 text-on-surface shadow-[0_4px_16px_rgba(68,21,10,0.14)] backdrop-blur-md flex items-center justify-center hover:bg-surface-container active:scale-95 transition-all" type="button" aria-label="Capas del mapa">
            <span class="material-symbols-outlined text-headline-md">layers</span>
          </button>
          <button class="min-h-[48px] min-w-[48px] rounded-xl bg-surface/95 text-on-surface-variant shadow-[0_4px_16px_rgba(68,21,10,0.14)] backdrop-blur-md flex items-center justify-center hover:bg-surface-container active:scale-95 transition-all" type="button" aria-label="Ver lista de precios">
            <span class="material-symbols-outlined text-headline-md">format_list_bulleted</span>
          </button>
        </div>
      </div>

      <div class="w-full -mt-20 z-30 px-margin pb-6 flex flex-col lg:col-span-1 lg:mt-0 lg:px-0 lg:sticky lg:top-20">
        <div v-if="sheet" class="w-full bg-surface rounded-3xl shadow-[0_-8px_32px_rgba(68,21,10,0.16)] p-space-md flex flex-col gap-space-md">
          <div class="flex flex-col items-center w-full gap-space-xs">
            <div class="w-12 h-1.5 bg-outline-variant/60 rounded-full" />
            <div class="w-full flex items-center justify-between mt-1">
              <div class="flex items-center gap-1.5">
                <span class="px-2.5 py-0.5 rounded-full bg-secondary/10 text-secondary font-label-md text-label-md font-bold flex items-center gap-1">
                  <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1">verified</span>
                  {{ sheet?.badge }}
                </span>
              </div>
              <div class="flex items-center gap-1 text-secondary font-label-md text-label-md font-semibold">
                <span class="w-2 h-2 rounded-full bg-secondary animate-pulse" />
                {{ sheet?.updated }}
              </div>
            </div>

            <div class="flex flex-col">
              <h2 class="font-headline-lg-mobile text-headline-lg-mobile text-on-surface font-bold leading-tight">{{ sheet?.name }}</h2>
              <div class="flex items-center gap-2 mt-1 text-on-surface-variant font-body-md text-body-md">
                <span class="material-symbols-outlined text-primary text-base">near_me</span>
                <span>{{ sheet?.location }}</span>
              </div>
            </div>

            <div class="w-full bg-surface-container rounded-2xl p-space-md flex flex-col gap-space-xs mt-space-xs">
              <div class="flex items-center justify-between">
                <span class="font-label-md text-label-md uppercase tracking-wider text-primary font-bold">Precio hoy</span>
                <span class="px-2 py-0.5 rounded-full bg-secondary-container text-on-secondary-container font-label-md text-[11px] font-bold">Mejor de la zona</span>
              </div>
              <div class="flex items-baseline gap-space-xs flex-wrap">
                <span class="font-price-hero-mobile text-price-hero-mobile text-primary font-bold tracking-tight">{{ sheet?.price }}</span>
                <span class="font-body-md text-body-md text-on-surface-variant font-semibold">{{ sheet?.unit }}</span>
              </div>
              <div class="flex items-center gap-2 flex-wrap pt-1">
                <span
                  v-for="variety in sheet?.varieties ?? []"
                  :key="variety"
                  class="px-3 py-1 rounded-xl bg-surface-container-high text-on-surface font-label-md text-label-md font-semibold"
                >{{ variety }}</span>
              </div>
            </div>

            <div class="w-full grid grid-cols-12 gap-space-xs pt-1">
              <a class="col-span-5 min-h-[48px] px-3 rounded-2xl bg-primary text-on-primary font-headline-md text-headline-md flex items-center justify-center gap-2 shadow-[0_4px_16px_rgba(112,37,6,0.25)] active:scale-95 transition-all" :href="sheet?.call || undefined">
                <span class="material-symbols-outlined text-headline-md" style="font-variation-settings: 'FILL' 1">call</span>
                <span class="truncate">Llamar</span>
              </a>
              <a class="col-span-4 min-h-[48px] px-2 rounded-2xl bg-secondary text-on-secondary font-headline-md text-headline-md flex items-center justify-center gap-1.5 shadow-[0_4px_14px_rgba(0,109,68,0.2)] active:scale-95 transition-all" :href="sheet?.whatsapp || undefined" rel="noopener noreferrer" target="_blank">
                <span class="material-symbols-outlined text-headline-md">chat</span>
                <span class="truncate">WhatsApp</span>
              </a>
              <NuxtLink class="col-span-3 min-h-[48px] px-2 rounded-2xl bg-surface-container-high text-on-surface font-headline-md text-headline-md flex items-center justify-center gap-1 hover:bg-surface-container-highest active:scale-95 transition-all" :to="sheet?.detail ?? '/lista'">
                <span class="material-symbols-outlined text-headline-md text-primary">arrow_forward</span>
              </NuxtLink>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <nav class="fixed bottom-0 w-full z-50 pb-safe bg-surface/90 backdrop-blur-xl shadow-[0_-4px_16px_rgba(68,21,10,0.06)]">
    <div class="flex justify-around items-center h-20 px-space-sm max-w-md mx-auto">
      <a class="flex flex-col items-center justify-center gap-space-xs min-h-[48px] min-w-[64px] rounded-xl text-primary font-bold transition-all" aria-current="page" href="/">
        <span class="material-symbols-outlined text-headline-md">explore</span>
        <span class="font-label-md text-label-md">Mapa</span>
      </a>
      <a class="flex flex-col items-center justify-center gap-space-xs min-h-[48px] min-w-[64px] rounded-xl text-on-surface-variant hover:text-on-surface transition-all" href="/lista">
        <span class="material-symbols-outlined text-headline-md">trending_up</span>
        <span class="font-label-md text-label-md">Precios</span>
      </a>
      <a class="flex flex-col items-center justify-center gap-space-xs min-h-[48px] min-w-[64px] rounded-xl text-on-surface-variant hover:text-on-surface transition-all" href="/lista">
        <span class="material-symbols-outlined text-headline-md">store</span>
        <span class="font-label-md text-label-md">Cooperativas</span>
      </a>
    </div>
  </nav>
</template>
