<?php

namespace App\Providers;


// use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
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
        //RedirectIfAuthenticated::redirectUsing(fn($request) => redirect($request->user()->getRedirectUrl()));

        $this->app->bind(
            abstract: \Illuminate\Pagination\LengthAwarePaginator::class,
            concrete: \App\Overrides\LengthAwarePaginator::class,
        );



    }

}
