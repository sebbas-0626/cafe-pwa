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
## Estructura por dominio
- El código vive en `app/Domains/{DomainName}/` (Buyer, PriceOffer, CoffeeVariety).
- Cada dominio tiene: Models/, Repositories/Contracts/, Repositories/Eloquent/, Http/Controllers/.
- Namespace base: `App\Domains\{DomainName}\...`
- NO crear archivos en `app/Models/` ni `app/Repositories/` globales.
- El RepositoryServiceProvider global en `app/Providers/` sigue siendo el punto de binding.


## Git workflow (monorepo)
- master: producción. Solo recibe merges desde develop (o hotfix). Nunca commit directo.
- develop: rama de integración. Aquí se fusionan las features terminadas.
- feature/<nombre-corto>: se crea SIEMPRE desde develop. Una feature por rama.
  - Prefijo según área: feature/backend-<nombre> o feature/frontend-<nombre>
  - Ejemplos: feature/backend-buyer-repository, feature/frontend-mapa-screen
  - kebab-case, sin mayúsculas, sin espacios.
  - Al terminar: merge a develop y eliminar la rama.
- Prohibido commitear directamente a main o develop.
- Antes de empezar una tarea, indicar en qué rama estás trabajando.
- No crear ramas release/hotfix todavía (etapa temprana del proyecto).

## Git rules específicas para frontend (web/)
- Trabajar siempre en `feature/frontend-*` creada desde develop.
- NO commitear archivos generados: `web/.nuxt/`, `web/.output/`, `web/node_modules/`.
- Verificar que `web/.gitignore` incluya: .nuxt, .output, node_modules, .env.
- NO commitear cambios en `template/` (es fuente de verdad, solo lectura).
- Si una tarea toca tanto `api/` como `web/`, dividir en dos ramas separadas.
- Mensaje de commit: `feat(web): <descripción corta>` o `fix(web): <descripción corta>`.