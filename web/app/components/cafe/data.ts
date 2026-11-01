export interface FilterChip {
  label: string
  active: boolean
  icon?: string
}

export const sortFilters: FilterChip[] = [
  { label: 'Mejor precio', active: true, icon: 'star' },
  { label: 'Más cercano', active: false }
]

export const varietyFilters: FilterChip[] = [
  { label: 'Todas las variedades', active: true },
  { label: 'Castillo', active: false },
  { label: 'Caturra', active: false },
  { label: 'Bourbon Rosado', active: false },
  { label: 'Geisha', active: false }
]
