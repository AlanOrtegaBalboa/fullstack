<?php

use App\Constants\Heroicons;
use App\Http\Controllers\ProfileController;
use App\Services\Frontend\SidebarGenerator;
use App\Services\Frontend\UIElements\SidebarItems\SidebarHelloUser;
use App\Services\Frontend\UIElements\SidebarItems\SidebarLink;
use App\Services\Frontend\UIElements\SidebarItems\SidebarSeparator;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backoffice\DashboardController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', function () {
    dd(
        app(SidebarGenerator::class)
            ->addSidebarItem(new SidebarHelloUser())
            ->addSidebarItem(
                new SidebarLink(
                    text: 'Dashboard',
                    href: '#',
                    iconComponent: Heroicons::HOME,
                    current: false,
                )
            )
            ->addSidebarItem(new SidebarSeparator())
            ->addSidebarItem(
                new SidebarLink(
                    text: 'Cerrar sesión',
                    href: route('logout'),
                    iconComponent: Heroicons::LOGOUT,
                    current: false,
                )
            )
    );
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
