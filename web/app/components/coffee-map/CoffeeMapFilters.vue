<script setup lang="ts">
import type { CoffeeState, CoffeeVarietyFilter } from '~/types/coffee'
import { COFFEE_STATE_OPTIONS, COFFEE_VARIETY_FILTERS } from '~/types/coffee'

const props = defineProps<{
  selected: CoffeeVarietyFilter[]
  coffeeState: CoffeeState
}>()

const emit = defineEmits<{
  toggle: [variety: CoffeeVarietyFilter]
  selectState: [coffeeState: CoffeeState]
}>()

function isActive(variety: CoffeeVarietyFilter): boolean {
  if (variety === 'Todas') {
    return props.selected.length === 0
  }

  return props.selected.includes(variety)
}
</script>

<template>
  <div class="flex flex-col gap-1.5">
    <div class="coffee-filters flex min-w-0 items-center gap-1.5 overflow-x-auto">
      <button
        v-for="state in COFFEE_STATE_OPTIONS"
        :key="state.value"
        class="flex min-h-8 shrink-0 items-center gap-1 rounded-full px-3 py-1 font-label-md text-label-md shadow-[0_3px_10px_rgba(64,35,24,0.10)] transition-colors"
        :class="coffeeState === state.value
          ? 'bg-[#087D50] text-[#FFFAF6]'
          : 'bg-[#FFFAF6]/95 text-[#402318] hover:bg-[#FFF3EC]'"
        type="button"
        :aria-pressed="coffeeState === state.value"
        @click="emit('selectState', state.value)"
      >
        <span
          class="material-symbols-outlined text-[13px]"
          :style="coffeeState === state.value ? 'font-variation-settings: \'FILL\' 1' : ''"
        >{{ coffeeState === state.value ? 'check' : 'grain' }}</span>
        <span>{{ state.label }}</span>
      </button>
    </div>

    <div class="coffee-filters flex min-w-0 items-center gap-1.5 overflow-x-auto">
      <button
        v-for="variety in COFFEE_VARIETY_FILTERS"
        :key="variety"
        class="flex min-h-8 shrink-0 items-center gap-1 rounded-full px-3 py-1 font-label-md text-label-md shadow-[0_3px_10px_rgba(64,35,24,0.10)] transition-colors"
        :class="isActive(variety)
          ? 'bg-[#783719] text-[#FFFAF6]'
          : 'bg-[#FFFAF6]/95 text-[#402318] hover:bg-[#FFF3EC]'"
        type="button"
        :aria-pressed="isActive(variety)"
        @click="emit('toggle', variety)"
      >
        <span
          class="material-symbols-outlined text-[13px]"
          :style="isActive(variety) ? 'font-variation-settings: \'FILL\' 1' : ''"
        >{{ variety === 'Todas' ? 'check' : 'eco' }}</span>
        <span>{{ variety }}</span>
      </button>
    </div>
  </div>
</template>

<style scoped>
.coffee-filters {
  scrollbar-width: none;
}

.coffee-filters::-webkit-scrollbar {
  display: none;
}
</style>
