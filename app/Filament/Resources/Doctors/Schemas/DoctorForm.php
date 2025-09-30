<?php

namespace App\Filament\Resources\Doctors\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class DoctorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->columns(1)->schema([
            Forms\Components\TextInput::make('nombre')->required(),
            Forms\Components\TextInput::make('especialidad'),
            Forms\Components\TextInput::make('telefono'),
            Forms\Components\TextInput::make('email')->email()->unique(ignoreRecord: true),

            // Relación muchos a muchos
            Forms\Components\Select::make('patients')
                ->multiple()
                ->relationship('patients', 'first_name') // usa relación definida en el modelo
                ->preload()
                ->searchable(),
        ]);
    }
}
