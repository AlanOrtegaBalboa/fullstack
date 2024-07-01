<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\ViewModels\Backoffice\Categories\GetCategoriesViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function json(GetCategoriesViewModel $viewModel): JsonResponse
    {

        return response()->json($viewModel->toArray());
    }
}
