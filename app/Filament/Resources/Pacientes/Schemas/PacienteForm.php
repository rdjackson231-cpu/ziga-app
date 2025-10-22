<?php

namespace App\Filament\Resources\Pacientes\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class PacienteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\DateTimePicker::make('registered_at')
                    ->label('Fecha y hora')
                    ->default(now()),

                Forms\Components\TextInput::make('first_name')
                    ->label('Nombre')
                    ->required(),

                Forms\Components\TextInput::make('middle_name')
                    ->label('Segundo nombre'),

                Forms\Components\TextInput::make('last_name')
                    ->label('Apellido paterno')
                    ->required(),

                Forms\Components\TextInput::make('second_last_name')
                    ->label('Apellido materno'),

                Forms\Components\Select::make('gender')
                    ->label('Sexo')
                    ->options([
                        'Masculino' => 'Masculino',
                        'Femenino' => 'Femenino',
                        'Otro' => 'Otro',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('age')
                    ->label('Edad')
                    ->numeric(),

                Forms\Components\DatePicker::make('birth_date')
                    ->label('Fecha de nacimiento')
                    ->required(),

                Forms\Components\TextInput::make('blood_type')
                    ->label('Tipo de sangre'),

                Forms\Components\Textarea::make('address')
                    ->label('Domicilio'),

                Forms\Components\TextInput::make('email')
                    ->label('Correo')
                    ->email(),

                Forms\Components\TextInput::make('phone')
                    ->label('Celular'),

                Forms\Components\TextInput::make('emergency_contact_name')
                    ->label('Contacto de emergencia'),

                Forms\Components\TextInput::make('emergency_contact_phone')
                    ->label('Celular del contacto de emergencia'),
            ])->statePath('data');
    }
}
