<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PurchaseController;

Route::get('/events', [EventController::class, 'index']);
Route::get('/event/{id}', [EventController::class, 'show']);
Route::post('/purchase', [PurchaseController::class, 'store']);
Route::get('/orders', [PurchaseController::class, 'index']);
Route::get('/orders/customer', [PurchaseController::class, 'getOrdersByCustomer']);
