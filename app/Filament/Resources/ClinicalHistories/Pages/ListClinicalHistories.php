<?php

namespace App\Filament\Resources\ClinicalHistories\Pages;

use App\Filament\Resources\ClinicalHistories\ClinicalHistoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClinicalHistories extends ListRecords
{
    protected static string $resource = ClinicalHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
