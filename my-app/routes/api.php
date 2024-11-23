<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\ApiAuthentication;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware([ApiAuthentication::class])->group(function() {
    // company
    Route::post('/company/create', [CompanyController::class, 'create']);
    Route::get('/company/list', [CompanyController::class, 'list']);
    Route::get('/company/list/{id}', [CompanyController::class, 'showSpecific']);
    Route::delete('/company/delete/{id}', [CompanyController::class, 'delete']);
    Route::patch('/company/update/{id}', [CompanyController::class, 'update']);
    Route::get('/company/{id}/employees', [CompanyController::class, 'employees']);

    // employee
    Route::post('/employee/create', [EmployeeController::class, 'create']);
    Route::get('/employee/list', [EmployeeController::class, 'list']);
    Route::get('/employee/list/{id}', [EmployeeController::class, 'showSpecific']);
    Route::delete('/employee/delete/{id}', [EmployeeController::class, 'delete']);
    Route::patch('/employee/update/{id}', [EmployeeController::class, 'update']);
});