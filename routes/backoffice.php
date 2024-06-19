<?php


Route::jsonGroup('dashboard', \App\Http\Controllers\Backoffice\DashboardController::class, [
    'index', 'json'

]);
