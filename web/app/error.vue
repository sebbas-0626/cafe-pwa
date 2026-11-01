<script setup lang="ts">
import type { NuxtError } from '#app'

const props = defineProps<{
  error: NuxtError
}>()

const isNotFound = computed(() => props.error.statusCode === 404)

const goToMap = (): void => {
  clearError({ redirect: '/mapa' })
}

useHead({
  title: isNotFound.value ? 'CaféPrecios · Página no encontrada' : 'CaféPrecios · Error'
})
</script>

<template>
  <div class="min-h-screen bg-surface-dim flex justify-center p-4">
    <div class="w-full max-w-md my-auto bg-surface rounded-2xl shadow-xl p-8 flex flex-col items-center text-center gap-4">
      <div class="w-16 h-16 rounded-2xl bg-primary-container text-on-primary flex items-center justify-center">
        <span class="material-symbols-outlined text-[34px]">
          {{ isNotFound ? 'explore_off' : 'error' }}
        </span>
      </div>

      <div class="flex flex-col gap-1">
        <span class="font-label-md text-label-md text-primary font-bold uppercase tracking-wider">
          {{ error.statusCode }}
        </span>
        <h1 class="font-headline-lg-mobile text-headline-lg-mobile text-on-surface">
          {{ isNotFound ? 'Página no encontrada' : 'Algo salió mal' }}
        </h1>
        <p class="font-body-md text-body-md text-on-surface-variant">
          {{ isNotFound
            ? 'La ruta que buscas no existe o fue movida. Puedes volver al mapa de precios.'
            : 'No pudimos cargar esta pantalla. Intenta de nuevo en unos segundos.' }}
        </p>
      </div>

      <button
        class="w-full min-h-[52px] rounded-xl bg-primary text-on-primary font-label-lg text-label-lg font-bold flex items-center justify-center gap-2 active:scale-95 transition-transform"
        type="button"
        @click="goToMap"
      >
        <span class="material-symbols-outlined text-[20px]">map</span>
        Ir al mapa
      </button>

      <NuxtLink
        class="font-label-lg text-label-lg text-on-surface-variant underline underline-offset-4 font-semibold"
        to="/lista"
      >
        Ver precios
      </NuxtLink>
    </div>
  </div>
</template>
