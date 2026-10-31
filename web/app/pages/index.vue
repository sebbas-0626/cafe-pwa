<script setup lang="ts">
import OnboardingScreen from '~/components/stitch/OnboardingScreen.vue'
import WelcomeScreen from '~/components/stitch/WelcomeScreen.vue'

definePageMeta({
  layout: false
})

const ONBOARDING_KEY = 'cafeprecios-onboarding-seen'
const MOBILE_BREAKPOINT = 768

const isFirstVisit = ref<boolean | null>(null)

onMounted(() => {
  if (window.innerWidth >= MOBILE_BREAKPOINT) {
    navigateTo('/mapa', { replace: true })
    return
  }

  isFirstVisit.value = localStorage.getItem(ONBOARDING_KEY) === null
})

const finishOnboarding = (): void => {
  localStorage.setItem(ONBOARDING_KEY, '1')
  isFirstVisit.value = false
}

useHead({
  title: 'CaféPrecios · Bienvenida'
})
</script>

<template>
  <OnboardingScreen
    v-if="isFirstVisit === true"
    @finish="finishOnboarding"
  />
  <WelcomeScreen v-else-if="isFirstVisit === false" />
  <div v-else class="min-h-screen bg-surface" />
</template>
