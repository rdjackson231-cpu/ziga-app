<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClinicalHistory extends Model
{
    //
    protected $table = 'clinical_histories';

    protected $fillable = [
        'patient_id',
        'status',
        'general_notes',
    ];

    /**
     * Relación con Paciente
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}