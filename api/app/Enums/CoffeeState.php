<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum CoffeeState: string implements HasLabel
{
    case Cereza = 'cereza';
    case PergaminoHumedo = 'pergamino_humedo';
    case PergaminoSeco = 'pergamino_seco';
    case VerdeAlmendra = 'verde_almendra';
    case Pasilla = 'pasilla';

    public function label(): string
    {
        return match ($this) {
            self::Cereza => 'Cereza',
            self::PergaminoHumedo => 'Pergamino húmedo',
            self::PergaminoSeco => 'Pergamino seco',
            self::VerdeAlmendra => 'Verde / almendra',
            self::Pasilla => 'Pasilla',
        };
    }

    public function getLabel(): string
    {
        return $this->label();
    }
}
