import type { CoffeeBuyerApi, CoffeeBuyerApiOffer } from '~/types/coffee'

const VARIETY_IDS: Record<string, number> = {
  Castillo: 2,
  Caturra: 3,
  'Borbón Rosado': 4,
  Geisha: 5
}

function createOffer(
  id: number,
  variety: string,
  price: number,
  updatedAt: string,
  validUntil: string
): CoffeeBuyerApiOffer {
  return {
    id,
    price_per_kg: price,
    unit: 'kg',
    valid_until: validUntil,
    status: 'approved',
    updated_at: updatedAt,
    coffee_variety: { id: VARIETY_IDS[variety] ?? 0, name: variety }
  }
}

export function createMockCoffeeBuyers(): CoffeeBuyerApi[] {
  const now = Date.now()
  const updatedAt = new Date(now - 42 * 60 * 1000).toISOString()
  const earlier = new Date(now - 3 * 60 * 60 * 1000).toISOString()
  const validUntil = new Date(now + 45 * 24 * 60 * 60 * 1000).toISOString()

  const offer = (id: number, variety: string, price: number, date = updatedAt) =>
    createOffer(id, variety, price, date, validUntil)

  return [
    {
      id: 1001,
      name: 'Cooperativa Caficultores del Huila',
      type: 'cooperative',
      description: 'Punto de compra de demostración en Pitalito.',
      latitude: 1.8601,
      longitude: -76.0572,
      address: 'Vereda El Recreo, Pitalito',
      phone: '+57 310 000 0001',
      is_active: true,
      price_offers: [
        offer(1, 'Castillo', 15200),
        offer(2, 'Caturra', 15050, earlier),
        offer(3, 'Borbón Rosado', 15100, earlier),
        offer(4, 'Geisha', 15200, earlier)
      ]
    },
    {
      id: 1002,
      name: 'Asociación Agropecuaria El Recreo',
      type: 'association',
      description: 'Asociación de productores de demostración.',
      latitude: 1.9250,
      longitude: -76.1150,
      address: 'Vereda El Recreo, Pitalito',
      phone: '+57 310 000 0002',
      is_active: true,
      price_offers: [
        offer(5, 'Castillo', 14800),
        offer(6, 'Caturra', 14600, earlier)
      ]
    },
    {
      id: 1003,
      name: 'Cooperativa Cafetera del Sur',
      type: 'cooperative',
      description: 'Cooperativa de demostración.',
      latitude: 1.9380,
      longitude: -76.0050,
      address: 'Vereda Charguayaco, Pitalito',
      phone: '+57 310 000 0003',
      is_active: true,
      price_offers: [
        offer(7, 'Castillo', 15050),
        offer(8, 'Caturra', 14900, earlier)
      ]
    },
    {
      id: 1004,
      name: 'Asociación de Productores La Esperanza',
      type: 'association',
      description: 'Asociación de demostración.',
      latitude: 1.7900,
      longitude: -76.1300,
      address: 'Vereda Guacacallo, Pitalito',
      phone: '+57 310 000 0004',
      is_active: true,
      price_offers: [
        offer(9, 'Castillo', 14450),
        offer(10, 'Borbón Rosado', 14520, earlier)
      ]
    },
    {
      id: 1005,
      name: 'Comprador Particular - Finca El Mirador',
      type: 'private_buyer',
      description: 'Comprador particular de demostración.',
      latitude: 1.7950,
      longitude: -75.9700,
      address: 'Vereda Cálamo, Pitalito',
      phone: '+57 310 000 0005',
      is_active: true,
      price_offers: [
        offer(11, 'Caturra', 14200),
        offer(12, 'Castillo', 14350, earlier)
      ]
    },
    {
      id: 1006,
      name: 'Intermediario Don José',
      type: 'intermediary',
      description: 'Intermediario de demostración.',
      latitude: 1.9900,
      longitude: -76.0700,
      address: 'Vereda El Higuerón, Pitalito',
      phone: '+57 310 000 0006',
      is_active: true,
      price_offers: [
        offer(13, 'Castillo', 14100),
        offer(14, 'Caturra', 14050, earlier)
      ]
    },
    {
      id: 1007,
      name: 'Cooperativa de Caficultores de Pitalito',
      type: 'cooperative',
      description: 'Cooperativa de demostración.',
      latitude: 1.7350,
      longitude: -76.0050,
      address: 'Vereda La Palma, Pitalito',
      phone: '+57 310 000 0007',
      is_active: true,
      price_offers: [
        offer(15, 'Castillo', 14950),
        offer(16, 'Geisha', 15080, earlier)
      ]
    },
    {
      id: 1008,
      name: 'Comprador Particular - Bodega Central',
      type: 'private_buyer',
      description: 'Bodega de compra de demostración.',
      latitude: 1.8850,
      longitude: -76.2050,
      address: 'Centro, Pitalito',
      phone: '+57 310 000 0008',
      is_active: true,
      price_offers: [
        offer(17, 'Castillo', 14350),
        offer(18, 'Caturra', 14320, earlier)
      ]
    },
    {
      id: 1009,
      name: 'Asociación Caficultora Guacacallo',
      type: 'association',
      description: 'Asociación de demostración.',
      latitude: 1.8850,
      longitude: -75.8950,
      address: 'Vereda Guacacallo, Pitalito',
      phone: '+57 310 000 0009',
      is_active: true,
      price_offers: [
        offer(19, 'Castillo', 14750),
        offer(20, 'Borbón Rosado', 14780, earlier)
      ]
    },
    {
      id: 1010,
      name: 'Finca La Primavera',
      type: 'farm',
      description: 'Finca cafetera de demostración.',
      latitude: 2.0400,
      longitude: -76.1000,
      address: 'Vereda El Recreo, Pitalito',
      phone: '+57 310 000 0010',
      is_active: true,
      price_offers: [
        offer(21, 'Castillo', 13950),
        offer(22, 'Caturra', 14100, earlier)
      ]
    },
    {
      id: 1011,
      name: 'Exportadora Andina - Punto Pitalito',
      type: 'exporter',
      description: 'Punto de acopio de demostración.',
      latitude: 1.6800,
      longitude: -76.0000,
      address: 'Vía Pitalito - Timaná',
      phone: '+57 310 000 0011',
      is_active: true,
      price_offers: [
        offer(23, 'Castillo', 14850),
        offer(24, 'Geisha', 15080, earlier)
      ]
    },
    {
      id: 1012,
      name: 'Asociación de Cafés Especiales Charguayaco',
      type: 'association',
      description: 'Asociación de cafés especiales de demostración.',
      latitude: 1.9600,
      longitude: -76.2200,
      address: 'Vereda Charguayaco, Pitalito',
      phone: '+57 310 000 0012',
      is_active: true,
      price_offers: [
        offer(25, 'Geisha', 15080),
        offer(26, 'Borbón Rosado', 14980, earlier)
      ]
    },
    {
      id: 1013,
      name: 'Comprador Particular - Vereda El Higuerón',
      type: 'private_buyer',
      description: 'Comprador particular de demostración.',
      latitude: 1.7600,
      longitude: -76.2200,
      address: 'Vereda El Higuerón, Pitalito',
      phone: '+57 310 000 0013',
      is_active: true,
      price_offers: [
        offer(27, 'Castillo', 14550),
        offer(28, 'Caturra', 14480, earlier)
      ]
    },
    {
      id: 1014,
      name: 'Intermediario La Palma',
      type: 'intermediary',
      description: 'Intermediario de demostración.',
      latitude: 1.9200,
      longitude: -75.8600,
      address: 'Vereda La Palma, Pitalito',
      phone: '+57 310 000 0014',
      is_active: true,
      price_offers: [
        offer(29, 'Castillo', 14080),
        offer(30, 'Geisha', 15020, earlier)
      ]
    }
  ]
}
