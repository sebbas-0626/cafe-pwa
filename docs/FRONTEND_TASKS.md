# Frontend Tasks - Cafe PWA (Nuxt 4)

## Reglas de trabajo con IA
- Una tarea por sesión. No mezclar tareas.
- Alcance cerrado: "solo esto, nada más".
- No tests, no código de relleno, no refactors no pedidos.
- Si una tarea requiere más de ~40 líneas, dividirla.
- El diseño de Stitch (carpeta `template/`) es la fuente de verdad visual.
- Los datos mock viven en `app/components/cafe/data.ts`, nunca inline en los componentes.
- `template/` tiene copias espejo en `template/stitch_caf_precios_colombia_pwa/`. Usar siempre la copia de primer nivel.
- NO inventar estilos, colores, fuentes ni componentes que no estén en Stitch.
- NO tocar `api/` ni el backend.

## Orden de dependencia
Setup → Tipos → Componentes → Páginas → Composables API → Conexión API → Mapa → PWA.

## Estado actual
- [x] Proyecto Nuxt creado
- [x] Tailwind + tokens Stitch configurados
- [x] Fuentes Stitch cargadas
- [x] PWA configurada
- [x] Cliente API (`useApi`) listo
- [x] Tipos TypeScript
- [ ] Componentes Stitch adaptados
- [ ] Páginas y navegación
- [ ] Conexión a API
- [ ] Mapa MapLibre
- [ ] Offline

---

## FASE 0: Setup del proyecto (una tarea por sesión)

### T0.1 - Crear proyecto Nuxt
- En la raíz del monorepo, crear `web/` con Nuxt 4.
- Configurar TypeScript.
- NO instalar módulos extra todavía.
- Verificar que `npm run dev` funciona.

### T0.2 - Instalar Tailwind
- Instalar `@nuxtjs/tailwindcss` en `web/`.
- Verificar que el archivo de configuración se genera correctamente.
- NO definir colores todavía (eso es T0.3).
- NO crear componentes todavía.

### T0.3 - Tokens de diseño desde Stitch
- Leer `template/mapa_de_precios_cafeteros/code.html` y `template/tierra_grano_ui/DESIGN.md`.
- Extraer colores, familias tipográficas y radios al `tailwind.config`.
- NO crear componentes. NO inventar valores que no estén en el template.

### T0.4 - Cargar fuentes Epilogue y Quicksand
- Registrar ambas familias en `app.head` de `nuxt.config.ts` con `<link>` a Google Fonts.
- Pesos: Epilogue 600/700, Quicksand 500/600/700.
- Incluir también Material Symbols Outlined (iconos del template).
- NO instalar paquetes. NO crear archivos de estilos globales.

### T0.5 - Configurar PWA
- Instalar `@vite-pwa/nuxt`.
- Configurar manifest mínimo (nombre, icono, theme_color).
- NO crear Service Worker custom todavía (eso es T7.2).

### T0.6 - Estructura de carpetas
- Crear `app/components/cafe/`, `app/components/map/`, `app/layouts/`, `app/pages/`, `app/composables/`, `app/types/`.
- Solo carpetas vacías. NO crear archivos.

### T0.7 - Variables de entorno
- Crear `web/.env` con `NUXT_PUBLIC_API_BASE=http://localhost:8000/api`.
- Configurar `nuxt.config.ts` (`runtimeConfig.public.apiBase`) para leerla.

### T0.8 - Cliente API `useApi`
- Instalar `axios`.
- Crear `app/composables/useApi.ts` con una instancia de axios que use `runtimeConfig.public.apiBase`.
- Manejo de error uniforme (mensaje + status) con `toApiError`.
- NO usarlo en componentes todavía.

---

## FASE 1: Tipos (una tarea por sesión)

### T1.1 - Tipos TypeScript
- Crear `app/types/index.ts` con interfaces: `Buyer`, `PriceOffer`, `CoffeeVariety`.
- Incluir `OfferCardProps` y `PerfilScreenProps`.
- Basados en el ER del backend.

---

## FASE 2: Componentes Stitch (una tarea por sesión)

### T2.1 - OfferCard (reutilizable)
- Leer la tarjeta de oferta de `template/comparaci_n_de_precios_de_caf/code.html`.
- Crear `app/components/cafe/OfferCard.vue`.
- Props (`OfferCardProps`): `buyerName`, `price`, `variety`, `updatedAt`.
- NO conectar API.

### T2.2 - ListaScreen: estructura
- Leer `template/comparaci_n_de_precios_de_caf/code.html`.
- Crear `app/components/cafe/ListaScreen.vue` usando `OfferCard.vue`. Datos hardcodeados.
- NO aplicar responsive todavía (eso es T2.3).

### T2.3 - ListaScreen: responsive
- Grid `grid-cols-1 md:grid-cols-2 lg:grid-cols-3` y contenedor `max-w-7xl`.
- No eliminar clases móviles.

### T2.4 - PerfilScreen: estructura
- Leer `template/perfil_cooperativa_cadefihuila/code.html`.
- Crear `app/components/cafe/PerfilScreen.vue`.
- Props: `cooperativeId` (string). Datos hardcodeados.
- NO aplicar responsive todavía (eso es T2.5).

### T2.5 - PerfilScreen: responsive
- Añadir prefijos `md:`/`lg:` según `docs/FRONTEND_STITCH.md`.
- No eliminar clases móviles.

