<?php

namespace App\Filament\Resources\Pacientes\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;

class PacientesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('first_name')->label('Nombre'),
                Tables\Columns\TextColumn::make('last_name')->label('Apellido'),
                Tables\Columns\TextColumn::make('gender')->label('Sexo'),
                Tables\Columns\TextColumn::make('age')->label('Edad'),
                Tables\Columns\TextColumn::make('blood_type')->label('Tipo de sangre'),
                Tables\Columns\TextColumn::make('phone')->label('Celular'),
                Tables\Columns\TextColumn::make('emergency_contact_name')->label('Contacto emergencia'),
            ])
            ->filters([])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
