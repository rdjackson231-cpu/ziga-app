<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';


    protected $fillable = [
        'registered_at',
        'first_name',
        'middle_name',
        'last_name',
        'second_last_name',
        'gender',
        'age',
        'birth_date',
        'blood_type',
        'address',
        'email',
        'phone',
        'emergency_contact_name',
        'emergency_contact_phone',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'birth_date' => 'date',
    ];


    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_patient', 'patient_id', 'doctor_id');
    }

}

