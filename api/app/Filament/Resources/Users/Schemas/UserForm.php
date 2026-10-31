<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrated(fn ($state): bool => filled($state))
                    ->maxLength(255),
                Select::make('role')
                    ->options(collect(UserRole::cases())->mapWithKeys(fn (UserRole $role): array => [$role->value => $role->label()])->all())
                    ->default(UserRole::Farmer->value)
                    ->required()
                    ->live()
                    ->searchable(),
                TextInput::make('phone')
                    ->tel(),
                Toggle::make('is_verified')
                    ->default(false),
                Select::make('buyer_id')
                    ->relationship('buyer', 'name')
                    ->searchable()
                    ->required(fn (Get $get): bool => $get('role') === UserRole::CooperativeAdmin->value)
                    ->visible(fn (Get $get): bool => $get('role') === UserRole::CooperativeAdmin->value),
            ]);
    }
}
