<script setup lang="ts">
const { apiBase } = useRuntimeConfig().public
const adminUrl = `${String(apiBase).replace(/\/api\/?$/, '')}/admin`

const goToMap = (): void => {
  navigateTo('/mapa')
}
</script>

<template>
  <main class="flex flex-col relative w-full px-gutter min-h-screen bg-surface md:hidden">
    <div class="flex flex-col w-full pb-8">
          <div class="flex flex-col gap-5 pt-2">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-2">
                <div class="w-9 h-9 rounded-xl bg-primary-container flex items-center justify-center shadow-sm">
                  <span
                    class="material-symbols-outlined text-surface-container-lowest text-[20px]"
                    style="font-variation-settings: 'FILL' 1"
                  >local_cafe</span>
                </div>
                <div class="flex flex-col">
                  <span class="font-headline-md text-headline-md tracking-tight text-primary leading-none">CaféPrecios</span>
                  <span class="font-label-md text-label-md text-on-surface-variant leading-tight">Colombia · En Vivo</span>
                </div>
              </div>
              <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-container text-on-secondary-container shadow-sm">
                <span class="w-2 h-2 rounded-full bg-secondary animate-pulse" />
                <span class="font-label-md text-label-md font-semibold">Sin registro</span>
              </div>
            </div>

            <div class="relative w-full rounded-2xl overflow-hidden shadow-sm h-36 flex items-end p-4">
              <div
                class="absolute inset-0 bg-cover bg-center"
                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCL08AngJV0jEgeoiOlgyJDYljUmtenCli2ZeoWnIAQ5AqiTkeejr0chTylMnDsbrGvRVpN_EjXNOI2CJflsjpqfqdIfXh2LsKJEmVcfNtKBLJPqUywAAd7aN2__W782NjEj7GXmGmMcoktCx_nkNP383nTGiF10j0TdAxk-jMVWEtwMlEZ_hA1J88mnxnjYuJigpm77sY3hRddRMVJ06Gk5Da68AhbaIYkTr2Shn8')"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-inverse-surface/90 via-inverse-surface/40 to-transparent" />
              <div class="relative z-10 flex flex-col">
                <span class="font-label-md text-label-md text-secondary-fixed font-bold uppercase tracking-wider">Cosecha Cafetera 2025</span>
                <p class="font-body-md text-body-md text-inverse-on-surface font-semibold line-clamp-1">Precios oficiales actualizados al instante en finca y acopio</p>
              </div>
            </div>

            <div class="flex flex-col gap-1.5">
              <h1 class="font-headline-lg-mobile text-headline-lg-mobile text-on-surface tracking-tight">
                Precios del café, claros y en vivo
              </h1>
              <p class="font-body-md text-body-md text-on-surface-variant">
                Consulta gratis las cotizaciones de cooperativas y compradores cerca de tu finca.
              </p>
            </div>
          </div>

          <div class="mt-6">
            <div
              class="group relative flex flex-col p-5 rounded-2xl bg-surface-container-lowest shadow-md active:scale-[0.98] transition-all duration-200 cursor-pointer text-left"
              role="button"
              tabindex="0"
              @click="goToMap"
              @keydown.enter="goToMap"
            >
              <div class="flex items-start justify-between gap-3 mb-3">
                <div class="flex items-center gap-3">
                  <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-primary-container group-hover:bg-primary-fixed transition-colors">
                    <span
                      class="material-symbols-outlined text-[28px]"
                      style="font-variation-settings: 'FILL' 1"
                    >spa</span>
                  </div>
                  <div class="flex flex-col">
                    <span class="font-label-md text-label-md px-2.5 py-0.5 rounded-full bg-surface-variant text-on-surface-variant self-start mb-1 font-semibold">
                      Acceso inmediato
                    </span>
                    <h2 class="font-headline-md text-headline-md text-on-surface group-hover:text-primary transition-colors">
                      Precios del café hoy
                    </h2>
                  </div>
                </div>
                <div class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center text-primary group-hover:translate-x-0.5 transition-transform">
                  <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                </div>
              </div>
              <p class="font-body-md text-body-md text-on-surface-variant mb-4">
                Ver precios de hoy, comparar cooperativas cercanas, calcular factor de rendimiento y planear la venta de tu cosecha.
              </p>
              <div class="flex items-center gap-2 py-2 px-3 rounded-xl bg-surface-container-low text-on-surface-variant mb-4">
                <span class="material-symbols-outlined text-secondary text-[18px]">verified</span>
                <span class="font-label-md text-label-md text-on-surface font-semibold">Acceso a mapa y cotizaciones en vivo</span>
              </div>
              <button
                class="w-full h-12 rounded-xl bg-primary-container text-on-primary font-label-lg text-label-lg flex items-center justify-center gap-2 shadow-sm group-hover:bg-primary transition-colors"
                type="button"
              >
                <span>Ver Precios del Café</span>
                <span class="material-symbols-outlined text-[18px]">east</span>
              </button>
            </div>
          </div>

          <div class="flex flex-col items-center gap-4 mt-8 pt-4">
            <a
              class="w-full min-h-[56px] px-4 rounded-2xl border border-outline-variant bg-surface-container-lowest text-on-surface flex items-center gap-3 shadow-sm hover:border-primary hover:bg-surface-container active:scale-[0.98] transition-all"
              :href="adminUrl"
              rel="noopener noreferrer"
              target="_blank"
            >
              <span class="material-symbols-outlined text-[22px] text-primary">login</span>
              <span class="flex flex-col items-start">
                <span class="font-label-lg text-label-lg font-bold">Iniciar sesión</span>
                <span class="font-label-md text-label-md text-on-surface-variant">Acceso para cooperativas y acopios</span>
              </span>
              <span class="material-symbols-outlined text-[18px] text-on-surface-variant ml-auto">open_in_new</span>
            </a>
            <div class="w-full p-3.5 rounded-xl bg-surface-container-low flex items-center gap-3">
              <div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-tertiary flex-shrink-0">
                <span class="material-symbols-outlined text-[20px]">verified_user</span>
              </div>
              <p class="font-label-md text-label-md text-on-surface-variant">
                Información avalada con precios base de la
                <span class="font-bold text-on-surface">Federación Nacional de Cafeteros (FNC)</span>
                y cooperativas aliadas de Colombia.
              </p>
            </div>
          </div>
    </div>
  </main>
</template>
