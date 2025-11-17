<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalRecord extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($record) {
            if (empty($record->code)) {
                // Generar código tipo MR-00001, MR-00002, etc.
                $nextId = (MedicalRecord::max('id') ?? 0) + 1;
                $record->code = 'EXP-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
                $record->status = 'open';
            }
        });
    }
    
    protected $fillable = ['patient_id', 'code', 'general_notes', 'status', 'token'];


    // Añadir accesores para exponer `code` como alias de `codigo`




    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    //public function consultas()
    //{
       // return $this->hasMany(Consulta::class);
   // }

    public function clinicalHistory()
    {
        return $this->hasMany(ClinicalHistory::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
}
