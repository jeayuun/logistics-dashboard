<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProximityAlertController; 
use App\Events\DeliveryLocationUpdated;

Route::get('/proximity-form', [ProximityAlertController::class, 'showForm'])
    ->name('proximity.form');

Route::post('/check-proximity', [ProximityAlertController::class, 'checkProximity'])
    ->name('check.proximity');

Route::get('/history', [ProximityAlertController::class, 'showHistory'])
    ->name('history');