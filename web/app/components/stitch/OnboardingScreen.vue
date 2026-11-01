<script setup lang="ts">
const emit = defineEmits<{
  finish: []
}>()

const { apiBase } = useRuntimeConfig().public
const loginUrl = `${String(apiBase).replace(/\/api\/?$/, '')}/admin`

interface OnboardingSlide {
  icon: string
  title: string
  description: string
  chipIcon: string
  chipLabel: string
  accentClasses: string
  iconColorClass: string
}

const slides: OnboardingSlide[] = [
  {
    icon: 'payments',
    title: 'Precios Transparentes',
    description: 'Compara ofertas al instante por arroba (@) y carga oficial FNC (125 kg) entre cooperativas y compradores locales.',
    chipIcon: 'trending_up',
    chipLabel: 'FNC Base',
    accentClasses: 'bg-secondary/30',
    iconColorClass: 'text-secondary-fixed'
  },
  {
    icon: 'near_me',
    title: 'Mapa de Compra Cercano',
    description: 'Ubica puntos de pesaje, cooperativas aliadas y trilladoras en Huila, Antioquia, Cauca y Caldas con tarifas del día.',
    chipIcon: 'map',
    chipLabel: 'Centros',
    accentClasses: 'bg-primary-container/40',
    iconColorClass: 'text-primary-fixed'
  },
  {
    icon: 'filter_vintage',
    title: 'Bonificación por Variedad',
    description: 'Cotiza con sobreprecio tu café especial: Castillo, Caturra, Borbón Rosado, Geisha y factor de rendimiento.',
    chipIcon: 'psychiatry',
    chipLabel: 'Especiales',
    accentClasses: 'bg-tertiary-container/50',
    iconColorClass: 'text-tertiary-fixed'
  }
]

const currentSlide = ref(0)

const selectSlide = (index: number): void => {
  currentSlide.value = index
}

const nextSlide = (): void => {
  currentSlide.value = (currentSlide.value + 1) % slides.length
}
</script>

