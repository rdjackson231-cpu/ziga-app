<?php

namespace App\Filament\Resources\Consultations\Schemas;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Group;

use Filament\Schemas\Schema;

class ConsultationForm
{
    public static function configure(Schema $schema): Schema
    {
       return $schema->schema([
            Group::make()->schema([
                DatePicker::make('date')
                    ->label('Fecha de la consulta')
                    ->required(),

                TextInput::make('reason')
                    ->label('Motivo')
                    ->required()
                    ->maxLength(255),

                Textarea::make('notes')
                    ->label('Notas')
                    ->rows(5),

                FileUpload::make('attached_files')
                    ->label('Archivos adjuntos')
                    ->multiple()
                    ->disk('public')              // o el disco que uses (s3, public...)
                    ->visibility('public')        // hace que los archivos sean accesibles para preview/download
                    ->preserveFilenames(),
            ])
        ]);
    }
}
