<?php

namespace App\Filament\Resources\ClinicalHistories\Pages;

use App\Filament\Resources\ClinicalHistories\ClinicalHistoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditClinicalHistory extends EditRecord
{
    protected static string $resource = ClinicalHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
