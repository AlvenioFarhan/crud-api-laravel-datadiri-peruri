<?php

use App\Http\Controllers\DataDiriController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route to handle CRUD operations for DataDiri
Route::resource('datadiri', DataDiriController::class);