<template>
  <main class="flex flex-col relative w-full min-h-screen overflow-hidden bg-surface md:hidden">
    <div class="relative w-full overflow-hidden shadow-2xl flex flex-col justify-between" style="min-height: 100dvh">
          <img
            alt="Manos trabajadoras campesinas sosteniendo cerezas maduras de café en el campo colombiano"
            class="absolute inset-0 w-full h-full object-cover object-center z-0"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBkJvtouf2mvJEW12Rz40e6tSyEA49CQO3jbA-g6XU67INlIlsM65HHcduhbJlDlUf8jkR1hMir7kJLxl72hLps8ZGtViJOMEQ7JPNq1g5mBjUPz79vnZE_99HTicw3_R2orfNdQ5LX0lKeCDprCQxlzup8e4-IUl31EwEMWngKyUyI-irkJw9fLJLTeasXV2Pxb00iMa4pFIZCHiZoVLVy7to2-RrVfQtt4U8-grg"
          >
          <div class="absolute inset-0 bg-gradient-to-b from-inverse-surface/85 via-inverse-surface/30 to-on-surface z-10" />
          <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-on-surface/75 to-transparent z-10" />

          <header class="relative z-20 px-space-md pt-space-lg flex items-center justify-between">
            <div class="flex items-center gap-2 bg-on-surface/40 backdrop-blur-md px-3.5 py-1.5 rounded-full shadow-sm">
              <span
                class="material-symbols-outlined text-secondary-fixed text-[20px]"
                style="font-variation-settings: 'FILL' 1"
              >eco</span>
              <span class="font-headline-md text-headline-md text-on-primary tracking-tight">CaféPrecios</span>
            </div>
            <div class="flex items-center gap-1.5 bg-inverse-surface/70 backdrop-blur-md px-3 py-1.5 rounded-full">
              <span class="w-2 h-2 rounded-full bg-secondary-fixed animate-pulse" />
              <span class="font-label-md text-label-md text-secondary-fixed tracking-wide uppercase">En Línea • FNC</span>
            </div>
          </header>

          <div class="relative z-20 px-space-md pt-space-xl flex flex-col">
            <div class="inline-flex items-center gap-1.5 bg-surface-tint/60 text-primary-fixed backdrop-blur-md px-3 py-1 rounded-full self-start mb-3">
              <span class="material-symbols-outlined text-[16px]">verified</span>
              <span class="font-label-md text-label-md uppercase tracking-wider font-semibold">Cosecha 2025</span>
            </div>
            <h1 class="font-display-lg-mobile text-display-lg-mobile text-on-primary tracking-tight font-bold drop-shadow-md">
              Bienvenido a CaféPrecios
            </h1>
            <p class="font-body-lg text-body-lg text-primary-fixed/90 mt-2 max-w-[90%] drop-shadow">
              Encuentra quién paga mejor por tu cosecha en tiempo real, directo en la finca.
            </p>
          </div>

          <div class="relative z-20 px-3 pb-space-md pt-space-sm mt-auto">
            <div class="bg-inverse-surface/90 backdrop-blur-xl rounded-2xl p-space-md shadow-2xl flex flex-col gap-space-md">
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-1.5">
                  <span
                    v-for="(slide, index) in slides"
                    :key="`dot-${slide.chipLabel}`"
                    class="h-2 rounded-full transition-all duration-300"
                    :class="index === currentSlide ? 'w-7 bg-secondary-fixed' : 'w-2 bg-outline-variant/40'"
                  />
                </div>
                <span class="font-label-md text-label-md text-primary-fixed/70">
                  {{ currentSlide + 1 }} de {{ slides.length }} beneficios
                </span>
              </div>

              <div class="relative overflow-hidden w-full min-h-[118px]">
                <div
                  v-for="(slide, index) in slides"
                  :key="slide.title"
                  class="flex-col gap-1.5 transition-all duration-500"
                  :class="index === currentSlide
                    ? 'flex translate-x-0 opacity-100'
                    : 'hidden translate-x-full opacity-0'"
                >
                  <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center" :class="slide.accentClasses">
                      <span
                        class="material-symbols-outlined text-[20px]"
                        :class="slide.iconColorClass"
                        style="font-variation-settings: 'FILL' 1"
                      >{{ slide.icon }}</span>
                    </div>
                    <h2 class="font-headline-md text-headline-md text-on-primary font-bold">
                      {{ slide.title }}
                    </h2>
                  </div>
                  <p class="font-body-md text-body-md text-surface-container-high/90 leading-snug">
                    {{ slide.description }}
                  </p>
                </div>
              </div>

              <div class="grid grid-cols-3 gap-1.5 pt-1">
                <button
                  v-for="(slide, index) in slides"
                  :key="`chip-${slide.chipLabel}`"
                  class="flex flex-col items-center justify-center p-2 rounded-xl transition-all text-center focus:outline-none"
                  :class="index === currentSlide
                    ? 'bg-surface-container-highest/20'
                    : 'bg-surface-container-highest/10 opacity-75'"
                  type="button"
                  @click="selectSlide(index)"
                >
                  <span
                    class="material-symbols-outlined text-[18px]"
                    :class="index === currentSlide ? 'text-secondary-fixed' : 'text-outline-variant'"
                  >{{ slide.chipIcon }}</span>
                  <span
                    class="font-label-md text-label-md font-semibold mt-0.5 truncate w-full"
                    :class="index === currentSlide ? 'text-on-primary' : 'text-outline-variant'"
                  >{{ slide.chipLabel }}</span>
                </button>
              </div>

              <div class="flex flex-col gap-2.5 pt-2">
                <button
                  class="w-full min-h-[52px] bg-primary-container hover:bg-primary active:scale-[0.98] text-on-primary rounded-2xl flex items-center justify-center gap-2.5 shadow-lg transition-all duration-200 focus:outline-none"
                  type="button"
                  @click="emit('finish')"
                >
                  <span class="font-headline-md text-headline-md tracking-wide">Empezar ahora</span>
                  <span class="material-symbols-outlined text-[22px]">arrow_forward</span>
                </button>
                <div class="flex items-center justify-between px-2 pt-1">
                  <button
                    class="font-label-lg text-label-lg text-primary-fixed hover:text-on-primary transition-colors py-2 flex items-center gap-1 focus:outline-none"
                    type="button"
                    @click="nextSlide"
                  >
                    <span>Ver siguiente</span>
                    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                  </button>
                  <a
                    class="font-label-lg text-label-lg text-outline-variant hover:text-surface-container-low transition-colors py-2 flex items-center gap-1"
                    :href="loginUrl"
                    rel="noopener noreferrer"
                    target="_blank"
                  >
                    <span class="material-symbols-outlined text-[16px]">login</span>
                    <span>Iniciar sesión</span>
                  </a>
                </div>
              </div>
            </div>

            <div class="mt-3 flex items-center justify-center gap-2 text-center py-1">
              <span class="material-symbols-outlined text-[15px] text-secondary-fixed">cloud_sync</span>
              <p class="font-label-md text-label-md text-surface-container-highest/80">
                Modo sin conexión activo • Funciona en cafetales sin señal
              </p>
            </div>
          </div>
    </div>
  </main>
</template>
