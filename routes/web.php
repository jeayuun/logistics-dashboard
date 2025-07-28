<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProximityAlertController; 
use App\Events\DeliveryLocationUpdated;

Route::get('/proximity-form', function () {
    return view('dashboard.form');
})->name('proximity.form');

Route::post('/check-proximity', [ProximityAlertController::class, 'checkProximity'])
    ->name('check.proximity');