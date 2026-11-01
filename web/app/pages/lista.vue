<script setup lang="ts">
import ListaScreen from '~/components/cafe/ListaScreen.vue'

definePageMeta({
  layout: 'mobile'
})

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
  <ListaScreen />
</template>
