<?php


namespace App\Filament\Resources\MedicalRecords\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class MedicalRecordForm
{
    public static function make(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('patient_id')
                    ->relationship('patient', 'first_name') // Asume que el modelo Patient tiene un campo 'full_name'
                    ->label('Patient')
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('code')
                    ->label('Code')
                    ->unique(ignoreRecord: true),

                Forms\Components\Textarea::make('general_notes')
                    ->label('General Notes')
                    ->rows(5)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
