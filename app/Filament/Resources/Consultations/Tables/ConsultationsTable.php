<?php

namespace App\Filament\Resources\Consultations\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\IconColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\DateTimeColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

class ConsultationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->label('Fecha')
                    ->sortable(),

                TextColumn::make('reason')
                    ->label('Motivo')
                    ->limit(50)
                    ->sortable(),

                TextColumn::make('notes')
                    ->label('Notas')
                    ->limit(50),

                TextColumn::make('attached_files')
                    ->label('Archivos')
                    ->getStateUsing(fn ($record) => $record->attached_files ? count($record->attached_files) . ' archivos' : 'No hay archivos'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
