import type { CoffeePoint, CoffeeUserLocation } from '~/types/coffee'

const EARTH_RADIUS_KM = 6371

export function useGeolocation() {
  const position = useState<CoffeeUserLocation | null>('coffee-geo:position', () => null)
  const loading = useState<boolean>('coffee-geo:loading', () => false)
  const error = useState<string | null>('coffee-geo:error', () => null)

  function requestLocation(): Promise<CoffeeUserLocation | null> {
    if (!import.meta.client) {
      return Promise.resolve(null)
    }

    if (!('geolocation' in navigator)) {
      error.value = 'Tu navegador no permite obtener la ubicación.'

      return Promise.resolve(null)
    }

    loading.value = true
    error.value = null

    return new Promise((resolve) => {
      navigator.geolocation.getCurrentPosition(
        (result) => {
          const location: CoffeeUserLocation = {
            latitude: result.coords.latitude,
            longitude: result.coords.longitude,
            accuracy: result.coords.accuracy
          }

          position.value = location
          loading.value = false
          resolve(location)
        },
        (caught) => {
          error.value = caught.code === caught.PERMISSION_DENIED
            ? 'No diste permiso para usar tu ubicación.'
            : caught.code === caught.TIMEOUT
              ? 'La ubicación tardó demasiado. Intenta de nuevo.'
              : 'Tu ubicación no está disponible en este momento.'
          loading.value = false
          resolve(null)
        },
        {
          enableHighAccuracy: true,
          timeout: 12000,
          maximumAge: 60000
        }
      )
    })
  }

  return { position, loading, error, requestLocation }
}

export function distanceInKm(from: CoffeePoint, to: CoffeePoint): number {
  const latitudeDelta = (to.latitude - from.latitude) * Math.PI / 180
  const longitudeDelta = (to.longitude - from.longitude) * Math.PI / 180
  const fromLatitude = from.latitude * Math.PI / 180
  const toLatitude = to.latitude * Math.PI / 180

  const haversine = Math.sin(latitudeDelta / 2) ** 2
    + Math.cos(fromLatitude) * Math.cos(toLatitude) * Math.sin(longitudeDelta / 2) ** 2

  return 2 * EARTH_RADIUS_KM * Math.asin(Math.sqrt(haversine))
}
