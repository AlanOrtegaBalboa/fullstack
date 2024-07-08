<?php

namespace App\Providers;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerJsonGroup();
        foreach (glob(app_path('Macros/Blueprint/*.php')) as $filename) {
            $filename = basename($filename, '.php');
            $class = 'App\\Macros\\Blueprint\\' . $filename;
            $this->app->call($class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


    }
    public function registerJsonGroup(): void
    {
        Route::macro('jsonGroup', function (string $prefix, string $controller, array $methods = []){
            Route::prefix($prefix)->name($prefix .'.')->group(function () use ($controller, $methods) {
                if (in_array('index', $methods)){
                    Route::get('/', [$controller, 'index'])->name('index');
                }
                if (in_array('json', $methods)){
                    Route::get('/json', [$controller, 'json'])->name('json');
                }
                if (in_array('export', $methods)){
                    Route::post('/generate-export-url', [$controller, 'generateExportUrl'])->name('generate_export_url');
                    Route::get('/export', [$controller, 'export'])->name('export');
                }
                if (in_array('store', $methods)){
                    Route::post('/', [$controller, 'store'])->name('store');
                }
                if (in_array('update', $methods)){
                    Route::put('/{id}', [$controller, 'update'])->name('update');
                }
                if (in_array('destroy', $methods)){
                    Route::delete('/{id}', [$controller, 'destroy'])->name('destroy');
                }
            });
        });
        }
}
