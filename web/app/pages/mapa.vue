<script setup lang="ts">
import MapaScreen from '~/components/cafe/MapaScreen.vue'

definePageMeta({
  layout: false
})

useHead({
  title: 'CaféPrecios · Mapa'
})
</script>

<template>
  <div class="fixed inset-0 bg-surface-dim flex justify-center">
    <div class="relative w-full max-w-md h-full bg-[#E9DFD0] shadow-xl overflow-hidden">
      <MapaScreen />
    </div>
  </div>
</template>
