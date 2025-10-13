<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'reason',
        'notes',
        'attached_files',
    ];

    protected $casts = [
        'date' => 'datetime',
        'attached_files' => 'array', // Convierte JSON automáticamente a array
    ];
}
