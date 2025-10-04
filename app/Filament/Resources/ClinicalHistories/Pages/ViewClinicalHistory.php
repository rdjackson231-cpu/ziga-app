<?php

namespace App\Filament\Resources\ClinicalHistories\Pages;

use App\Filament\Resources\ClinicalHistories\ClinicalHistoryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewClinicalHistory extends ViewRecord
{
    protected static string $resource = ClinicalHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
