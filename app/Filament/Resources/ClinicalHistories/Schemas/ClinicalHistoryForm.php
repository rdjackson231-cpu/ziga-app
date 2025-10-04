<?php

namespace App\Filament\Resources\ClinicalHistories\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class ClinicalHistoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\Select::make('patient_id')
                ->label('Patient')
                ->relationship('patient', 'first_name')
                ->searchable()
                ->required(),

            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'open' => 'Open',
                    'closed' => 'Closed',
                    'pending' => 'Pending',
                ])
                ->required(),

            Forms\Components\Textarea::make('general_notes')
                ->label('General Notes')
                ->rows(5)
                ->maxLength(2000),
        ]);
    }
}
