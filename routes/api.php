<?php

use App\Http\Controllers\PatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(PatientController::class)->group(function () {
    Route::get('/patients', 'index')->name('patients.index'); // GET /api/patients
    Route::get('/patients/{id}', 'show')->name('patients.show'); // GET /api/patients/{id}
});