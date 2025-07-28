<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProximityAlertController; 
use App\Events\DeliveryLocationUpdated;

// Route to display the form
Route::get('/proximity-form', function () {
    return view('dashboard.form');
})->name('proximity.form');

// Route to handle the form submission and call the controller
Route::post('/check-proximity', [ProximityAlertController::class, 'checkProximity'])
    ->name('check.proximity');

Route::get('/tracking-map', function () {
    return view('dashboard.tracking');
})->name('tracking.map');

Route::get('/simulator', function () {
    return view('dashboard.simulator');
})->name('simulator');

Route::post('/api/update-location', function (Request $request) {
    $validated = $request->validate([
        'lat' => 'required|numeric',
        'lng' => 'required|numeric',
    ]);
    broadcast(new DeliveryLocationUpdated((float)$validated['lat'], (float)$validated['lng']));
    return response()->json(['status' => 'success']);
});