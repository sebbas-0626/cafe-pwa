# Cafe PWA - Reglas del proyecto

## Contexto

Monorepo: `api/` = Laravel 11 (backend), `web/` = Nuxt 3 (frontend, aún no existe).
Backend expone API REST JSON. Admin usa Filament (se instalará después).

## Reglas críticas

- NO escribir tests. No se requieren en esta fase.
- NO instalar paquetes sin preguntar primero.
- NO crear archivos que no se te pidan explícitamente.
- NO refactorizar código existente a menos que se solicite.
- Responder en español, código en inglés (nombres de clases, métodos, variables).

## Patrón Repository

- Interfaces en `app/Repositories/Contracts/`
- Implementaciones en `app/Repositories/Eloquent/`
- Binding en `app/Providers/RepositoryServiceProvider.php`
- Controladores inyectan interfaces, NUNCA instancian Eloquent directamente.

## Convenciones

- PHP 8.2+, tipado estricto en métodos públicos.
- Nombres de tablas: snake_case plural (buyers, price_offers).
- Nombres de modelos: PascalCase singular (Buyer, PriceOffer).

## Prohibiciones estrictas

- NO crear tests, factories, seeders ni archivos de ejemplo. No se piden.
- NO crear archivos que no se mencionen explícitamente en la tarea.
- NO añadir comentarios explicativos en el código (el código debe ser autoexplicativo).
- NO crear métodos "por si acaso" o placeholders. Solo lo que se pide.
- Si una tarea requiere más de 2 archivos nuevos, DETENTE y pregunta.
- NO instalar paquetes sin autorización explícita.

## Git workflow

- master: producción. Solo recibe merges desde develop (o hotfix). Nunca commit directo.
- develop: rama de integración. Aquí se fusionan las features terminadas.
- feature/<nombre-corto>: se crea SIEMPRE desde develop. Una feature por rama.
  - Nombre en kebab-case: feature/buyer-repository, feature/price-offer-api
  - Al terminar: merge a develop y eliminar la rama.
- Prohibido commitear directamente a main o develop.
- Antes de empezar una tarea, indicar en qué rama estás trabajando.
- No crear ramas release/hotfix todavía (etapa temprana del proyecto).
