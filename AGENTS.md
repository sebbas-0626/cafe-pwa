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