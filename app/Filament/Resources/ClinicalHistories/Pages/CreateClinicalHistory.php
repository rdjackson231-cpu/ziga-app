<?php

namespace App\Filament\Resources\ClinicalHistories\Pages;

use App\Filament\Resources\ClinicalHistories\ClinicalHistoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateClinicalHistory extends CreateRecord
{
    protected static string $resource = ClinicalHistoryResource::class;
}
