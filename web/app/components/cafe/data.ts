import type { OfferCardProps } from '~/types'

export interface VarietyPrice {
  name: string
  badge: string
  description: string
  price: string
  arroba: string
  highlight: boolean
}

export interface FilterChip {
  label: string
  active: boolean
  icon?: string
}

export const sampleOffers: OfferCardProps[] = [
  { buyerName: 'Cadefihuila', price: '$ 15.200', variety: 'Castillo', updatedAt: 'Hoy 7:30 AM' },
  { buyerName: 'Café Andino & Exportadores', price: '$ 14.950', variety: 'Caturra', updatedAt: 'Hoy 6:50 AM' },
  { buyerName: 'Cooperativa Coocentral', price: '$ 14.800', variety: 'Bourbon Rosado', updatedAt: 'Hoy 6:15 AM' },
  { buyerName: 'Expocafé Huila', price: '$ 14.550', variety: 'Geisha', updatedAt: 'Ayer 5:00 PM' }
]

export const sortFilters: FilterChip[] = [
  { label: 'Mejor precio', active: true, icon: 'star' },
  { label: 'Más cercano', active: false },
  { label: 'Mejor factor', active: false }
]

export const varietyFilters: FilterChip[] = [
  { label: 'Todas las variedades', active: true },
  { label: 'Castillo', active: false },
  { label: 'Caturra', active: false },
  { label: 'Bourbon Rosado', active: false },
  { label: 'Geisha', active: false }
]

export const sampleVarietyPrices: VarietyPrice[] = [
  { name: 'Castillo', badge: 'Base 88', description: 'Pergamino Seco estándar de recibo', price: '$ 15.200', arroba: '$190.000 / @', highlight: false },
  { name: 'Caturra / Colombia', badge: 'Tradicional', description: 'Lotes seleccionados secados al sol', price: '$ 15.150', arroba: '$189.375 / @', highlight: false },
  { name: 'Bourbon Rosado / Especiales', badge: '+ Calidad', description: 'Taza limpia calificada >84 puntos SCA', price: '$ 17.500', arroba: '$218.750 / @', highlight: true },
  { name: 'Pasilla / Bajos Factores', badge: 'Despasillado', description: 'Compra directa sin penalidad extra', price: '$ 6.800', arroba: '$85.000 / @', highlight: false }
]
