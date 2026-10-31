import type {
  CoffeeBuyer,
  CoffeeBuyerApi,
  CoffeeBuyerApiOffer,
  CoffeeBuyerOffer,
  CoffeeBuyerSource,
  CoffeeBuyerType,
  CoffeeBuyersResult,
  CoffeeVarietyFilter
} from '~/types/coffee'
import { BUYER_TYPE_META } from '~/types/coffee'
import { toApiError, useApi } from '~/composables/useApi'
import { createMockCoffeeBuyers } from './coffeeBuyerMock'

const priceFormatter = new Intl.NumberFormat('es-CO', {
  maximumFractionDigits: 0
})

const distanceFormatter = new Intl.NumberFormat('es-CO', {
  maximumFractionDigits: 1
})

const timeFormatter = new Intl.DateTimeFormat('es-CO', {
  hour: '2-digit',
  minute: '2-digit',
  hour12: true
})

const dateFormatter = new Intl.DateTimeFormat('es-CO', {
  day: '2-digit',
  month: 'short',
  hour: '2-digit',
  minute: '2-digit',
  hour12: true
})

function normalizeText(value: string): string {
  return value
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .toLowerCase()
    .trim()
}

function normalizeType(value: string): CoffeeBuyerType {
  const keys = Object.keys(BUYER_TYPE_META) as CoffeeBuyerType[]

  return keys.includes(value as CoffeeBuyerType) ? value as CoffeeBuyerType : 'private_buyer'
}

function normalizeOffer(offer: CoffeeBuyerApiOffer): CoffeeBuyerOffer | null {
  const price = Number(offer.price_per_kg)
  const validUntil = new Date(offer.valid_until)
  const isValid = offer.status === undefined || offer.status === 'approved'
  const isExpired = Number.isNaN(validUntil.getTime()) || validUntil.getTime() <= Date.now()

  if (!Number.isFinite(price) || price <= 0 || !isValid || isExpired) {
    return null
  }

  return {
    id: offer.id,
    variety: offer.coffee_variety?.name ?? 'Sin variedad',
    pricePerKg: price,
    unit: offer.unit ?? 'kg',
    validUntil: offer.valid_until,
    updatedAt: offer.updated_at ?? offer.valid_from ?? offer.valid_until
  }
}

function normalizeBuyer(buyer: CoffeeBuyerApi, isMock: boolean): CoffeeBuyer | null {
  const latitude = Number(buyer.latitude)
  const longitude = Number(buyer.longitude)

  if (buyer.is_active === false || !Number.isFinite(latitude) || !Number.isFinite(longitude)) {
    return null
  }

  const offers = (buyer.price_offers ?? [])
    .map(normalizeOffer)
    .filter((offer): offer is CoffeeBuyerOffer => offer !== null)
    .sort((left, right) => right.pricePerKg - left.pricePerKg)

  if (offers.length === 0) {
    return null
  }

  const varieties = [...new Set(offers.map(offer => offer.variety))]

  return {
    id: buyer.id,
    name: buyer.name,
    type: normalizeType(buyer.type),
    description: buyer.description ?? null,
    latitude,
    longitude,
    address: buyer.address ?? null,
    phone: buyer.phone ?? null,
    isActive: true,
    isMock,
    offers,
    varieties,
    pricePerKg: offers[0]!.pricePerKg
  }
}

function normalizeBuyers(payload: CoffeeBuyerApi[], isMock: boolean): CoffeeBuyer[] {
  return payload
    .map(buyer => normalizeBuyer(buyer, isMock))
    .filter((buyer): buyer is CoffeeBuyer => buyer !== null)
}

export function matchesVariety(variety: string, filter: CoffeeVarietyFilter): boolean {
  if (filter === 'Todas') {
    return true
  }

  const normalizedVariety = normalizeText(variety)
  const normalizedFilter = normalizeText(filter)

  if (normalizedFilter === 'borbon rosado') {
    return normalizedVariety.includes('borbon') || normalizedVariety.includes('bourbon')
  }

  return normalizedVariety === normalizedFilter || normalizedVariety.includes(normalizedFilter)
}

export function formatPricePerKg(value: number): string {
  return `$${priceFormatter.format(value)}`
}

export function formatDistance(distanceKm: number | null): string {
  if (distanceKm === null) {
    return 'Distancia no disponible'
  }

  if (distanceKm < 1) {
    return `${Math.round(distanceKm * 1000)} m`
  }

  return `${distanceFormatter.format(distanceKm)} km`
}

export function formatPriceUpdatedAt(value: string): string {
  const date = new Date(value)

  if (Number.isNaN(date.getTime())) {
    return 'Sin actualización'
  }

  const today = new Date()
  const yesterday = new Date()
  yesterday.setDate(today.getDate() - 1)

  if (date.toDateString() === today.toDateString()) {
    return `Hoy, ${timeFormatter.format(date)}`
  }

  if (date.toDateString() === yesterday.toDateString()) {
    return `Ayer, ${timeFormatter.format(date)}`
  }

  return dateFormatter.format(date)
}

export async function fetchCoffeeBuyers(): Promise<CoffeeBuyersResult> {
  const config = useRuntimeConfig()

  if (import.meta.dev && config.public.useMockCoffeeData) {
    return {
      buyers: normalizeBuyers(createMockCoffeeBuyers(), true),
      source: 'mock' satisfies CoffeeBuyerSource
    }
  }

  try {
    const { data } = await useApi().get<CoffeeBuyerApi[] | { data: CoffeeBuyerApi[] }>('/buyers')
    const payload = Array.isArray(data) ? data : data.data ?? []

    return {
      buyers: normalizeBuyers(payload, false),
      source: 'api'
    }
  } catch (caught) {
    throw toApiError(caught)
  }
}
