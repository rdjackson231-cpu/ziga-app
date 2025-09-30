<?php

namespace App\Filament\Resources\Pacientes\Schemas;

use Filament\Infolists;
use Filament\Schemas\Schema;

class PacienteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Infolists\Components\TextEntry::make('registered_at')->label('Fecha y hora'),
                Infolists\Components\TextEntry::make('first_name')->label('Nombre'),
                Infolists\Components\TextEntry::make('middle_name')->label('Segundo nombre'),
                Infolists\Components\TextEntry::make('last_name')->label('Apellido paterno'),
                Infolists\Components\TextEntry::make('second_last_name')->label('Apellido materno'),
                Infolists\Components\TextEntry::make('gender')->label('Sexo'),
                Infolists\Components\TextEntry::make('age')->label('Edad'),
                Infolists\Components\TextEntry::make('birth_date')->label('Fecha de nacimiento'),
                Infolists\Components\TextEntry::make('blood_type')->label('Tipo de sangre'),
                Infolists\Components\TextEntry::make('address')->label('Domicilio'),
                Infolists\Components\TextEntry::make('email')->label('Correo'),
                Infolists\Components\TextEntry::make('phone')->label('Celular'),
                Infolists\Components\TextEntry::make('emergency_contact_name')->label('Contacto de emergencia'),
                Infolists\Components\TextEntry::make('emergency_contact_phone')->label('Celular del contacto de emergencia'),
            ]);
    }
}
