<?php

namespace App\Filament\Pages;

use App\Enums\UserRole;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Filament\Support\Components\Attributes\Exposed;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;

class SettingsPage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Settings';

    protected static ?string $title = 'Settings';

    protected static ?int $navigationSort = 10;

    protected static ?string $slug = 'settings';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->role === UserRole::Admin;
    }

    public function mount(): void
    {
        $this->form->fill($this->getSettingsData());
    }

    /**
     * @return array<string, mixed>
     */
    protected function getSettingsData(): array
    {
        return DB::table('settings')->pluck('value', 'key')->all();
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('weight_unit')
                    ->label('Unidad de peso')
                    ->options([
                        'kg' => 'Kilogramos (kg)',
                        'arroba' => 'Arroba',
                        'carga' => 'Carga',
                    ])
                    ->required(),
                TextInput::make('region')
                    ->label('Región / Departamento')
                    ->required(),
                TextInput::make('contact_email')
                    ->label('Email de contacto')
                    ->email()
                    ->required(),
                Textarea::make('terms_text')
                    ->label('Términos y condiciones')
                    ->rows(4)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }

    #[Exposed]
    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'updated_at' => now(), 'created_at' => now()],
            );
        }

        Notification::make()
            ->success()
            ->title('Configuración guardada')
            ->send();
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label('Guardar')
            ->submit('save')
            ->keyBindings(['mod+s']);
    }

    /**
     * @return array<Action>
     */
    protected function getFormActions(): array
    {
        return [$this->getSaveFormAction()];
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make($this->getFormActions())
                            ->alignment($this->getFormActionsAlignment())
                            ->fullWidth(false)
                            ->sticky($this->areFormActionsSticky())
                            ->key('form-actions'),
                    ]),
            ]);
    }
}
