<?php

use Illuminate\Support\Facades\Route;
use Modules\Shipment\Http\Controllers\ShipmentController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('shipments', [ShipmentController::class, 'index'])->name('shipments.index');
    Route::get('shipments/create', [ShipmentController::class, 'create'])->name('shipments.create');
    Route::post('shipments', [ShipmentController::class, 'store'])->name('shipments.store');
    Route::get('shipments/{shipment}', [ShipmentController::class, 'show'])->name('shipments.show');
});
