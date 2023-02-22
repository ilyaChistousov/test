<?php

use App\Http\Controllers\TextController;
use Illuminate\Support\Facades\Route;

Route::post("/check", [TextController::class, 'check']);
