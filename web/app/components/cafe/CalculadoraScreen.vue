<script setup lang="ts">
import { factorResult, labSamples, liquidationRows, liquidationTotals } from './data'

const toneClass = {
  neutral: 'text-on-surface-variant',
  positive: 'text-secondary',
  negative: 'text-error'
}
</script>

<template>
  <main class="flex flex-col relative w-full pt-16 pb-safe bg-background min-h-screen">
    <div class="flex flex-col w-full pb-10 max-w-7xl mx-auto lg:px-8">
      <section class="px-margin pt-space-sm pb-space-xs flex flex-col gap-space-xs">
        <div class="flex items-center justify-between">
          <button class="inline-flex items-center gap-space-xs text-primary font-body-md text-body-md font-bold py-space-xs pr-space-sm active:scale-95 transition-transform" type="button">
            <span class="material-symbols-outlined text-body-lg">arrow_back</span>
            <span>Volver a precios</span>
          </button>
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-container text-on-secondary-container font-label-md text-label-md font-bold">
            <span class="w-2 h-2 rounded-full bg-secondary animate-pulse" />
            Al día · En línea
          </span>
        </div>
        <div class="flex flex-wrap items-center gap-space-xs mt-space-xs">
          <span class="bg-primary-fixed text-on-primary-fixed font-label-md text-label-md px-2.5 py-1 rounded-full font-bold">Fórmula Oficial FNC (Base 88-94)</span>
          <span class="bg-surface-container-high text-on-surface-variant font-label-md text-label-md px-2.5 py-1 rounded-full">Calculadora de Trilla y Merma</span>
        </div>
      </section>

      <section class="px-margin mt-space-sm">
        <div class="bg-surface-container-low rounded-xl p-space-md shadow-sm">
          <div class="flex items-start justify-between gap-space-sm">
            <div class="flex items-center gap-space-sm">
              <div class="w-10 h-10 rounded-full bg-primary-container text-on-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-headline-md">storefront</span>
              </div>
              <div>
                <span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider block">Punto de Referencia</span>
                <h2 class="font-headline-md text-headline-md text-on-surface font-bold leading-tight">Cadefihuila — Pitalito</h2>
                <p class="font-label-md text-label-md text-primary font-semibold">Huila, Colombia · Hoy 06:00 AM</p>
              </div>
            </div>
            <button class="p-2 text-on-surface-variant hover:text-primary active:scale-90 transition-transform" type="button" aria-label="Cambiar cooperativa">
              <span class="material-symbols-outlined">tune</span>
            </button>
          </div>

          <div class="grid grid-cols-2 gap-space-sm mt-space-md pt-space-sm bg-surface-container-lowest/80 rounded-lg p-3">
            <div>
              <span class="font-label-md text-label-md text-on-surface-variant block">Precio Carga Base (125kg)</span>
              <span class="font-price-hero-mobile text-price-hero-mobile text-primary font-bold block leading-none mt-1">$1.885.000</span>
              <span class="font-label-md text-label-md text-on-surface-variant">Base 88 kg pergamino</span>
            </div>
            <div class="pl-space-sm">
              <span class="font-label-md text-label-md text-on-surface-variant block">Precio Kilo Base</span>
              <span class="font-headline-md text-headline-md text-on-surface font-bold block leading-none mt-2">$15.080</span>
              <span class="font-label-md text-label-md text-secondary font-semibold mt-1 inline-flex items-center gap-0.5">
                <span class="material-symbols-outlined text-xs">trending_up</span> Premio factor &lt; 88
              </span>
            </div>
          </div>
        </div>
      </section>

      <section class="px-margin mt-space-md">
        <div class="bg-surface-container rounded-xl p-space-md shadow-sm">
          <div class="flex items-center justify-between mb-space-sm">
            <h3 class="font-headline-md text-headline-md text-on-surface font-bold flex items-center gap-2">
              <span class="material-symbols-outlined text-primary">biotech</span>
              Datos de Laboratorio
            </h3>
            <span class="font-label-md text-label-md text-on-surface-variant bg-surface-container-high px-2 py-0.5 rounded-full">Muestra de prueba</span>
          </div>

          <div class="space-y-space-md">
            <div v-for="sample in labSamples" :key="sample.id" class="bg-surface-container-lowest rounded-lg p-space-sm">
              <div class="flex items-center justify-between mb-1">
                <label class="font-body-md text-body-md text-on-surface font-bold flex items-center gap-1.5" :for="`input-${sample.id}`">
                  <span>{{ sample.label }}</span>
                  <span class="material-symbols-outlined text-sm text-outline" title="Estándar oficial FNC">help</span>
                </label>
                <span class="font-label-md text-label-md" :class="sample.emphasize ? 'text-secondary font-semibold' : 'text-on-surface-variant'">{{ sample.hint }}</span>
              </div>
              <div class="flex items-center gap-space-sm mt-1">
                <button class="w-12 h-12 rounded-lg bg-surface-container text-on-surface flex items-center justify-center text-xl font-bold active:bg-surface-container-high select-none" type="button">
                  <span class="material-symbols-outlined">remove</span>
                </button>
                <div class="flex-1 text-center relative">
                  <input
                    :id="`input-${sample.id}`"
                    class="w-full text-center font-headline-md text-headline-md font-bold bg-transparent focus:outline-none"
                    :class="sample.emphasize ? 'text-primary' : 'text-on-surface'"
                    type="number"
                    :value="sample.value"
                    :step="sample.step"
                  >
                  <span class="text-xs text-on-surface-variant absolute -bottom-1 left-0 right-0">{{ sample.unit }}</span>
                </div>
                <button class="w-12 h-12 rounded-lg bg-surface-container text-on-surface flex items-center justify-center text-xl font-bold active:bg-surface-container-high select-none" type="button">
                  <span class="material-symbols-outlined">add</span>
                </button>
              </div>
            </div>

            <div class="bg-surface-container-lowest rounded-lg p-space-sm">
              <div class="flex items-center justify-between mb-2">
                <div>
                  <span class="font-body-md text-body-md text-on-surface font-bold block">Porcentaje de Humedad</span>
                  <span class="font-label-md text-label-md text-secondary font-semibold flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">water_drop</span> Ideal FNC: 10.0% a 12.0%
                  </span>
                </div>
                <span class="font-headline-md text-headline-md text-secondary font-bold">11.2%</span>
              </div>
              <input class="w-full h-2 rounded-lg bg-surface-container-high accent-primary cursor-pointer" type="range" min="9" max="15" step="0.1" value="11.2">
              <div class="flex justify-between items-center text-xs text-on-surface-variant mt-2 px-1">
                <span>9.0% (Muy seco)</span>
                <span class="px-2 py-0.5 rounded-full bg-secondary-container text-on-secondary-container font-bold text-[11px]">Rango óptimo</span>
                <span>15.0% (Mojado)</span>
              </div>
            </div>

            <div class="bg-surface-container-lowest rounded-lg p-space-sm">
              <div class="flex items-center justify-between mb-2">
                <label class="font-body-md text-body-md text-on-surface font-bold" for="input-volumen">Volumen Total del Lote</label>
                <span class="font-label-md text-label-md text-primary font-bold">= 500 kg neto</span>
              </div>
              <div class="grid grid-cols-3 gap-1 bg-surface-container p-1 rounded-xl mb-3">
                <button class="py-2 rounded-lg text-center font-label-lg text-label-lg font-bold bg-primary text-on-primary shadow-sm transition-all" type="button">Arrobas (@)</button>
                <button class="py-2 rounded-lg text-center font-label-lg text-label-lg font-bold text-on-surface-variant hover:text-on-surface transition-all" type="button">Kilos (kg)</button>
                <button class="py-2 rounded-lg text-center font-label-lg text-label-lg font-bold text-on-surface-variant hover:text-on-surface transition-all" type="button">Cargas (125k)</button>
              </div>
              <div class="flex items-center gap-space-sm">
                <button class="w-12 h-12 rounded-lg bg-surface-container text-on-surface flex items-center justify-center text-xl font-bold active:bg-surface-container-high select-none" type="button">
                  <span class="material-symbols-outlined">remove</span>
                </button>
                <div class="flex-1 text-center">
                  <input id="input-volumen" class="w-full text-center font-price-hero-mobile text-price-hero-mobile text-on-surface font-bold bg-transparent focus:outline-none" type="number" value="40">
                </div>
                <button class="w-12 h-12 rounded-lg bg-surface-container text-on-surface flex items-center justify-center text-xl font-bold active:bg-surface-container-high select-none" type="button">
                  <span class="material-symbols-outlined">add</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="px-margin mt-space-md">
        <div class="bg-gradient-to-br from-surface-container-lowest to-surface-container-low rounded-xl p-space-md shadow-md">
          <div class="flex items-start justify-between">
            <div>
              <span class="font-label-md text-label-md text-secondary font-bold uppercase tracking-wide flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">verified</span> Resultado de Calidad
              </span>
              <h3 class="font-headline-lg-mobile text-headline-lg-mobile text-on-surface font-bold mt-1">Factor de Rendimiento</h3>
            </div>
            <div class="bg-secondary-container px-3 py-1.5 rounded-full flex items-center gap-1 text-on-secondary-container">
              <span class="material-symbols-outlined text-sm">stars</span>
              <span class="font-label-md text-label-md font-bold">¡Premio FNC!</span>
            </div>
          </div>

          <div class="flex items-baseline gap-space-sm my-space-sm">
            <span class="font-price-hero text-price-hero text-secondary font-bold leading-none">{{ factorResult.factor }}</span>
            <div class="flex flex-col">
              <span class="font-body-md text-body-md font-bold text-on-surface">kg pergamino / saco 70kg</span>
              <span class="font-label-md text-label-md text-secondary font-semibold">Base óptima: &lt; 88.0</span>
            </div>
          </div>

          <div class="bg-surface-container rounded-lg p-space-sm text-on-surface-variant font-body-md text-body-md">
            <p class="leading-relaxed">
              <strong class="text-on-surface">Excelente Grano:</strong> Solo requieres
              <span class="text-secondary font-bold">{{ factorResult.factorHint }}</span> de pergamino seco para lograr un saco exportable de 70 kg. Tu lote recibe una bonificación de <strong class="text-secondary">+$42.500 COP</strong> por carga.
            </p>
          </div>

          <div class="grid grid-cols-2 gap-space-sm mt-space-sm pt-space-xs">
            <div class="p-2.5 bg-surface-container-lowest rounded-lg">
              <span class="font-label-md text-label-md text-on-surface-variant block">Almendra Sana</span>
              <span class="font-headline-md text-headline-md font-bold text-on-surface block mt-0.5">{{ factorResult.almendraSana }}</span>
              <span class="font-label-md text-label-md text-secondary font-semibold">{{ factorResult.almendraPct }}</span>
            </div>
            <div class="p-2.5 bg-surface-container-lowest rounded-lg">
              <span class="font-label-md text-label-md text-on-surface-variant block">Merma / Pasilla</span>
              <span class="font-headline-md text-headline-md font-bold text-tertiary block mt-0.5">{{ factorResult.merma }}</span>
              <span class="font-label-md text-label-md text-secondary font-semibold">{{ factorResult.mermaHint }}</span>
            </div>
          </div>
        </div>
      </section>

      <section class="px-margin mt-space-md">
        <div class="bg-surface-container-low rounded-xl p-space-md shadow-sm">
          <div class="flex items-center justify-between pb-space-sm">
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-primary">receipt_long</span>
              <h3 class="font-headline-md text-headline-md text-on-surface font-bold">Liquidación Estimada</h3>
            </div>
            <span class="font-label-md text-label-md text-outline font-semibold">Transparencia FNC</span>
          </div>

          <div class="space-y-2.5 pt-space-xs font-body-md text-body-md">
            <div
              v-for="row in liquidationRows"
              :key="row.label"
              class="flex justify-between items-center"
              :class="toneClass[row.tone]"
            >
              <span class="flex items-center gap-1">
                <span v-if="row.icon" class="material-symbols-outlined text-sm">{{ row.icon }}</span>
                {{ row.label }}
              </span>
              <span class="font-bold">{{ row.value }}</span>
            </div>
          </div>

          <div class="mt-space-md bg-secondary text-on-secondary rounded-xl p-space-md shadow-md">
            <div class="flex justify-between items-center">
              <span class="font-label-lg text-label-lg font-bold tracking-wide uppercase text-secondary-fixed">Total Neto a Recibir</span>
              <span class="material-symbols-outlined text-secondary-fixed">payments</span>
            </div>
            <div class="my-space-xs">
              <span class="font-price-hero text-price-hero font-bold tracking-tight block">{{ liquidationTotals.total }}</span>
            </div>
            <div class="grid grid-cols-2 gap-space-sm pt-space-xs text-sm border-t border-secondary-fixed/20">
              <div>
                <span class="text-secondary-fixed text-xs block">Por Arroba (@ neta)</span>
                <span class="font-headline-md text-headline-md font-bold text-on-secondary">{{ liquidationTotals.perArroba }}</span>
              </div>
              <div>
                <span class="text-secondary-fixed text-xs block">Por Kilo (kg neto)</span>
                <span class="font-headline-md text-headline-md font-bold text-on-secondary">{{ liquidationTotals.perKilo }}</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="px-margin mt-space-md flex flex-col gap-space-sm">
        <button class="w-full min-h-[48px] py-3.5 px-space-md rounded-xl bg-primary text-on-primary font-label-lg text-label-lg font-bold flex items-center justify-center gap-2 active:scale-98 shadow-sm transition-all" type="button">
          <span class="material-symbols-outlined">save</span>
          <span>Guardar en Historial de Finca</span>
        </button>
        <button class="w-full min-h-[48px] py-3.5 px-space-md rounded-xl bg-[#006d44] text-white font-label-lg text-label-lg font-bold flex items-center justify-center gap-2 active:scale-98 shadow-sm transition-all" type="button">
          <span class="material-symbols-outlined">send</span>
          <span>Enviar Liquidación por WhatsApp</span>
        </button>
        <button class="w-full min-h-[48px] py-3 px-space-md rounded-xl bg-surface-container-high text-on-surface font-label-lg text-label-lg font-semibold flex items-center justify-center gap-2 active:scale-98 transition-all" type="button">
          <span class="material-symbols-outlined text-outline">picture_as_pdf</span>
          <span>Descargar Volante de Pesaje (PDF)</span>
        </button>
      </section>

      <section class="px-margin mt-space-lg">
        <div class="relative rounded-xl overflow-hidden shadow-sm h-36 bg-surface-container">
          <img
            class="w-full h-full object-cover"
            alt="Mesa de laboratorio con pergamino seco pesado en balanza de precisión"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuAKZAPXr86uv5Cu0Zgx8l-7UQKmkJiv_DOda1poE5rNbCvX5BztdFo6kyybdqMzD0PTkuCKdeB0-uORzOVi50G7lxmR0eJK4fl-Jr02TwNNQJ39ftIx4DMntYtvIlwauLxsW2m_hPiQrxX_COwF7W0LDhlZV5-9ZtMfyw9-m3xN3y1_4eB0JqFIwTQm8zge9KqrWQraqTqkTTYEf8RzooEOp4rCRpCgsF7ari0Q1no"
          >
          <div class="absolute inset-0 bg-gradient-to-t from-inverse-surface/85 via-inverse-surface/40 to-transparent flex items-end p-space-md">
            <span class="font-label-md text-label-md text-inverse-on-surface font-semibold">Cada muestra define tu liquidación final en báscula</span>
          </div>
        </div>
      </section>
    </div>
  </main>
</template>
