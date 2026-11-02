import type { CoffeePoint, CoffeeUserLocation } from '~/types/coffee'

const EARTH_RADIUS_KM = 6371

async function reverseGeocode(latitude: number, longitude: number): Promise<string | null> {
  try {
    const response = await fetch(
      `https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`,
      { headers: { 'Accept-Language': 'es' } }
    )
    const data = await response.json() as { address?: { city?: string; town?: string; village?: string; county?: string; state?: string } }
    const address = data.address
    if (!address) return null
    const city = address.city ?? address.town ?? address.village ?? address.county
    const state = address.state
    if (city && state) return `${city}/${state}`
    return city ?? state ?? null
  } catch {
    return null
  }
}

export function useGeolocation() {
  const position = useState<CoffeeUserLocation | null>('coffee-geo:position', () => null)
  const loading = useState<boolean>('coffee-geo:loading', () => false)
  const error = useState<string | null>('coffee-geo:error', () => null)
  const locationName = useState<string | null>('coffee-geo:location-name', () => null)

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
          void reverseGeocode(location.latitude, location.longitude).then((name) => {
            locationName.value = name
          })
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

  return { position, loading, error, locationName, requestLocation }
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
