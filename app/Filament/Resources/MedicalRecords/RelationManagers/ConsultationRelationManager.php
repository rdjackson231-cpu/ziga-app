<?php

namespace App\Filament\Resources\MedicalRecords\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

class ConsultationRelationManager extends RelationManager
{
    protected static string $relationship = 'consultations';
    protected static bool $canCreate = true;

    public function schema(Schema $schema): Schema
    {
        return $schema
            ->schema([
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
                    ->disk('public')
                    ->visibility('public'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Fecha')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('reason')
                    ->label('Motivo')
                    ->limit(50)
                    ->sortable(),

                Tables\Columns\TextColumn::make('notes')
                    ->label('Notas')
                    ->limit(50),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('date', 'desc');
    }

    protected function getTableHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Agregar consulta'),
        ];
    }
}
