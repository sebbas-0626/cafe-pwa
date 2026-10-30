import type { Buyer } from '~/types'
import { type ApiError, toApiError } from './useApi'

export function useBuyers() {
  const api = useApi()
  const buyers = ref<Buyer[]>([])
  const buyer = ref<Buyer | null>(null)
  const loading = ref(false)
  const error = ref<ApiError | null>(null)

  async function fetchBuyers(): Promise<Buyer[]> {
    loading.value = true
    error.value = null

    try {
      const { data } = await api.get<Buyer[]>('/buyers')
      buyers.value = data

      return data
    } catch (caught) {
      error.value = toApiError(caught)

      return []
    } finally {
      loading.value = false
    }
  }

  async function fetchBuyerById(id: number): Promise<Buyer | null> {
    loading.value = true
    error.value = null

    try {
      const { data } = await api.get<Buyer[]>('/buyers')
      const found = data.find(item => item.id === id) ?? null

      if (found === null) {
        error.value = { message: 'Cooperativa no encontrada', status: 404 }
      }

      buyer.value = found

      return found
    } catch (caught) {
      error.value = toApiError(caught)

      return null
    } finally {
      loading.value = false
    }
  }

  return { buyers, buyer, loading, error, fetchBuyers, fetchBuyerById }
}
