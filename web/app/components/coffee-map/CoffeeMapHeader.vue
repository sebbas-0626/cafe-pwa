<script setup lang="ts">
import type { CoffeeBuyerSource, CoffeeVarietyFilter } from '~/types/coffee'
import CoffeeMapFilters from './CoffeeMapFilters.vue'

defineProps<{
  count: number
  radiusKm: number
  loading: boolean
  source: CoffeeBuyerSource | null
  locationLabel: string
  selectedVarieties: CoffeeVarietyFilter[]
}>()

const emit = defineEmits<{
  locate: []
  toggleVariety: [variety: CoffeeVarietyFilter]
}>()

const menuOpen = ref(false)

const menuLinks = [
  { label: 'Mapa de precios', icon: 'explore', to: '/' },
  { label: 'Comparar precios', icon: 'trending_up', to: '/lista' },
  { label: 'Calculadora de lote', icon: 'calculate', to: '/calculadora' }
]
</script>

<template>
  <header class="pointer-events-none absolute inset-x-3 top-[max(0.75rem,env(safe-area-inset-top))] z-30 flex flex-col gap-2 md:inset-x-4 md:top-4">
    <div class="pointer-events-auto relative flex items-center gap-2 rounded-2xl border border-white/70 bg-[#FFFAF6]/95 px-2.5 py-2 shadow-[0_10px_30px_-8px_rgba(64,35,24,0.28)] backdrop-blur-md md:gap-4 md:px-5 md:py-3">
      <NuxtLink class="flex min-w-0 items-center gap-2.5 md:gap-3" to="/" aria-label="Café Huila, ir al mapa">
        <span class="relative grid h-10 w-10 shrink-0 place-items-center rounded-full bg-[#F3E3D8] text-[#783719] md:h-11 md:w-11">
          <span class="material-symbols-outlined text-[22px]" style="font-variation-settings: 'FILL' 1">local_cafe</span>
          <span class="material-symbols-outlined absolute -right-1 -top-1 rounded-full bg-[#FFFAF6] text-[15px] text-[#087D50]" style="font-variation-settings: 'FILL' 1">eco</span>
        </span>
        <span class="flex min-w-0 flex-col">
          <span class="truncate font-headline-md text-[16px] font-bold leading-tight text-[#402318] md:text-[20px]">Café Huila</span>
          <span class="hidden truncate font-label-md text-[10px] text-[#7A6558] md:block">Conectando el campo con mejores precios</span>
          <span v-if="source === 'mock'" class="mt-0.5 w-fit rounded-full bg-[#F3E3D8] px-1.5 py-0.5 font-label-md text-[8px] font-bold text-[#783719] md:hidden" title="Datos de demostración. No representan precios reales.">Demo</span>
        </span>
      </NuxtLink>

      <span class="hidden h-10 w-px shrink-0 bg-[#402318]/10 md:block" />

      <div class="flex min-w-0 flex-1 items-center gap-1.5 md:gap-2">
        <span class="material-symbols-outlined shrink-0 text-[18px] text-[#783719] md:text-[22px]" style="font-variation-settings: 'FILL' 1">location_on</span>
        <div class="flex min-w-0 flex-col">
          <span class="truncate font-headline-md text-[13px] font-bold leading-tight text-[#402318] md:text-[17px]">{{ locationLabel }}</span>
          <span class="flex min-w-0 items-center gap-1 truncate font-label-md text-[9px] text-[#7A6558] md:text-[11px]">
            <span class="hidden md:inline">Radio {{ radiusKm }} km</span>
            <span class="md:hidden">{{ radiusKm }} km</span>
            <span aria-hidden="true">·</span>
            <span>{{ count }} {{ count === 1 ? 'punto' : 'puntos' }}</span>
            <span
              v-if="source === 'mock'"
              class="hidden rounded-full bg-[#F3E3D8] px-1.5 py-0.5 text-[9px] font-bold text-[#783719] md:inline"
              title="Datos de demostración. No representan precios reales."
            >Demo</span>
          </span>
        </div>
      </div>

      <div class="ml-auto flex shrink-0 items-center gap-1.5 md:gap-2">
        <button
          class="flex min-h-10 items-center justify-center gap-1.5 rounded-xl bg-[#F3E3D8] px-2.5 text-[#783719] transition-colors hover:bg-[#EBD6C8] active:scale-95 disabled:opacity-60 md:min-h-11 md:px-3.5"
          type="button"
          :disabled="loading"
          aria-label="Usar mi ubicación"
          @click="emit('locate')"
        >
          <span class="material-symbols-outlined text-[18px]">{{ loading ? 'progress_activity' : 'my_location' }}</span>
          <span class="hidden font-label-lg text-label-lg font-bold sm:inline">Mi ubicación</span>
        </button>

        <button
          class="flex min-h-10 min-w-10 items-center justify-center rounded-xl bg-[#F3E3D8] text-[#402318] transition-colors hover:bg-[#EBD6C8] active:scale-95 md:min-h-11 md:min-w-11"
          type="button"
          :aria-expanded="menuOpen"
          aria-label="Abrir menú"
          @click="menuOpen = !menuOpen"
        >
          <span class="material-symbols-outlined text-[20px]">{{ menuOpen ? 'close' : 'menu' }}</span>
        </button>
      </div>

      <button
        v-if="menuOpen"
        class="fixed inset-0 z-30 cursor-default"
        type="button"
        tabindex="-1"
        aria-label="Cerrar menú"
        @click="menuOpen = false"
      />

      <nav
        v-if="menuOpen"
        class="absolute right-2 top-[calc(100%+8px)] z-40 flex w-60 flex-col rounded-2xl border border-[#402318]/10 bg-[#FFFAF6] p-1.5 shadow-[0_18px_40px_-12px_rgba(64,35,24,0.4)]"
      >
        <NuxtLink
          v-for="link in menuLinks"
          :key="link.to"
          class="flex min-h-11 items-center gap-2 rounded-xl px-3 font-label-lg text-label-lg font-semibold text-[#402318] transition-colors hover:bg-[#FFF0E7]"
          :to="link.to"
          @click="menuOpen = false"
        >
          <span class="material-symbols-outlined text-[18px] text-[#783719]">{{ link.icon }}</span>
          {{ link.label }}
        </NuxtLink>
      </nav>
    </div>

    <CoffeeMapFilters
      class="pointer-events-auto pl-0.5"
      :selected="selectedVarieties"
      @toggle="emit('toggleVariety', $event)"
    />
  </header>
</template>
