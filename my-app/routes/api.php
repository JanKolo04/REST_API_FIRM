<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\ApiAuthentication;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CompanyEmployeeController;

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
    Route::get('/company/list/{id_company}', [CompanyController::class, 'showSpecific']);
    Route::delete('/company/delete/{id_company}', [CompanyController::class, 'delete']);
    Route::patch('/company/update/{id_company}', [CompanyController::class, 'update']);
    Route::get('/company/{id_company}/employees', [CompanyController::class, 'employees']);

    // employee
    Route::post('/employee/create', [EmployeeController::class, 'create']);
    Route::get('/employee/list', [EmployeeController::class, 'list']);
    Route::get('/employee/list/{id_employee}', [EmployeeController::class, 'showSpecific']);
    Route::delete('/employee/delete/{id_employee}', [EmployeeController::class, 'delete']);
    Route::patch('/employee/update/{id_employee}', [EmployeeController::class, 'update']);

    // company employees
    Route::post('/company/{id_company}/employee/{id_employee}/add', [CompanyEmployeeController::class, 'add']);
    Route::delete('/company/{id_company}/employee/{id_employee}/delete', [CompanyEmployeeController::class, 'delete']);
});