<?php

use App\Filament\Pages\RegisterFrom;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return view("welcome");
});

use App\Livewire\PublicPatientForm;

Route::get("/registro/{token}", PublicPatientForm::class)->name(
    "public.patient.form",
);
Route::get("register", RegisterFrom::class)->name("register");
