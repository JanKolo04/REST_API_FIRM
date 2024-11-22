<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;

use App\Http\Middleware\ApiAuthentication;

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
    Route::get('/company/list/{$id}', [CompanyController::class, 'showSpecific']);
    Route::delete('/company/delete/{$id}', [CompanyController::class, 'delete']);
    Route::patch('/company/update/{$id}', [CompanyController::class, 'update']);
});