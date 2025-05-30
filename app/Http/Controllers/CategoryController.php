<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): JsonResponse{
        
        $categories = Category::all();

        if ($categories->isEmpty()) {
            return response()->json([
                'message' => 'No categories found',
                'data' => []
            ], status: 404);
        }

        return response()->json($categories);
    }
}
