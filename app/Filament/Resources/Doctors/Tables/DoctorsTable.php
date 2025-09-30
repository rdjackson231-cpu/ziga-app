<?php

namespace App\Filament\Resources\Doctors\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Table;


class DoctorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')->sortable()->searchable(),
                TextColumn::make('especialidad'),
                TextColumn::make('email'),
                TextColumn::make('patients.first_name')
                    ->badge()
                    ->separator(', ')
                    ->label('Pacientes'),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
