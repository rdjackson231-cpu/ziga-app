<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = ['nombre', 'especialidad', 'telefono', 'email'];

public function patients()
{
    return $this->belongsToMany(Patient::class, 'doctor_patient', 'doctor_id', 'patient_id');
}


}
