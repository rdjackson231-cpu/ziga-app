<?php

namespace App\Filament\Resources\Pacientes\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Illuminate\Support\Str;

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
                // Aquí van las acciones de fila si quieres
            ])
            ->headerActions([
                Action::make('generar_link')
                    ->label('Generar link de registro')
                    ->icon('heroicon-o-link')
                    ->color('success')
                    ->modalHeading('Link público de registro')
                    ->modalSubheading('Envía este enlace al paciente para que llene su formulario de registro.')
                    ->modalContent(function () {
                        // Generar token temporal
                        $token = (string) Str::uuid();
                        $url = url('/registro/' . $token);

                        // Guardar token en session para seguimiento opcional
                        session()->flash('public_patient_token', $token);

                        return view('livewire.copy-link-modal', [
                            'url' => $url,
                        ]);
                    })
                    ->modalSubmitAction(false),
            ]);
    }
}
