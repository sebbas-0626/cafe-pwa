<script setup lang="ts">
import type { BuyerType, PerfilScreenProps } from '~/types'

const props = defineProps<PerfilScreenProps>()

const { buyer, loading, error, fetchBuyerById } = useBuyers()

await fetchBuyerById(Number(props.cooperativeId))

const typeLabels: Record<BuyerType, string> = {
  cooperative: 'Cooperativa',
  private_buyer: 'Comprador privado',
  exporter: 'Exportador'
}

const priceOffers = computed(() => buyer.value?.price_offers ?? [])

const formatCurrency = (value: string): string => `$ ${Number(value).toLocaleString('es-CO')}`

const formatArroba = (value: string): string => `$${Math.round(Number(value) * 12.5).toLocaleString('es-CO')} / @`

const phoneDigits = computed(() => (buyer.value?.phone ?? '').replace(/\D/g, ''))

const mapsUrl = computed(() => `https://maps.google.com/?q=${buyer.value?.latitude},${buyer.value?.longitude}`)

const wazeUrl = computed(() => `https://waze.com/ul?ll=${buyer.value?.latitude},${buyer.value?.longitude}`)
</script>

<template>
  <main class="flex flex-col relative w-full pt-16 pb-safe bg-background min-h-screen">
    <div class="flex flex-col w-full pb-12 max-w-7xl mx-auto lg:px-8">
      <div class="px-margin pt-space-sm pb-space-xs flex items-center justify-between">
        <NuxtLink class="flex items-center gap-space-xs py-space-xs px-space-sm rounded-full bg-surface-container text-on-surface font-label-lg text-label-lg active:scale-95 transition-transform" to="/lista">
          <span class="material-symbols-outlined text-headline-md">arrow_back</span>
          <span>Volver a precios</span>
        </NuxtLink>
        <div v-if="buyer" class="inline-flex items-center gap-1.5 px-3 py-1 bg-secondary-container text-on-secondary-container rounded-full text-label-md font-label-md">
          <span class="material-symbols-outlined text-[15px]" style="font-variation-settings: 'FILL' 1">verified</span>
          <span>{{ typeLabels[buyer.type] }}</span>
        </div>
      </div>

      <div v-if="loading" class="px-margin mt-space-lg flex items-center justify-center gap-2 py-space-xl text-on-surface-variant font-label-lg text-label-lg">
        <span class="material-symbols-outlined animate-spin">progress_activity</span>
        Cargando cooperativa…
      </div>

      <div v-else-if="error" class="px-margin mt-space-lg rounded-xl bg-error-container text-on-error-container p-space-md flex flex-col gap-space-sm">
        <p class="font-label-lg text-label-lg font-bold">No pudimos cargar la cooperativa</p>
        <p class="font-label-md text-label-md">{{ error.message }}</p>
        <button
          class="self-start min-h-[44px] px-space-md rounded-lg bg-primary text-on-primary font-label-lg text-label-lg font-bold active:scale-95 transition-all"
          type="button"
          @click="fetchBuyerById(Number(props.cooperativeId))"
        >
          Reintentar
        </button>
      </div>

      <template v-else-if="buyer">
        <div class="px-margin mt-space-sm">
          <div class="relative w-full h-44 rounded-xl overflow-hidden shadow-sm bg-surface-container">
            <img
              class="w-full h-full object-cover"
              alt="Estación de recibo de café de la cooperativa"
              src="https://lh3.googleusercontent.com/aida-public/AB6AXuCnuDancVVOiLm2Vvaze_h8pLBDLB1UzYgweLivHEl4nernYHXP7NqcNl_PHr4kt4o-DE2YUd53bHkqiFGJpAtPnQPmTUA51LuEYYfxdHVDHgv1_uSVRtmm41skyzE9oZeWhprgu7qgVWgxlkYn3etfDliLQ43ZLuHkiWtgGMQvXQihYhSThfYkoQpouLQ2BXyMqa4S6MKKAMH0HKGr_JIrABGcaVnGhdLT0RRMcWo"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-inverse-surface/90 via-inverse-surface/30 to-transparent flex flex-col justify-end p-space-md">
              <span class="text-secondary-fixed text-label-md font-label-md uppercase tracking-wider font-bold">
                {{ buyer.is_active ? 'Recibiendo café hoy' : 'Cerrada temporalmente' }}
              </span>
              <h2 class="font-headline-lg-mobile text-headline-lg-mobile text-inverse-on-surface leading-tight">{{ buyer.name }}</h2>
            </div>
          </div>
        </div>

        <div class="px-margin mt-space-md flex flex-col gap-space-sm">
          <div class="flex flex-col bg-surface-container-low rounded-xl p-space-md shadow-sm">
            <div class="flex items-start justify-between gap-space-sm">
              <div>
                <h3 class="font-headline-md text-headline-md text-on-surface">{{ buyer.name }}</h3>
                <p class="font-body-md text-body-md text-on-surface-variant">{{ buyer.address ?? 'Sin dirección registrada' }}</p>
              </div>
            </div>

            <p v-if="buyer.description" class="mt-space-sm font-label-md text-label-md text-on-surface-variant">{{ buyer.description }}</p>

            <div class="mt-space-md p-space-sm bg-surface rounded-lg flex items-center justify-between gap-space-sm">
              <div class="flex items-center gap-space-sm min-w-0">
                <div class="relative flex h-3 w-3 shrink-0">
                  <span
                    class="absolute inline-flex h-full w-full rounded-full opacity-75"
                    :class="buyer.is_active ? 'animate-ping bg-secondary' : 'bg-outline'"
                  />
                  <span class="relative inline-flex rounded-full h-3 w-3" :class="buyer.is_active ? 'bg-secondary' : 'bg-outline'" />
                </div>
                <div class="min-w-0">
                  <p class="font-label-lg text-label-lg font-bold truncate" :class="buyer.is_active ? 'text-secondary' : 'text-on-surface-variant'">
                    {{ buyer.is_active ? 'Báscula y laboratorio activos' : 'Sin atención en este momento' }}
                  </p>
                  <p class="font-label-md text-label-md text-on-surface-variant truncate">
                    {{ priceOffers.length }} oferta{{ priceOffers.length === 1 ? '' : 's' }} vigente{{ priceOffers.length === 1 ? '' : 's' }}
                  </p>
                </div>
              </div>
              <span class="material-symbols-outlined text-secondary shrink-0 text-[22px]">timer</span>
            </div>
          </div>
        </div>

        <div class="px-margin mt-space-lg flex flex-col gap-space-xs">
          <h4 class="font-headline-md text-headline-md text-on-surface px-space-xs">Ubicación de báscula</h4>
          <div class="bg-surface-container-low rounded-xl overflow-hidden shadow-sm flex flex-col">
            <div class="w-full h-36 bg-surface-container-high relative flex flex-col items-center justify-center gap-1">
              <span class="material-symbols-outlined text-primary text-[32px]">location_on</span>
              <span class="font-label-lg text-label-lg text-on-surface font-bold">{{ buyer.latitude }}, {{ buyer.longitude }}</span>
              <span class="font-label-md text-label-md text-on-surface-variant">Coordenadas de recibo</span>
            </div>
            <div class="p-space-md flex flex-col gap-space-sm">
              <div class="flex items-start gap-space-xs">
                <span class="material-symbols-outlined text-primary text-[20px] mt-0.5 shrink-0">pin_drop</span>
                <p class="font-body-md text-body-md text-on-surface">{{ buyer.address ?? 'Dirección no disponible' }}</p>
              </div>
              <div class="flex items-center gap-space-sm mt-space-xs">
                <a class="flex-1 py-2.5 px-space-sm bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-lg text-label-lg rounded-lg text-center flex items-center justify-center gap-1 active:scale-95 transition-all" :href="mapsUrl" rel="noopener noreferrer" target="_blank">
                  <span class="material-symbols-outlined text-[18px]">map</span>
                  <span>Google Maps</span>
                </a>
                <a class="flex-1 py-2.5 px-space-sm bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-lg text-label-lg rounded-lg text-center flex items-center justify-center gap-1 active:scale-95 transition-all" :href="wazeUrl" rel="noopener noreferrer" target="_blank">
                  <span class="material-symbols-outlined text-[18px]">directions_car</span>
                  <span>Waze</span>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="px-margin mt-space-lg flex flex-col gap-space-sm">
          <div class="flex items-center justify-between px-space-xs">
            <h4 class="font-headline-md text-headline-md text-on-surface">Precios de Hoy</h4>
            <span class="material-symbols-outlined text-primary text-[24px]">coffee</span>
          </div>

          <p v-if="priceOffers.length === 0" class="font-label-lg text-label-lg text-on-surface-variant">Esta cooperativa no tiene ofertas vigentes.</p>

          <div class="flex flex-col gap-space-xs md:grid md:grid-cols-2 lg:grid-cols-4">
            <div v-for="offer in priceOffers" :key="offer.id" class="bg-surface-container-low rounded-xl p-space-md shadow-sm flex flex-col gap-2">
              <div class="flex items-center justify-between">
                <span class="font-headline-md text-headline-md text-on-surface font-bold">{{ offer.coffee_variety?.name ?? 'Sin variedad' }}</span>
                <span class="text-label-md font-label-md px-2 py-0.5 rounded-full bg-surface-container text-on-surface">{{ offer.unit }}</span>
              </div>
              <p class="font-label-md text-label-md text-on-surface-variant">Vigente hasta {{ offer.valid_until }}</p>
              <div class="flex items-baseline justify-between mt-space-xs pt-space-xs">
                <div>
                  <span class="font-price-hero-mobile text-price-hero-mobile text-primary">{{ formatCurrency(offer.price_per_kg) }}</span>
                  <span class="font-label-lg text-label-lg text-on-surface-variant"> / kg</span>
                </div>
                <span class="font-label-lg text-label-lg text-on-surface font-bold bg-surface-container px-2.5 py-1 rounded-md">{{ formatArroba(offer.price_per_kg) }}</span>
              </div>
            </div>
          </div>

          <div class="bg-surface-container-highest rounded-xl p-space-md mt-space-xs flex flex-col gap-2">
            <div class="flex items-center gap-1.5 text-on-surface">
              <span class="material-symbols-outlined text-[20px] text-tertiary">rule</span>
              <span class="font-label-lg text-label-lg font-bold">Parámetros de Recibo en Báscula</span>
            </div>
            <div class="grid grid-cols-3 gap-2 pt-1 text-center font-label-md text-label-md">
              <div class="bg-surface p-2 rounded-lg">
                <p class="text-on-surface-variant">Humedad</p>
                <p class="font-bold text-on-surface mt-0.5">10% – 12%</p>
              </div>
              <div class="bg-surface p-2 rounded-lg">
                <p class="text-on-surface-variant">Merma Máx.</p>
                <p class="font-bold text-on-surface mt-0.5">1.5%</p>
              </div>
              <div class="bg-surface p-2 rounded-lg">
                <p class="text-on-surface-variant">Factor Ref.</p>
                <p class="font-bold text-on-surface mt-0.5">88 base</p>
              </div>
            </div>
          </div>
        </div>

        <div class="px-margin mt-space-lg flex flex-col gap-space-sm">
          <div class="flex items-center justify-between px-space-xs">
            <h4 class="font-headline-md text-headline-md text-on-surface">Calculadora de Liquidación</h4>
            <span class="material-symbols-outlined text-primary text-[22px]">calculate</span>
          </div>
          <div class="bg-surface-container-low rounded-xl p-space-md shadow-sm flex flex-col gap-space-md">
            <div class="flex flex-col gap-1">
              <label class="font-label-md text-label-md text-on-surface-variant" for="variety-select">Variedad a liquidar:</label>
              <select id="variety-select" class="w-full bg-surface text-on-surface font-body-md text-body-md py-3 px-3 rounded-lg focus:outline-none">
                <option v-for="offer in priceOffers" :key="offer.id">
                  {{ offer.coffee_variety?.name ?? 'Sin variedad' }} - {{ formatCurrency(offer.price_per_kg) }} / kg
                </option>
              </select>
            </div>

            <div class="flex bg-surface-container p-1 rounded-lg">
              <button class="flex-1 py-2 font-label-lg text-label-lg rounded-md bg-primary-container text-on-primary font-bold shadow-sm transition-all text-center" type="button">Arrobas (@)</button>
              <button class="flex-1 py-2 font-label-lg text-label-lg rounded-md text-on-surface font-medium transition-all text-center" type="button">Kilos (kg)</button>
            </div>

            <div class="flex flex-col gap-1.5">
              <label class="font-label-md text-label-md text-on-surface-variant" for="coffee-qty">Cantidad de Arrobas (@):</label>
              <div class="flex items-center gap-space-sm">
                <button class="w-14 h-14 bg-surface-container hover:bg-surface-container-high rounded-xl text-on-surface flex items-center justify-center active:scale-90 transition-transform" type="button">
                  <span class="material-symbols-outlined text-[28px]">remove</span>
                </button>
                <input id="coffee-qty" class="flex-1 h-14 bg-surface text-center font-price-hero-mobile text-price-hero-mobile text-primary rounded-xl focus:outline-none" type="number" inputmode="numeric" min="1" step="1" value="20">
                <button class="w-14 h-14 bg-surface-container hover:bg-surface-container-high rounded-xl text-on-surface flex items-center justify-center active:scale-90 transition-transform" type="button">
                  <span class="material-symbols-outlined text-[28px]">add</span>
                </button>
              </div>
            </div>

            <div class="bg-secondary text-on-secondary rounded-xl p-space-md flex flex-col gap-1 shadow-md">
              <div class="flex items-center justify-between text-secondary-fixed text-label-md font-label-md">
                <span>VALOR ESTIMADO A RECIBIR</span>
                <span class="material-symbols-outlined text-[18px]">payments</span>
              </div>
              <p class="font-price-hero text-price-hero text-on-secondary tracking-tight my-0.5">$ 3.800.000</p>
              <p class="font-label-md text-label-md text-secondary-fixed-dim">Pago de contado hoy en efectivo o transferencia bancaria inmediata.</p>
            </div>
          </div>
        </div>

        <div class="px-margin mt-space-lg flex flex-col gap-space-sm">
          <h4 class="font-headline-md text-headline-md text-on-surface px-space-xs">Canales de Atención</h4>
          <a v-if="buyer.phone" class="w-full min-h-[52px] bg-primary-container hover:bg-primary text-on-primary rounded-xl flex items-center justify-center gap-space-sm py-3 px-space-md shadow-md active:scale-95 transition-transform" :href="`tel:${phoneDigits}`">
            <span class="material-symbols-outlined text-[24px]">call</span>
            <span class="font-label-lg text-label-lg font-bold">Llamar a {{ buyer.phone }}</span>
          </a>
          <a v-if="phoneDigits" class="w-full min-h-[52px] bg-secondary hover:opacity-90 text-on-secondary rounded-xl flex items-center justify-center gap-space-sm py-3 px-space-md shadow-md active:scale-95 transition-transform" :href="`https://wa.me/${phoneDigits}`" rel="noopener noreferrer" target="_blank">
            <span class="material-symbols-outlined text-[24px]">chat</span>
            <span class="font-label-lg text-label-lg font-bold">Escribir por WhatsApp</span>
          </a>
        </div>
      </template>
    </div>
  </main>
</template>
