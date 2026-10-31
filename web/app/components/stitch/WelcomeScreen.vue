<script setup lang="ts">
const goTo = (path: string) => navigateTo(path)
</script>

<template>
  <div class="min-h-screen bg-surface-dim flex justify-center">
    <div class="w-full max-w-md min-h-screen bg-surface shadow-xl flex flex-col">
      <main class="flex flex-col relative w-full px-gutter min-h-screen bg-surface">
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
                ¿Cómo quieres ingresar?
              </h1>
              <p class="font-body-md text-body-md text-on-surface-variant">
                Personaliza tu experiencia según tu actividad en el campo cafetero.
              </p>
            </div>
          </div>

          <div class="flex flex-col gap-4 mt-6">
            <div
              class="group relative flex flex-col p-5 rounded-2xl bg-surface-container-lowest shadow-md active:scale-[0.98] transition-all duration-200 cursor-pointer text-left"
              role="button"
              tabindex="0"
              @click="goTo('/mapa')"
              @keydown.enter="goTo('/mapa')"
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
                      Soy Caficultor
                    </h2>
                  </div>
                </div>
                <div class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center text-primary group-hover:translate-x-0.5 transition-transform">
                  <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                </div>
              </div>
              <p class="font-body-md text-body-md text-on-surface-variant mb-4">
                Ver precios de hoy, comparar cooperativas cercanas, calcular factor de rendimiento y planear venta de cosecha.
              </p>
              <div class="flex items-center gap-2 py-2 px-3 rounded-xl bg-surface-container-low text-on-surface-variant mb-4">
                <span class="material-symbols-outlined text-secondary text-[18px]">verified</span>
                <span class="font-label-md text-label-md text-on-surface font-semibold">Acceso a mapa y cotizaciones en vivo</span>
              </div>
              <button
                class="w-full h-12 rounded-xl bg-primary-container text-on-primary font-label-lg text-label-lg flex items-center justify-center gap-2 shadow-sm group-hover:bg-primary transition-colors"
                type="button"
              >
                <span>Ingresar como Caficultor</span>
                <span class="material-symbols-outlined text-[18px]">east</span>
              </button>
            </div>

            <div
              class="group relative flex flex-col p-5 rounded-2xl bg-surface-container-lowest shadow-md active:scale-[0.98] transition-all duration-200 cursor-pointer text-left"
              role="button"
              tabindex="0"
              @click="goTo('/login')"
              @keydown.enter="goTo('/login')"
            >
              <div class="flex items-start justify-between gap-3 mb-3">
                <div class="flex items-center gap-3">
                  <div class="w-12 h-12 rounded-xl bg-secondary-container/60 flex items-center justify-center text-secondary group-hover:bg-secondary-container transition-colors">
                    <span
                      class="material-symbols-outlined text-[28px]"
                      style="font-variation-settings: 'FILL' 1"
                    >warehouse</span>
                  </div>
                  <div class="flex flex-col">
                    <span class="font-label-md text-label-md px-2.5 py-0.5 rounded-full bg-secondary-container text-on-secondary-container self-start mb-1 font-semibold">
                      Gestión Comercial
                    </span>
                    <h2 class="font-headline-md text-headline-md text-on-surface group-hover:text-secondary transition-colors">
                      Soy Cooperativa o Acopio
                    </h2>
                  </div>
                </div>
                <div class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center text-secondary group-hover:translate-x-0.5 transition-transform">
                  <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                </div>
              </div>
              <p class="font-body-md text-body-md text-on-surface-variant mb-4">
                Publicar y gestionar precios del día, actualizar tiempos de espera en báscula y recibir cotizaciones directas.
              </p>
              <div class="flex items-center gap-2 py-2 px-3 rounded-xl bg-surface-container-low text-on-surface-variant mb-4">
                <span class="material-symbols-outlined text-secondary text-[18px]">query_stats</span>
                <span class="font-label-md text-label-md text-on-surface font-semibold">Panel de precios y gestión de recibo</span>
              </div>
              <button
                class="w-full h-12 rounded-xl bg-secondary text-on-secondary font-label-lg text-label-lg flex items-center justify-center gap-2 shadow-sm group-hover:bg-on-secondary-fixed-variant transition-colors"
                type="button"
              >
                <span>Ingresar como Cooperativa</span>
                <span class="material-symbols-outlined text-[18px]">east</span>
              </button>
            </div>
          </div>

          <div class="flex flex-col items-center gap-4 mt-8 pt-4">
            <button
              class="flex items-center gap-1.5 px-4 py-2 rounded-full text-on-surface-variant hover:text-primary active:bg-surface-container transition-colors"
              type="button"
              @click="goTo('/mapa')"
            >
              <span class="material-symbols-outlined text-[18px]">visibility</span>
              <span class="font-label-lg text-label-lg underline underline-offset-4 font-semibold">
                Explorar como visitante (modo solo lectura)
              </span>
            </button>
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
    </div>
  </div>
</template>