### T2.6 - CalculadoraScreen: estructura
- Leer `template/calculadora_de_factor_de_rendimiento_y_merma/code.html`.
- Crear `app/components/cafe/CalculadoraScreen.vue`.
- Datos hardcodeados, sin lógica de cálculo.
- NO aplicar responsive todavía (eso es T2.7).

### T2.7 - CalculadoraScreen: responsive
- Añadir prefijos `md:`/`lg:` según `docs/FRONTEND_STITCH.md`.
- No eliminar clases móviles.

---

## FASE 3: Navegación y páginas (una tarea por sesión)

### T3.1 - Layout principal: header web
- Crear `app/layouts/default.vue` con header y links horizontales (`hidden md:flex`).
- Usar colores de Stitch.

### T3.2 - Layout principal: nav móvil
- Añadir menú hamburguesa (`md:hidden`) al layout, con estado abierto/cerrado.
- Sin lógica de datos.

### T3.3 - Página Home (mapa)
- Crear `app/pages/index.vue` que use `MapaScreen.vue`.
- Sin lógica de datos aún.

### T3.4 - Página Lista
- Crear `app/pages/lista.vue` que use `ListaScreen.vue`.

### T3.5 - Página Perfil
- Crear `app/pages/cooperativa/[id].vue` que use `PerfilScreen.vue`.
- Pasar `id` de la ruta como prop `cooperativeId`.

### T3.6 - Página Calculadora
- Crear `app/pages/calculadora.vue` que use `CalculadoraScreen.vue`.

### T3.7 - Navegación Lista → Perfil
- Envolver `OfferCard` en `NuxtLink` a `/cooperativa/{id}`.
- Añadir `id` a las props de `OfferCard`.

---

## FASE 4: Composables API (una tarea por sesión)

### T4.1 - Composable useBuyers: lista
- Crear `app/composables/useBuyers.ts` con `fetchBuyers()` usando `useApi`.
- Manejo básico de loading/error.
- NO usar en componentes todavía.

### T4.2 - Composable useBuyers: detalle
- Añadir `fetchBuyerById(id)` al mismo composable.
- Manejo básico de loading/error.

### T4.3 - Composable usePriceOffers
- Crear `app/composables/usePriceOffers.ts` con `fetchByVariety(varietyId)`.
- NO usar en componentes todavía.

---

## FASE 5: Conexión API (una tarea por sesión)

### T5.1 - Conectar ListaScreen a API
- Usar `useBuyers().fetchBuyers` en `ListaScreen.vue`.
- Reemplazar datos hardcodeados por datos reales.
- Loading y error básicos.

### T5.2 - Conectar PerfilScreen a API
- Usar `fetchBuyerById` en `PerfilScreen.vue` con `cooperativeId`.
- Loading y error básicos.

### T5.3 - Conectar OfferCard a datos reales
- Ajustar props a los tipos de la API (`PriceOffer`).
- Formatear precio y fecha.

---

## FASE 6: Mapa MapLibre (una tarea por sesión)

### T6.1 - Instalar MapLibre
- Instalar `maplibre-gl` en `web/`.
- NO crear componente todavía.

### T6.2 - MapaScreen: estructura
- Leer `template/mapa_de_precios_cafeteros/code.html`.
- Crear `app/components/cafe/MapaScreen.vue` con el `<body>` envuelto en `<template>`.
- Zona de mapa como placeholder. Datos hardcodeados.
- NO aplicar responsive todavía (eso es T6.3). NO conectar API.

### T6.3 - MapaScreen: responsive
- Añadir prefijos `md:`/`lg:` según `docs/FRONTEND_STITCH.md`.
- Layout web: mapa 2/3, panel 1/3. No eliminar clases móviles.

### T6.4 - Componente MapaBase
- Crear `app/components/map/MapaBase.vue` con init SSR-safe (`ClientOnly`).
- Solo renderiza el mapa centrado en Colombia. Sin pines.

### T6.5 - Añadir pines de buyers
- Recibir lista de buyers como prop y renderizar un pin por buyer con lat/lng.

### T6.6 - Popup al hacer clic en pin
- Mostrar nombre, precio y botón de contacto.
- Usar estilos de Stitch.

### T6.7 - Integrar MapaBase en MapaScreen
- Reemplazar el placeholder de mapa por `MapaBase.vue`.

### T6.8 - Alimentar pines con datos de API
- En `app/pages/index.vue`, usar `fetchBuyers` y pasar los buyers a `MapaScreen`.
- Loading y error básicos.

---

## FASE 7: PWA y offline (una tarea por sesión)

### T7.1 - Manifest completo
- Iconos, colores, nombre, short_name en el manifest de T0.5.

### T7.2 - Service Worker: precache del shell
- Precachar HTML/JS/CSS de la app.
- NO cachear API todavía.

### T7.3 - Fallback offline
- Página/estado mostrado cuando el shell no está en caché y no hay red.

### T7.4 - Indicador offline
- Componente simple que muestre "Sin conexión" cuando `navigator.onLine` sea false.

### T7.5 - Página 404
- Crear `app/error.vue` con estilos de Stitch, cubriendo rutas `[id]` inválidas.

---

## FASE 8: Pulido (solo si hay tiempo)

### T8.1 - Filtros (mejor precio / más cercano)
### T8.2 - Loading skeletons
### T8.3 - Manejo de errores visual
