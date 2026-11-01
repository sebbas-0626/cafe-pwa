<script setup lang="ts">
import OnboardingScreen from '~/components/stitch/OnboardingScreen.vue'
import WelcomeScreen from '~/components/stitch/WelcomeScreen.vue'

definePageMeta({
  layout: 'mobile'
})

const ONBOARDING_KEY = 'cafeprecios-onboarding-seen'

const isFirstVisit = ref<boolean | null>(null)

onMounted(() => {
  if (window.matchMedia('(min-width: 768px)').matches) {
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
  <div class="md:hidden">
    <OnboardingScreen
      v-if="isFirstVisit === true"
      @finish="finishOnboarding"
    />
    <WelcomeScreen v-else-if="isFirstVisit === false" />
    <div v-else class="min-h-screen bg-surface" />
  </div>
</template>
