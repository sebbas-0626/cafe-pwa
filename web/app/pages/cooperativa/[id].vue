<script setup lang="ts">
import PerfilScreen from '~/components/cafe/PerfilScreen.vue'

definePageMeta({
  layout: 'mobile'
})

const route = useRoute()
const cooperativeId = computed(() => String(route.params.id))

let mediaQuery: MediaQueryList | null = null

const syncLayout = (): void => {
  if (mediaQuery) {
    setPageLayout(mediaQuery.matches ? 'desktop' : 'mobile')
  }
}

onMounted(() => {
  mediaQuery = window.matchMedia('(min-width: 768px)')
  syncLayout()
  mediaQuery.addEventListener('change', syncLayout)
})

onBeforeUnmount(() => {
  mediaQuery?.removeEventListener('change', syncLayout)
})
</script>

<template>
  <PerfilScreen :cooperative-id="cooperativeId" />
</template>
