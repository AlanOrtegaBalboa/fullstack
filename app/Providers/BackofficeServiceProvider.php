<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class BackofficeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Route::middleware(['backoffice', 'auth', 'verified'])
            ->prefix('backoffice')
            ->as('backoffice.')
            ->group(base_path('routes/backoffice.php')
            );
    }

    public function boot(): void
    {
        //
    }
}
