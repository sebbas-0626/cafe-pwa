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

export interface LabSample {
  id: string
  label: string
  value: number
  step: number
  unit: string
  hint: string
  emphasize: boolean
}

export const labSamples: LabSample[] = [
  { id: 'muestra', label: 'Muestra Pergamino Seco (g)', value: 250, step: 10, unit: 'gramos', hint: 'Estándar FNC', emphasize: false },
  { id: 'almendra', label: 'Almendra Total Trillada (g)', value: 198, step: 1, unit: 'gramos almendra', hint: 'Sano + Pasilla', emphasize: true },
  { id: 'pasilla', label: 'Pasilla y Granos Defectuosos (g)', value: 12, step: 1, unit: 'gramos defecto', hint: 'Broca, negros, vinagres', emphasize: false }
]

export interface LiquidationRow {
  label: string
  value: string
  icon: string
  tone: 'neutral' | 'positive' | 'negative'
}

export const liquidationRows: LiquidationRow[] = [
  { label: 'Valor base comercial (500 kg)', value: '$7.540.000 COP', icon: '', tone: 'neutral' },
  { label: 'Premio factor rendimiento (86.4)', value: '+$170.000 COP', icon: 'add_circle', tone: 'positive' },
  { label: 'Incentivo Origen Huila / Tasa limpia', value: '+$60.000 COP', icon: 'add_circle', tone: 'positive' },
  { label: 'Ajuste de humedad (11.2% en norma)', value: '$0 COP', icon: 'check_circle', tone: 'neutral' },
  { label: 'Contribución Cafetera Obligatoria FNC', value: '-$45.240 COP', icon: 'remove_circle_outline', tone: 'negative' }
]

export const factorResult = {
  factor: '86.4',
  factorHint: '86.4 kg',
  almendraSana: '186.0 g',
  almendraPct: '74.4% del total',
  merma: '4.8%',
  mermaHint: 'En norma (< 6%)'
}

export const liquidationTotals = {
  total: '$7.724.760 COP',
  perArroba: '$193.119',
  perKilo: '$15.450'
}
