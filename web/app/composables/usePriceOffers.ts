import type { PriceOffer } from '~/types'
import { type ApiError, toApiError } from './useApi'

export function usePriceOffers() {
  const api = useApi()
  const offers = ref<PriceOffer[]>([])
  const loading = ref(false)
  const error = ref<ApiError | null>(null)

  async function fetchByVariety(varietyId: number): Promise<PriceOffer[]> {
    loading.value = true
    error.value = null

    try {
      const { data } = await api.get<PriceOffer[]>(`/price-offers/variety/${varietyId}`)
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
