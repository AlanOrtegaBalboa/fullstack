<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('backoffice.dashboard', [
            'json_url' => route('backoffice.dashboard.json'),
        ]);
    }
}

