# Backend Tasks - Cafe PWA

## Reglas de trabajo con IA
- Una tarea por sesión. No mezclar tareas.
- Cada tarea tiene un alcance cerrado: "solo esto, nada más".
- No tests, no factories, no seeders, no código de relleno.
- Si una tarea requiere más de ~30 líneas de código, dividirla.
- Antes de crear archivos nuevos, preguntar si son necesarios.

## Estado actual
- [x] Laravel instalado
- [x] Migraciones
- [ ] Modelos
- [ ] Repositorios
- [ ] API
- [ ] Filament

---

## FASE 0: Migraciones (antes que modelos)

### T0.1 - [x] Migración buyers
- Tabla: `buyers` (ER)
- Campos: name, type, description, latitude, longitude, address, phone, is_active, timestamps

### T0.2 - [x] Migración coffee_varieties
- Tabla: `coffee_varieties`
- Campos: name (unique), is_active, timestamps

### T0.3 - [x] Migración price_offers
- Tabla: `price_offers`
- FKs: buyer_id → buyers, coffee_variety_id → coffee_varieties
- Índices: (buyer_id, coffee_variety_id, status), (valid_until)

### T0.4 - [x] Migración favorite_buyers
- Tabla: `favorite_buyers`
- Unique: (user_id, buyer_id)

### T0.5 - [x] Migración audit_logs
- Tabla: `audit_logs`
- user_id nullable (audita acciones del sistema)

### T0.6 - [x] Migración coffee_farms
- Tabla: `coffee_farms`
- FK: user_id → users

### T0.7 - [x] Ampliar tabla users (alter users)
- Agregar columnas a la tabla `users` existente de Laravel:
- role (default 'farmer'), phone (nullable), is_verified (default false), buyer_id (nullable FK → buyers)

---

## FASE 1: Modelos (una tarea por modelo)

### T1.1 - Modelo Buyer
- Archivo: `app/Models/Buyer.php`
- Campos: fillable según ER (name, type, description, latitude, longitude, address, phone, is_active)
- Relaciones: hasMany PriceOffer, hasMany User (cooperative_admin)
- Casts: is_active => boolean, latitude/longitude => decimal:7
- NO migraciones, NO tests.

### T1.2 - Modelo CoffeeVariety
- Archivo: `app/Models/CoffeeVariety.php`
- Campos: fillable (name, is_active)
- Relaciones: hasMany PriceOffer
- Casts: is_active => boolean

### T1.3 - Modelo PriceOffer
- Archivo: `app/Models/PriceOffer.php`
- Campos: fillable (buyer_id, coffee_variety_id, price_per_kg, unit, valid_from, valid_until, status, notes)
- Relaciones: belongsTo Buyer, belongsTo CoffeeVariety
- Casts: valid_from/valid_until => datetime, price_per_kg => decimal:2
- Scope: scopeApprovedAndValid() → status=approved, valid_until > now()

### T1.4 - Modelo User (ajustar existente)
- Archivo: `app/Models/User.php`
- Añadir: role, phone, is_verified, buyer_id al fillable
- Relaciones: belongsTo Buyer (buyer_id, nullable)
- Casts: is_verified => boolean
- NO tocar autenticación existente.

### T1.5 - Modelo CoffeeFarm (opcional, según alcance)
- Archivo: `app/Models/CoffeeFarm.php`
- Relaciones: belongsTo User
- Puede marcarse fuera de alcance si no se usará aún.

### T1.6 - Modelo FavoriteBuyer (opcional)
- Archivo: `app/Models/FavoriteBuyer.php`
- Relaciones: belongsTo User, belongsTo Buyer

### T1.7 - Modelo AuditLog (opcional)
- Archivo: `app/Models/AuditLog.php`
- Relaciones: belongsTo User (nullable)

---

## FASE 2: Repositorios (una tarea por repositorio)

### T2.1 - Interface BuyerRepositoryInterface
- Archivo: `app/Repositories/Contracts/BuyerRepositoryInterface.php`
- Métodos: findActiveWithApprovedOffers(), findById(int), create(array), update(int, array)
- Solo la interface. Sin implementación.

### T2.2 - Implementación BuyerRepository
- Archivo: `app/Repositories/Eloquent/BuyerRepository.php`
- Implementa BuyerRepositoryInterface
- Usa Eloquent directamente, sin paquetes externos.

### T2.3 - Interface PriceOfferRepositoryInterface
- Archivo: `app/Repositories/Contracts/PriceOfferRepositoryInterface.php`
- Métodos: findApprovedByVariety(int $varietyId), findPending(), approve(int), reject(int), expireOld()
- Solo la interface.

### T2.4 - Implementación PriceOfferRepository
- Archivo: `app/Repositories/Eloquent/PriceOfferRepository.php`
- Implementa PriceOfferRepositoryInterface

### T2.5 - Interface CoffeeVarietyRepositoryInterface
- Archivo: `app/Repositories/Contracts/CoffeeVarietyRepositoryInterface.php`
- Métodos: findActive(), findById(int)
- Solo la interface.

### T2.6 - Implementación CoffeeVarietyRepository
- Archivo: `app/Repositories/Eloquent/CoffeeVarietyRepository.php`
- Implementa CoffeeVarietyRepositoryInterface

### T2.7 - RepositoryServiceProvider
- Archivo: `app/Providers/RepositoryServiceProvider.php`
- Binding de las interfaces a implementaciones
- Registrar en bootstrap/providers.php

---

## FASE 3: API (una tarea por endpoint)

### T3.1 - BuyerController@index
- GET /api/buyers
- Devuelve compradores activos con ofertas aprobadas vigentes
- Inyecta BuyerRepositoryInterface
- Sin validación compleja, sin paginación aún.

### T3.2 - PriceOfferController@byVariety
- GET /api/price-offers/variety/{id}
- Devuelve ofertas aprobadas vigentes de una variedad, ordenadas por precio
- Inyecta PriceOfferRepositoryInterface

### T3.3 - Rutas API
- Archivo: `routes/api.php`
- Registrar los dos endpoints anteriores
- Sin middleware extra por ahora.

### T3.4 - Config auth API (si aplica)
- Definir middleware de autenticación (sanctum u otro) si la API lo requiere.
- Si no se usa auth, omitir esta tarea.

---

## FASE 4: Filament (después de validar API)

### T4.1 - Instalar Filament (autorización requerida)
- Comando: composer require filament/filament
- Solo instalar. NO crear panel todavía.

### T4.2 - Crear panel admin
- Comando: php artisan filament:install --panel
- Configurar provider y ruta base.
- NO crear Resources todavía.

### T4.3 - Resource Buyer
### T4.4 - Resource PriceOffer
### T4.5 - Resource CoffeeVariety (usa T2.5/T2.6)
### T4.6 - Dashboard widgets