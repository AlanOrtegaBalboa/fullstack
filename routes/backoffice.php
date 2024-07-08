<?php

use App\Http\Controllers\Backoffice\DashboardController;
use App\Http\Controllers\Backoffice\CategoryController;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;


Route::jsonGroup('dashboard', DashboardController::class, [
    'index', 'json'

]);

Route::jsonGroup('categories', CategoryController::class, [
    'index', 'json', 'store', 'update', 'destroy', 'export',
]);

Route::post('/test', function (Request $request){
    return response()->json($request->all());
});
