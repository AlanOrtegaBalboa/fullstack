<?php


use Illuminate\Http\Request;

Route::jsonGroup('dashboard', \App\Http\Controllers\Backoffice\DashboardController::class, [
    'index', 'json'

]);

Route::jsonGroup('categories', \App\Http\Controllers\Backoffice\CategoryController::class, [
    'index', 'json', 'store', 'update', 'destroy', 'export',
]);

Route::post('/test', function (Request $request){
    return response()->json($request->all());
});
