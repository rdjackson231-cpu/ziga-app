<?php

namespace App\Filament\Resources\ClinicalHistories;

use App\Filament\Resources\ClinicalHistories\Pages\CreateClinicalHistory;
use App\Filament\Resources\ClinicalHistories\Pages\EditClinicalHistory;
use App\Filament\Resources\ClinicalHistories\Pages\ListClinicalHistories;
use App\Filament\Resources\ClinicalHistories\Pages\ViewClinicalHistory;
use App\Filament\Resources\ClinicalHistories\Schemas\ClinicalHistoryForm;

use App\Filament\Resources\ClinicalHistories\Schemas\ClinicalHistoryInfolist;
use App\Filament\Resources\ClinicalHistories\Tables\ClinicalHistoriesTable;
use App\Models\ClinicalHistory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ClinicalHistoryResource extends Resource
{
    protected static ?string $model = ClinicalHistory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Historia Clínica';

    public static function form(Schema $schema): Schema
    {
        return ClinicalHistoryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ClinicalHistoryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClinicalHistoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClinicalHistories::route('/'),
            'create' => CreateClinicalHistory::route('/create'),
            'view' => ViewClinicalHistory::route('/{record}'),
            'edit' => EditClinicalHistory::route('/{record}/edit'),
        ];
    }
}
