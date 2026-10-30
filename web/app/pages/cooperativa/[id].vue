<script setup lang="ts">
import PerfilScreen from '~/components/cafe/PerfilScreen.vue'

const route = useRoute()
const cooperativeId = computed(() => String(route.params.id))
</script>

<template>
  <PerfilScreen :cooperative-id="cooperativeId" />
</template>
