<script setup lang="ts">
import MapaScreen from '~/components/cafe/MapaScreen.vue'
import ListaScreen from '~/components/cafe/ListaScreen.vue'
import PerfilScreen from '~/components/cafe/PerfilScreen.vue'

const route = useRoute()

const { apiBase } = useRuntimeConfig().public
const adminUrl = `${String(apiBase).replace(/\/api\/?$/, '')}/admin`

const links = [
  { label: 'Mapa', to: '/mapa' },
  { label: 'Precios', to: '/lista' }
]

const showWorkspace = computed(() =>
  route.path === '/mapa' || route.path === '/lista' || route.path.startsWith('/cooperativa/')
)

const isActive = (to: string): boolean =>
  route.path === to || (to === '/lista' && route.path.startsWith('/cooperativa'))

const routeBuyerId = computed<number | null>(() => {
  const match = route.path.match(/^\/cooperativa\/(\d+)/)

  return match ? Number(match[1]) : null
})

const selectedBuyerId = ref<number | null>(routeBuyerId.value)

watch(() => route.path, () => {
  selectedBuyerId.value = routeBuyerId.value
})
</script>

<template>
  <div class="hidden md:flex md:flex-col h-screen w-full overflow-hidden bg-[#F5F0E6]">
    <header class="h-16 shrink-0 bg-surface/95 backdrop-blur-xl border-b border-outline-variant/40 shadow-sm">
      <div class="h-full px-6 flex items-center justify-between gap-6">
        <NuxtLink class="flex items-center gap-2.5 shrink-0" to="/mapa">
          <span class="material-symbols-outlined text-headline-md text-primary">coffee</span>
          <div class="flex flex-col">
            <span class="font-headline-md text-headline-md text-primary font-bold tracking-tight leading-none">CaféPrecios</span>
            <span class="font-label-md text-label-md text-on-surface-variant leading-tight">Colombia · En Vivo</span>
          </div>
        </NuxtLink>

        <nav class="flex items-center gap-1">
          <NuxtLink
            v-for="link in links"
            :key="link.to"
            class="px-4 py-2 rounded-xl font-label-lg text-label-lg transition-colors"
            :class="isActive(link.to)
              ? 'bg-surface-container text-primary font-bold'
              : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-semibold'"
            :to="link.to"
          >
            {{ link.label }}
          </NuxtLink>
        </nav>

        <a
          class="flex items-center gap-1.5 px-4 py-2 rounded-xl bg-secondary-container text-on-secondary-container font-label-lg text-label-lg font-bold hover:bg-secondary hover:text-on-secondary transition-colors shrink-0"
          :href="adminUrl"
          rel="noopener noreferrer"
          target="_blank"
        >
          <span class="material-symbols-outlined text-body-md">warehouse</span>
          Acceso Cooperativas
          <span class="material-symbols-outlined text-body-md">open_in_new</span>
        </a>
      </div>
    </header>

    <main v-if="showWorkspace" class="grid grid-cols-3 flex-1 min-h-0">
      <section class="relative col-span-2 min-h-0 overflow-hidden">
        <MapaScreen />
      </section>

      <aside class="col-span-1 min-h-0 overflow-y-auto border-l border-outline-variant/40 bg-background">
        <PerfilScreen
          v-if="selectedBuyerId"
          :cooperative-id="String(selectedBuyerId)"
          embedded
          @close="selectedBuyerId = null"
        />
        <ListaScreen
          v-else
          selectable
          @select="selectedBuyerId = $event"
        />
      </aside>
    </main>

    <main v-else class="flex-1 min-h-0 overflow-y-auto bg-background">
      <div class="mx-auto w-full max-w-3xl">
        <slot />
      </div>
    </main>
  </div>
</template>
