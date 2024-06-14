<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class BackofficeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Route::group(
          [
              'prefix' => 'backoffice',
              'as' => 'backoffice.',
              'namespace' => 'App\Http\Controllers\Backoffice',
              'middleware' => [
                  'backoffice'
              ],

          ],
            fn ($router) => require __DIR__.'/../../routes/backoffice.php'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
