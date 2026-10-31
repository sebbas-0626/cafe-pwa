<script setup lang="ts">
import MapaScreen from '~/components/cafe/MapaScreen.vue'

definePageMeta({
  layout: false
})

useHead({
  title: 'Café Huila · Mapa de precios'
})
</script>

<template>
  <MapaScreen />
</template>
