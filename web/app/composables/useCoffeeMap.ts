import type {
  CoffeeMapViewMode,
  CoffeeUserLocation,
  CoffeeVarietyFilter
} from '~/types/coffee'
import { DEFAULT_RADIUS_KM, PITALITO_CENTER } from '~/types/coffee'
import { useGeolocation } from './useGeolocation'

let toastTimer: ReturnType<typeof setTimeout> | null = null

export function useCoffeeMap() {
  const selectedVarieties = useState<CoffeeVarietyFilter[]>('coffee-map:varieties', () => [])
  const selectedBuyerId = useState<number | null>('coffee-map:selected-buyer', () => null)
  const viewMode = useState<CoffeeMapViewMode>('coffee-map:view-mode', () => 'map')
  const radiusKm = useState<number>('coffee-map:radius', () => DEFAULT_RADIUS_KM)
  const showLabels = useState<boolean>('coffee-map:labels', () => true)
  const showWater = useState<boolean>('coffee-map:water', () => true)
  const toast = useState<string | null>('coffee-map:toast', () => null)

  const {
    position: userLocation,
    loading: locating,
    error: locationError,
    requestLocation
  } = useGeolocation()

  const center = computed<[number, number]>(() => (
    userLocation.value
      ? [userLocation.value.longitude, userLocation.value.latitude]
      : PITALITO_CENTER
  ))

  const locationLabel = computed(() => (
    userLocation.value ? 'Mi ubicación' : 'Pitalito, Huila'
  ))

  function showToast(message: string): void {
    toast.value = message

    if (toastTimer) {
      clearTimeout(toastTimer)
    }

    toastTimer = setTimeout(() => {
      toast.value = null
      toastTimer = null
    }, 2800)
  }

  function toggleVariety(variety: CoffeeVarietyFilter): void {
    if (variety === 'Todas') {
      selectedVarieties.value = []
      return
    }

    selectedVarieties.value = selectedVarieties.value.includes(variety)
      ? selectedVarieties.value.filter(item => item !== variety)
      : [...selectedVarieties.value, variety]
  }

  function resetVarieties(): void {
    selectedVarieties.value = []
  }

  function selectBuyer(id: number | null): void {
    selectedBuyerId.value = id
  }

  function clearSelection(): void {
    selectedBuyerId.value = null
  }

  function setRadius(value: number): void {
    radiusKm.value = value
  }

  function toggleLabels(): void {
    showLabels.value = !showLabels.value
  }

  function toggleWater(): void {
    showWater.value = !showWater.value
  }

  function toggleViewMode(): void {
    viewMode.value = viewMode.value === 'map' ? 'list' : 'map'
  }

  async function locate(): Promise<boolean> {
    const result: CoffeeUserLocation | null = await requestLocation()

    if (!result) {
      showToast(locationError.value ?? 'No pudimos obtener tu ubicación.')
      return false
    }

    selectedBuyerId.value = null
    showToast('Ubicación actualizada. Buscando compradores cercanos.')
    return true
  }

  return {
    selectedVarieties,
    selectedBuyerId,
    viewMode,
    radiusKm,
    showLabels,
    showWater,
    toast,
    userLocation,
    locating,
    center,
    locationLabel,
    toggleVariety,
    resetVarieties,
    selectBuyer,
    clearSelection,
    setRadius,
    toggleLabels,
    toggleWater,
    toggleViewMode,
    locate
  }
}
