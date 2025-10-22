<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


use App\Livewire\PublicPatientForm;

Route::get('/registro/{token}', PublicPatientForm::class)->name('public.patient.form');
