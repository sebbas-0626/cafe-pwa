export type CoffeeBuyerType =
  | 'cooperative'
  | 'association'
  | 'private_buyer'
  | 'intermediary'
  | 'farm'
  | 'exporter'

export type CoffeeVarietyFilter =
  | 'Todas'
  | 'Castillo'
  | 'Caturra'
  | 'Borbón Rosado'
  | 'Geisha'

export type CoffeeMapViewMode = 'map' | 'list'

export type CoffeeBuyerSource = 'api' | 'mock'

export const COFFEE_VARIETY_FILTERS: CoffeeVarietyFilter[] = [
  'Todas',
  'Castillo',
  'Caturra',
  'Borbón Rosado',
  'Geisha'
]

export const PITALITO_CENTER: [number, number] = [-76.0508, 1.8537]

export const DEFAULT_RADIUS_KM = 25

export const BUYER_TYPE_META: Record<CoffeeBuyerType, { label: string; icon: string }> = {
  cooperative: { label: 'Cooperativa', icon: 'handshake' },
  association: { label: 'Asociación', icon: 'groups' },
  private_buyer: { label: 'Comprador particular', icon: 'storefront' },
  intermediary: { label: 'Intermediario', icon: 'swap_horiz' },
  farm: { label: 'Finca cafetera', icon: 'home_work' },
  exporter: { label: 'Exportadora', icon: 'local_shipping' }
}

export interface CoffeePoint {
  latitude: number
  longitude: number
}

export interface CoffeeUserLocation extends CoffeePoint {
  accuracy: number
}

export interface CoffeeBuyerApiVariety {
  id: number
  name: string
}

export interface CoffeeBuyerApiOffer {
  id: number
  price_per_kg: string | number
  unit?: string
  valid_from?: string
  valid_until: string
  status?: string
  updated_at?: string
  coffee_variety?: CoffeeBuyerApiVariety | null
}

export interface CoffeeBuyerApi {
  id: number
  name: string
  type: string
  description?: string | null
  latitude: string | number
  longitude: string | number
  address?: string | null
  phone?: string | null
  is_active?: boolean
  price_updated_at?: string
  price_offers?: CoffeeBuyerApiOffer[]
}

export interface CoffeeBuyerOffer {
  id: number
  variety: string
  pricePerKg: number
  unit: string
  validUntil: string
  updatedAt: string
}

export interface CoffeeBuyer {
  id: number
  name: string
  type: CoffeeBuyerType
  description: string | null
  latitude: number
  longitude: number
  address: string | null
  phone: string | null
  isActive: boolean
  isMock: boolean
  offers: CoffeeBuyerOffer[]
  varieties: string[]
  pricePerKg: number
}

export interface CoffeeMapPoint {
  buyer: CoffeeBuyer
  offer: CoffeeBuyerOffer
  pricePerKg: number
  distanceKm: number | null
  isBest: boolean
}

export interface CoffeeBuyersResult {
  buyers: CoffeeBuyer[]
  source: CoffeeBuyerSource
}
