# Frontend: adaptación del diseño Stitch (móvil → web)

## Contexto
- La carpeta `template/` contiene el HTML + Tailwind CSS exportado de Google Stitch.
- Stitch diseñó para **móvil**. Necesitamos adaptarlo a **web responsive**.
- NO reescribir estilos desde cero. NO inventar nuevos colores, fuentes ni componentes.
- El diseño de Stitch es la fuente de verdad visual. Solo adaptamos el layout.

## Reglas críticas
1. **Prohibido** crear archivos nuevos de estilos globales. Usa las clases de Tailwind que ya vienen en el HTML de Stitch.
2. **Prohibido** cambiar colores, tipografía o radios definidos en el HTML original.
3. Si un componente de Stitch no existe en Nuxt UI, usa HTML + Tailwind tal cual, no lo reemplaces.
4. Cada pantalla de Stitch se convierte en un componente Vue en `app/components/cafe/`.
5. No tocar `api/` ni el backend. Solo frontend.

## Estrategia de adaptación (móvil → web)
Stitch exporta clases Tailwind mobile-first. Para llevarlo a web:

| Elemento | Móvil (Stitch) | Web (adaptación) |
|----------|----------------|------------------|
| Contenedor principal | `w-full px-4` | `w-full max-w-7xl mx-auto px-4 lg:px-8` |
| Grid de tarjetas | `grid-cols-1` | `grid-cols-1 md:grid-cols-2 lg:grid-cols-3` |
| Barra de navegación | Menú hamburguesa | `hidden md:flex` para links, `md:hidden` para hamburguesa |
| Tipografía títulos | `text-2xl` | `text-2xl lg:text-4xl` |
| Botones | `w-full` | `w-full sm:w-auto` |
| Mapa / Bottom sheet | Ocupa pantalla completa | `lg:grid lg:grid-cols-3` (mapa 2/3, lista 1/3) |

**Regla de oro**: añade prefijos responsive (`md:`, `lg:`) a las clases existentes. No elimines las clases móviles.

## Flujo de trabajo con OpenCode
Para cada pantalla de `template/`:

1. OpenCode lee el archivo HTML de `template/`.
2. Extrae el `<body>` (sin `<head>`, sin `<script>` de Tailwind config).
3. Envuelve en un componente Vue: `app/components/cafe/{Nombre}.vue`.
4. Aplica los ajustes responsive de la tabla de arriba.
5. Reporta qué clases añadió y qué archivo creó. Máximo 5 líneas.

## Lo que NO debe hacer OpenCode
- NO instalar librerías de UI nuevas.
- NO crear un `tailwind.config.js` nuevo si ya existe uno en el proyecto.
- NO copiar el `<head>` ni el `<script>` de configuración de Tailwind del HTML de Stitch.
- NO refactorizar componentes existentes que ya funcionan.