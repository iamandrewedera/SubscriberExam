<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriberController;


Route::post('/subscriber', [SubscriberController::class, 'subscribe']);
Route::patch('/subscriber/unsubscribe', [SubscriberController::class, 'unsubscribe']);