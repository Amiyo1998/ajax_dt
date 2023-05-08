<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeController;


Route::resource('employes', EmployeController::class);
