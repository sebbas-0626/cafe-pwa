<script setup lang="ts">
import type { CoffeeMapViewMode } from '~/types/coffee'

defineProps<{
  viewMode: CoffeeMapViewMode
  showLabels: boolean
  showWater: boolean
  locating: boolean
}>()

const emit = defineEmits<{
  locate: []
  zoomIn: []
  zoomOut: []
  toggleList: []
  toggleLabels: []
  toggleWater: []
}>()

const layersOpen = ref(false)
</script>

<template>
  <div class="flex flex-col items-end gap-2">
    <button
      class="flex min-h-11 min-w-11 items-center justify-center rounded-xl bg-[#FFFAF6]/95 text-[#783719] shadow-[0_6px_18px_-4px_rgba(64,35,24,0.28)] backdrop-blur-md transition-colors hover:bg-[#FFF0E7] active:scale-95 disabled:opacity-60"
      type="button"
      :disabled="locating"
      aria-label="Centrar en mi ubicación"
      @click="emit('locate')"
    >
      <span class="material-symbols-outlined text-[20px]" :class="{ 'animate-spin': locating }" style="font-variation-settings: 'FILL' 1">
        {{ locating ? 'progress_activity' : 'my_location' }}
      </span>
    </button>

    <button
      class="flex min-h-11 min-w-11 items-center justify-center rounded-xl shadow-[0_6px_18px_-4px_rgba(64,35,24,0.28)] backdrop-blur-md transition-colors active:scale-95"
      :class="viewMode === 'list'
        ? 'bg-[#783719] text-[#FFFAF6] hover:bg-[#5E2B14]'
        : 'bg-[#FFFAF6]/95 text-[#402318] hover:bg-[#FFF0E7]'"
      type="button"
      :aria-pressed="viewMode === 'list'"
      aria-label="Ver lista de compradores"
      @click="emit('toggleList')"
    >
      <span class="material-symbols-outlined text-[20px]">{{ viewMode === 'list' ? 'map' : 'format_list_bulleted' }}</span>
    </button>

    <div class="relative">
      <button
        class="flex min-h-11 min-w-11 items-center justify-center rounded-xl bg-[#FFFAF6]/95 text-[#402318] shadow-[0_6px_18px_-4px_rgba(64,35,24,0.28)] backdrop-blur-md transition-colors hover:bg-[#FFF0E7] active:scale-95"
        type="button"
        :aria-expanded="layersOpen"
        aria-label="Control de capas"
        @click="layersOpen = !layersOpen"
      >
        <span class="material-symbols-outlined text-[20px]">layers</span>
      </button>

      <div
        v-if="layersOpen"
        class="absolute right-full top-0 mr-2 flex w-48 flex-col gap-1 rounded-2xl border border-[#402318]/10 bg-[#FFFAF6] p-1.5 shadow-[0_14px_32px_-10px_rgba(64,35,24,0.35)]"
      >
        <button
          class="flex min-h-10 items-center justify-between gap-2 rounded-xl px-2.5 text-left font-label-md text-[11px] font-bold text-[#402318] hover:bg-[#FFF0E7]"
          type="button"
          :aria-pressed="showLabels"
          @click="emit('toggleLabels')"
        >
          <span>Nombres y vías</span>
          <span class="material-symbols-outlined text-[17px]" :class="showLabels ? 'text-[#087D50]' : 'text-[#B9A99B]'">
            {{ showLabels ? 'visibility' : 'visibility_off' }}
          </span>
        </button>
        <button
          class="flex min-h-10 items-center justify-between gap-2 rounded-xl px-2.5 text-left font-label-md text-[11px] font-bold text-[#402318] hover:bg-[#FFF0E7]"
          type="button"
          :aria-pressed="showWater"
          @click="emit('toggleWater')"
        >
          <span>Ríos y quebradas</span>
          <span class="material-symbols-outlined text-[17px]" :class="showWater ? 'text-[#A7C9BC]' : 'text-[#B9A99B]'">
            {{ showWater ? 'water' : 'water_lux' }}
          </span>
        </button>
      </div>
    </div>

    <div class="flex flex-col overflow-hidden rounded-xl bg-[#FFFAF6]/95 text-[#402318] shadow-[0_6px_18px_-4px_rgba(64,35,24,0.28)] backdrop-blur-md">
      <button
        class="flex min-h-10 min-w-11 items-center justify-center transition-colors hover:bg-[#FFF0E7] active:scale-95"
        type="button"
        aria-label="Acercar"
        @click="emit('zoomIn')"
      >
        <span class="material-symbols-outlined text-[20px]">add</span>
      </button>
      <span class="mx-2 h-px bg-[#402318]/10" />
      <button
        class="flex min-h-10 min-w-11 items-center justify-center transition-colors hover:bg-[#FFF0E7] active:scale-95"
        type="button"
        aria-label="Alejar"
        @click="emit('zoomOut')"
      >
        <span class="material-symbols-outlined text-[20px]">remove</span>
      </button>
    </div>
  </div>
</template>
