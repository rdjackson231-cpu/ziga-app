<?php

namespace App\Filament\Resources\Pacientes\RelationManagers;

use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DetachAction;

class PatientRelationManager extends RelationManager
{
    protected static string $relationship = 'medicalRecord'; // nombre de la relación en Patient.php

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            
            ->recordUrl(fn ($record) => route('filament.admin.resources.medical-records.view', ['record' => $record]))
            
            ->columns([
                Tables\Columns\TextColumn::make('patient_id')
                    ->label('Patient ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('code')
                    ->label('Code')
                    ->color('primary')
                    ->weight('medium'),
            ])
            
            ->headerActions([
                CreateAction::make(), // Crear expediente desde aquí
                AttachAction::make(), // Asociar expediente existente
            ])
            
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                DetachAction::make(),
            ]);
    }
}
