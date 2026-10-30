export type BuyerType = 'cooperative' | 'private_buyer' | 'exporter'

export type PriceUnit = 'kg' | 'arroba' | 'carga'

export type PriceOfferStatus = 'pending' | 'approved' | 'rejected' | 'expired'

export interface CoffeeVariety {
  id: number
  name: string
  is_active: boolean
  created_at: string
  updated_at: string
}

export interface Buyer {
  id: number
  name: string
  type: BuyerType
  description: string | null
  latitude: string
  longitude: string
  address: string | null
  phone: string | null
  is_active: boolean
  created_at: string
  updated_at: string
  price_offers?: PriceOffer[]
}

export interface PriceOffer {
  id: number
  buyer_id: number
  coffee_variety_id: number
  price_per_kg: string
  unit: PriceUnit
  valid_from: string
  valid_until: string
  status: PriceOfferStatus
  notes: string | null
  created_at: string
  updated_at: string
  buyer?: Buyer
  coffee_variety?: CoffeeVariety
}

export interface OfferCardProps {
  buyerId: number
  buyerName: string
  price: string
  unit: PriceUnit
  variety: string
  updatedAt: string
}

export interface PerfilScreenProps {
  cooperativeId: string
}
