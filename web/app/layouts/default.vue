<script setup lang="ts">
const route = useRoute()
const isMenuOpen = ref(false)

const links = [
  { label: 'Mapa', to: '/' },
  { label: 'Precios', to: '/lista' },
  { label: 'Calculadora', to: '/calculadora' },
  { label: 'Cooperativas', to: '/cooperativa/1' }
]
</script>

<template>
  <div class="bg-background font-body-md text-body-md text-on-surface antialiased flex flex-col min-h-screen selection:bg-primary-fixed">
    <header class="fixed top-0 w-full z-50 pt-safe bg-surface/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(68,21,10,0.04)]">
      <div class="h-16 px-margin max-w-7xl mx-auto flex items-center justify-between gap-space-sm">
        <NuxtLink class="flex items-center gap-space-sm min-w-0" to="/">
          <span class="material-symbols-outlined text-headline-md text-primary">coffee</span>
          <div class="flex flex-col min-w-0">
            <span class="font-headline-md text-headline-md text-primary font-bold tracking-tight truncate">CaféPrecios</span>
            <div class="flex items-center gap-space-xs text-on-surface-variant">
              <span class="material-symbols-outlined text-label-md text-secondary">location_on</span>
              <span class="font-label-md text-label-md truncate">Eje Cafetero / Huila</span>
            </div>
          </div>
        </NuxtLink>

        <nav class="hidden md:flex items-center gap-space-xs">
          <NuxtLink
            v-for="link in links"
            :key="link.to"
            class="px-3 py-2 rounded-lg font-label-lg text-label-lg transition-colors"
            :class="route.path === link.to
              ? 'bg-surface-container text-primary font-bold'
              : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-semibold'"
            :to="link.to"
          >
            {{ link.label }}
          </NuxtLink>
        </nav>

        <div class="flex items-center gap-space-xs shrink-0">
          <button
            class="min-h-[44px] min-w-[44px] flex items-center justify-center rounded-full bg-secondary-container/40 text-secondary hover:bg-secondary-container transition-colors"
            type="button"
            aria-label="Estado de conexión"
          >
            <span class="material-symbols-outlined text-body-lg">cloud_done</span>
          </button>
          <button
            class="min-h-[44px] min-w-[44px] flex items-center justify-center rounded-full text-on-surface hover:bg-surface-container transition-colors"
            type="button"
            aria-label="Perfil caficultor"
          >
            <span class="material-symbols-outlined text-headline-md">account_circle</span>
          </button>
          <button
            class="md:hidden min-h-[44px] min-w-[44px] flex items-center justify-center rounded-full text-on-surface hover:bg-surface-container transition-colors"
            type="button"
            :aria-expanded="isMenuOpen"
            aria-label="Abrir menú"
            @click="isMenuOpen = !isMenuOpen"
          >
            <span class="material-symbols-outlined text-headline-md">{{ isMenuOpen ? 'close' : 'menu' }}</span>
          </button>
        </div>
      </div>

      <nav v-if="isMenuOpen" class="md:hidden border-t border-outline-variant/40 bg-surface px-margin py-space-sm flex flex-col gap-1">
        <NuxtLink
          v-for="link in links"
          :key="link.to"
          class="px-3 py-3 rounded-lg font-label-lg text-label-lg"
          :class="route.path === link.to
            ? 'bg-surface-container text-primary font-bold'
            : 'text-on-surface-variant font-semibold'"
          :to="link.to"
          @click="isMenuOpen = false"
        >
          {{ link.label }}
        </NuxtLink>
      </nav>
    </header>

    <slot />
  </div>
</template>
