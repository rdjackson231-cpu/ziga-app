<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


use App\Livewire\PublicPatientForm;

Route::get('/registro/{token}', PublicPatientForm::class)->name('public.patient.form');


use App\Livewire\PublicClinicalHistoryForm;

Route::get('/registro/historia-clinica/{mrToken}', PublicClinicalHistoryForm::class)
    ->name('public.clinical-history');


use App\Livewire\PublicThankYouPage;

Route::get('/registro/listo', PublicThankYouPage::class)
    ->name('public.thankyou');
