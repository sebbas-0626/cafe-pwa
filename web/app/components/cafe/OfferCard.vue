<script setup lang="ts">
import type { OfferCardProps, PriceUnit } from '~/types'

const props = defineProps<OfferCardProps>()

const unitLabels: Record<PriceUnit, string> = {
  kg: '/ kg',
  arroba: '/ @',
  carga: '/ carga'
}

const formattedPrice = computed(() => `$ ${Number(props.price).toLocaleString('es-CO')}`)

const formattedDate = computed(() =>
  new Intl.DateTimeFormat('es-CO', {
    day: '2-digit',
    month: 'short',
    hour: '2-digit',
    minute: '2-digit'
  }).format(new Date(props.updatedAt))
)
</script>

<template>
  <div class="rounded-2xl p-space-md bg-surface-container-lowest shadow-sm flex flex-col gap-space-sm">
    <div class="flex items-start justify-between gap-space-sm">
      <span class="font-headline-md text-headline-md font-bold text-on-surface truncate">{{ buyerName }}</span>
      <span class="font-label-md text-label-md text-on-surface-variant shrink-0">{{ formattedDate }}</span>
    </div>

    <div class="flex items-baseline justify-between py-space-xs rounded-xl px-space-sm bg-surface-container-low">
      <div class="flex items-baseline gap-1">
        <span class="font-headline-lg-mobile text-headline-lg-mobile font-bold text-primary">{{ formattedPrice }}</span>
        <span class="font-label-lg text-label-lg font-bold text-on-surface-variant">{{ unitLabels[unit] }}</span>
      </div>
    </div>

    <div class="flex flex-wrap items-center gap-space-xs">
      <span class="px-2.5 py-0.5 rounded-full bg-surface-container-high text-on-surface font-label-md text-label-md font-bold">{{ variety }}</span>
    </div>

    <button
      class="min-h-[48px] w-full rounded-xl bg-primary text-on-primary font-label-lg text-label-lg font-bold flex items-center justify-center gap-1 active:scale-95 transition-all shadow-sm"
      type="button"
    >
      <span>Ver detalle</span>
      <span class="material-symbols-outlined text-body-md">arrow_forward</span>
    </button>
  </div>
</template>
