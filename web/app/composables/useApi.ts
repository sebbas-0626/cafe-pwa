import axios, { AxiosError, type AxiosInstance } from 'axios'

export interface ApiError {
  message: string
  status: number | null
}

export function useApi(): AxiosInstance {
  const config = useRuntimeConfig()

  return axios.create({
    baseURL: config.public.apiBase,
    headers: {
      Accept: 'application/json'
    }
  })
}

export function toApiError(error: unknown): ApiError {
  if (error instanceof AxiosError) {
    const data = error.response?.data as { message?: string } | undefined

    return {
      message: data?.message ?? error.message,
      status: error.response?.status ?? null
    }
  }

  return {
    message: 'Error inesperado al consultar la API',
    status: null
  }
}
