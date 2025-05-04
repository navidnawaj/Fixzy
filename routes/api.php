<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Support\Facades\Route;

Route::apiResource('service', 'App\Http\Controllers\Api\ServiceController');
