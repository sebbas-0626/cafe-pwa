<script setup lang="ts">
import type { CoffeeMapPoint } from '~/types/coffee'
import { BUYER_TYPE_META } from '~/types/coffee'
import { formatPricePerKg } from '~/services/coffeeBuyerService'

const props = defineProps<{
  point: CoffeeMapPoint
  isSelected: boolean
}>()

const emit = defineEmits<{ select: [] }>()

const typeMeta = computed(() => BUYER_TYPE_META[props.point.buyer.type] ?? BUYER_TYPE_META.private_buyer)
const icon = computed(() => props.point.isBest ? 'eco' : typeMeta.value.icon)
const ariaLabel = computed(() => (
  `${props.point.buyer.name}, ${formatPricePerKg(props.point.pricePerKg)} por kilogramo, ${typeMeta.value.label}`
))
</script>

<template>
  <button
    class="coffee-marker"
    :class="{ 'coffee-marker--best': point.isBest, 'coffee-marker--selected': isSelected }"
    type="button"
    :aria-label="ariaLabel"
    @click.stop="emit('select')"
  >
    <span class="coffee-marker__price">
      <span class="coffee-marker__amount">{{ formatPricePerKg(point.pricePerKg) }}</span>
      <span class="coffee-marker__unit">/{{ point.offer.unit }}</span>
    </span>

    <span class="coffee-marker__body">
      <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1">{{ icon }}</span>
    </span>

    <span class="coffee-marker__tail" />

    <span v-if="point.isBest" class="coffee-marker__badge">
      <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1">star</span>
      Mejor Precio
    </span>
  </button>
</template>

<style scoped>
.coffee-marker {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 0;
  border: 0;
  background: transparent;
  cursor: pointer;
  transform-origin: bottom center;
  transition: transform 180ms ease;
  font-family: Quicksand, sans-serif;
}

.coffee-marker:hover,
.coffee-marker:focus-visible {
  transform: scale(1.05);
  outline: none;
}

.coffee-marker--selected {
  transform: scale(1.08);
  z-index: 4;
}

.coffee-marker__price {
  display: flex;
  align-items: baseline;
  gap: 2px;
  padding: 5px 10px;
  border: 1px solid rgba(120, 55, 25, 0.08);
  border-radius: 9999px;
  background: #fffaf6;
  color: #402318;
  box-shadow: 0 4px 12px rgba(64, 35, 24, 0.16);
  font-size: 13px;
  line-height: 1;
  white-space: nowrap;
}

.coffee-marker__amount {
  font-weight: 700;
  font-variant-numeric: tabular-nums;
}

.coffee-marker__unit {
  color: #7a6558;
  font-size: 9px;
  font-weight: 600;
}

.coffee-marker__body {
  display: grid;
  place-items: center;
  width: 32px;
  height: 32px;
  margin-top: -2px;
  border: 2px solid #fffaf6;
  border-radius: 9999px;
  background: #783719;
  color: #fffaf6;
  box-shadow: 0 5px 14px rgba(64, 35, 24, 0.24);
}

.coffee-marker__body .material-symbols-outlined {
  font-size: 17px;
}

.coffee-marker__tail {
  width: 6px;
  height: 6px;
  margin-top: 1px;
  border-radius: 9999px;
  background: #783719;
  box-shadow: 0 0 0 2px rgba(255, 250, 246, 0.75);
}

.coffee-marker--best .coffee-marker__price {
  border-color: transparent;
  background: #087d50;
  color: #ffffff;
  box-shadow: 0 6px 18px rgba(8, 125, 80, 0.34);
}

.coffee-marker--best .coffee-marker__unit {
  color: rgba(255, 255, 255, 0.76);
}

.coffee-marker--best .coffee-marker__body {
  background: #087d50;
  animation: coffee-pulse 2.4s ease-in-out infinite;
}

.coffee-marker--best .coffee-marker__tail {
  background: #087d50;
}

.coffee-marker__badge {
  position: absolute;
  top: calc(100% + 4px);
  left: 50%;
  display: flex;
  align-items: center;
  gap: 3px;
  padding: 3px 7px;
  border-radius: 7px;
  background: #fffaf6;
  color: #087d50;
  box-shadow: 0 3px 10px rgba(64, 35, 24, 0.15);
  font-size: 9px;
  font-weight: 700;
  white-space: nowrap;
  transform: translateX(-50%);
}

.coffee-marker__badge .material-symbols-outlined {
  font-size: 11px;
}

@keyframes coffee-pulse {
  0%,
  100% {
    box-shadow: 0 5px 14px rgba(8, 125, 80, 0.24), 0 0 0 0 rgba(8, 125, 80, 0.24);
  }
  50% {
    box-shadow: 0 5px 14px rgba(8, 125, 80, 0.3), 0 0 0 8px rgba(8, 125, 80, 0);
  }
}

@media (prefers-reduced-motion: reduce) {
  .coffee-marker,
  .coffee-marker--best .coffee-marker__body {
    animation: none;
    transition: none;
  }
}

@media (max-width: 767px) {
  .coffee-marker__price {
    padding: 4px 8px;
    font-size: 11px;
  }

  .coffee-marker__unit {
    font-size: 8px;
  }

  .coffee-marker__body {
    width: 28px;
    height: 28px;
  }

  .coffee-marker__body .material-symbols-outlined {
    font-size: 15px;
  }

  .coffee-marker__badge {
    padding: 2px 6px;
    font-size: 8px;
  }
}
</style>
