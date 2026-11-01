<script setup lang="ts">
const route = useRoute()

const { apiBase } = useRuntimeConfig().public
const loginUrl = `${String(apiBase).replace(/\/api\/?$/, '')}/admin`

const showNav = computed(() => route.path !== '/')

const isActive = (to: string): boolean =>
  route.path === to || (to === '/lista' && route.path.startsWith('/cooperativa'))

const navItems = [
  { label: 'Mapa', icon: 'explore', to: '/mapa' },
  { label: 'Precios', icon: 'trending_up', to: '/lista' }
]
</script>

<template>
  <div class="min-h-screen w-full bg-stone-200 flex justify-center md:py-6">
    <div class="w-full max-w-md mx-auto min-h-screen relative shadow-2xl bg-[#F5F0E6] md:min-h-[calc(100vh-3rem)]">
      <slot />

      <nav
        v-if="showNav"
        class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-md z-50 pb-[env(safe-area-inset-bottom)] bg-surface/95 backdrop-blur-xl shadow-[0_-4px_16px_rgba(68,21,10,0.08)] md:bottom-6"
      >
        <div class="flex justify-around items-center h-16 px-space-sm">
          <NuxtLink
            v-for="item in navItems"
            :key="item.to"
            class="flex flex-col items-center justify-center gap-0.5 min-h-[48px] min-w-[72px] rounded-xl transition-colors"
            :class="isActive(item.to)
              ? 'bg-surface-container text-primary font-bold'
              : 'text-on-surface-variant font-semibold'"
            :to="item.to"
          >
            <span class="material-symbols-outlined text-headline-md">{{ item.icon }}</span>
            <span class="font-label-md text-label-md">{{ item.label }}</span>
          </NuxtLink>

          <a
            class="flex flex-col items-center justify-center gap-0.5 min-h-[48px] min-w-[72px] rounded-xl text-on-surface-variant hover:text-primary transition-colors"
            :href="loginUrl"
            rel="noopener noreferrer"
            target="_blank"
            title="Iniciar sesión para cooperativas"
          >
            <span class="material-symbols-outlined text-headline-md">login</span>
            <span class="font-label-md text-label-md font-semibold whitespace-nowrap">Iniciar sesión</span>
          </a>
        </div>
      </nav>
    </div>
  </div>
</template>
