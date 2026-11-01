<?php

namespace App\Filament\Resources\Buyers\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Http;

class BuyerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('type')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('address')
                    ->helperText('Escribe la dirección y pulsa "Obtener Coordenadas", o ingresa las coordenadas manualmente.')
                    ->hintAction(
                        Action::make('geocodeAddress')
                            ->label('Obtener Coordenadas')
                            ->icon(Heroicon::OutlinedMapPin)
                            ->action(function (Get $get, Set $set): void {
                                $address = trim((string) $get('address'));

                                if ($address === '') {
                                    Notification::make()
                                        ->danger()
                                        ->title('Dirección requerida')
                                        ->body('Escribe una dirección antes de obtener las coordenadas.')
                                        ->send();

                                    return;
                                }

                                try {
                                    $request = Http::withHeaders([
                                        'User-Agent' => 'CafePrecios/1.0 ('.config('app.url').')',
                                        'Accept-Language' => 'es',
                                    ])->timeout(10);

                                    if (app()->isLocal()) {
                                        $request->withoutVerifying();
                                    }

                                    $response = $request->get('https://nominatim.openstreetmap.org/search', [
                                        'q' => $address,
                                        'format' => 'json',
                                        'limit' => 1,
                                        'countrycodes' => 'co',
                                    ]);

                                    if (! $response->successful()) {
                                        Notification::make()
                                            ->danger()
                                            ->title('No pudimos obtener las coordenadas')
                                            ->body('Nominatim no respondió correctamente. Ingresa las coordenadas manualmente.')
                                            ->send();

                                        return;
                                    }

                                    $location = $response->json()[0] ?? null;

                                    if (! is_array($location) || ! isset($location['lat'], $location['lon'])) {
                                        Notification::make()
                                            ->danger()
                                            ->title('Dirección no encontrada')
                                            ->body('Revisa la dirección o ingresa las coordenadas manualmente.')
                                            ->send();

                                        return;
                                    }

                                    $set('latitude', (string) $location['lat']);
                                    $set('longitude', (string) $location['lon']);

                                    Notification::make()
                                        ->success()
                                        ->title('Coordenadas obtenidas')
                                        ->body('Revisa el mapa y ajusta el pin si es necesario.')
                                        ->send();
                                } catch (\Throwable $exception) {
                                    report($exception);

                                    Notification::make()
                                        ->danger()
                                        ->title('No pudimos obtener las coordenadas')
                                        ->body('Revisa la dirección o ingresa las coordenadas manualmente.')
                                        ->send();
                                }
                            })
                    ),
                Grid::make(2)
                    ->schema([
                        TextInput::make('latitude')
                            ->numeric()
                            ->rules(['required'])
                            ->validationMessages([
                                'required' => 'Debes obtener las coordenadas antes de guardar',
                            ]),
                        TextInput::make('longitude')
                            ->numeric()
                            ->rules(['required'])
                            ->validationMessages([
                                'required' => 'Debes obtener las coordenadas antes de guardar',
                            ]),
                    ]),
                View::make('filament.forms.components.buyer-location-map')
                    ->columnSpanFull(),
                TextInput::make('phone')
                    ->tel(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
