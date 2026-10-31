import type {
  CoffeeBuyer,
  CoffeeBuyerOffer,
  CoffeeBuyerSource,
  CoffeeMapPoint,
  CoffeePoint,
  CoffeeVarietyFilter
} from '~/types/coffee'
import type { ApiError } from './useApi'
import { fetchCoffeeBuyers, matchesVariety } from '~/services/coffeeBuyerService'
import { distanceInKm } from './useGeolocation'
import { useCoffeeMap } from './useCoffeeMap'

export function useCoffeeBuyers() {
  const buyers = useState<CoffeeBuyer[]>('coffee-map:buyers', () => [])
  const source = useState<CoffeeBuyerSource | null>('coffee-map:source', () => null)
  const loading = useState<boolean>('coffee-map:loading', () => false)
  const error = useState<string | null>('coffee-map:error', () => null)
  const loaded = useState<boolean>('coffee-map:loaded', () => false)

  const { selectedVarieties, selectedBuyerId, radiusKm, center } = useCoffeeMap()

  const referencePoint = computed<CoffeePoint>(() => ({
    latitude: center.value[1],
    longitude: center.value[0]
  }))

  function representativeOffer(
    buyer: CoffeeBuyer,
    varieties: CoffeeVarietyFilter[]
  ): CoffeeBuyerOffer | null {
    const offers = varieties.length === 0
      ? buyer.offers
      : buyer.offers.filter(offer => varieties.some(variety => matchesVariety(offer.variety, variety)))

    return offers.reduce<CoffeeBuyerOffer | null>((best, offer) => (
      best === null || offer.pricePerKg > best.pricePerKg ? offer : best
    ), null)
  }

  function isWithinRadius(buyer: CoffeeBuyer): boolean {
    if (radiusKm.value >= 1000) {
      return true
    }

    return distanceInKm(referencePoint.value, buyer) <= radiusKm.value
  }

  const filteredPoints = computed<CoffeeMapPoint[]>(() => (
    buyers.value.flatMap((buyer) => {
      if (!buyer.isActive || !isWithinRadius(buyer)) {
        return []
      }

      const offer = representativeOffer(buyer, selectedVarieties.value)

      if (offer === null) {
        return []
      }

      return [{
        buyer,
        offer,
        pricePerKg: offer.pricePerKg,
        distanceKm: distanceInKm(referencePoint.value, buyer),
        isBest: false
      }]
    })
  ))

  const bestBuyerId = computed<number | null>(() => (
    filteredPoints.value.reduce<CoffeeMapPoint | null>((best, point) => (
      best === null || point.pricePerKg > best.pricePerKg ? point : best
    ), null)?.buyer.id ?? null
  ))

  const mapPoints = computed<CoffeeMapPoint[]>(() => (
    filteredPoints.value.map(point => ({
      ...point,
      isBest: point.buyer.id === bestBuyerId.value
    }))
  ))

  const selectedPoint = computed<CoffeeMapPoint | null>(() => (
    mapPoints.value.find(point => point.buyer.id === selectedBuyerId.value) ?? null
  ))

  async function loadBuyers(force = false): Promise<void> {
    if (loading.value || (loaded.value && !force)) {
      return
    }

    loading.value = true
    error.value = null

    try {
      const result = await fetchCoffeeBuyers()
      buyers.value = result.buyers
      source.value = result.source
      loaded.value = true
    } catch (caught) {
      error.value = (caught as ApiError).message ?? 'No pudimos cargar los compradores.'
      buyers.value = []
      loaded.value = false
    } finally {
      loading.value = false
    }
  }

  watch(mapPoints, (points) => {
    if (selectedBuyerId.value !== null && !points.some(point => point.buyer.id === selectedBuyerId.value)) {
      selectedBuyerId.value = null
    }
  })

  return {
    source,
    loading,
    error,
    loaded,
    mapPoints,
    selectedPoint,
    loadBuyers
  }
}
