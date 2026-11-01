<?php

namespace App\Filament\Resources\AuditLogs\Tables;

use App\Models\AuditLog;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AuditLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Usuario')
                    ->placeholder('—'),
                TextColumn::make('action')
                    ->label('Acción')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('entity_type')
                    ->label('Entidad')
                    ->limit(30),
                TextColumn::make('entity_id')
                    ->label('ID'),
                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('action')
                    ->options(fn (): array => AuditLog::query()
                        ->distinct()
                        ->orderBy('action')
                        ->pluck('action')
                        ->mapWithKeys(fn (string $action): array => [$action => $action])
                        ->all()),
                SelectFilter::make('entity_type')
                    ->options(fn (): array => AuditLog::query()
                        ->distinct()
                        ->orderBy('entity_type')
                        ->pluck('entity_type')
                        ->filter()
                        ->mapWithKeys(fn (string $entityType): array => [$entityType => $entityType])
                        ->all()),
                Filter::make('created_at')
                    ->label('Rango de fechas')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('Desde'),
                        DatePicker::make('created_until')
                            ->label('Hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['created_from'] ?? null, fn (Builder $query, string $date): Builder => $query->whereDate('created_at', '>=', $date))
                            ->when($data['created_until'] ?? null, fn (Builder $query, string $date): Builder => $query->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
