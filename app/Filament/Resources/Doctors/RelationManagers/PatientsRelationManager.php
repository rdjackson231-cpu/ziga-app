<?php

namespace App\Filament\Resources\DoctorResource\RelationManagers;

use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DetachAction;

class PatientsRelationManager extends RelationManager
{
    protected static string $relationship = 'patients'; // <- Nombre de la relación en Doctor.php

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')->label('Nombre'),
                Tables\Columns\TextColumn::make('email')->label('Email'),
                Tables\Columns\TextColumn::make('phone')->label('Teléfono'),
            ])
            ->headerActions([
                AttachAction::make(), // Para vincular pacientes existentes
                CreateAction::make(), // Crear paciente desde aquí
            ])
            ->recordActions([
                EditAction::make(),   // Editar paciente
                DetachAction::make(), // Quitar del doctor
                DeleteAction::make(), // Eliminar paciente
            ]);
    }
}
