import type { PriceOffer } from '~/types'
import type { CoffeeState } from '~/types/coffee'
import { DEFAULT_COFFEE_STATE } from '~/types/coffee'
import { type ApiError, toApiError } from './useApi'

export function usePriceOffers() {
  const api = useApi()
  const offers = ref<PriceOffer[]>([])
  const loading = ref(false)
  const error = ref<ApiError | null>(null)

  async function fetchByVariety(
    varietyId: number,
    coffeeState: CoffeeState = DEFAULT_COFFEE_STATE
  ): Promise<PriceOffer[]> {
    loading.value = true
    error.value = null

    try {
      const { data } = await api.get<PriceOffer[]>(`/price-offers/variety/${varietyId}`, {
        params: { coffee_state: coffeeState }
      })
      offers.value = data

      return data
    } catch (caught) {
      error.value = toApiError(caught)

      return []
    } finally {
      loading.value = false
    }
  }

  return { offers, loading, error, fetchByVariety }
}
