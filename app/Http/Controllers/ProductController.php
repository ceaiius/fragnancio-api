<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    public function home(): JsonResponse
    {
        return response()->json([
            'suggested' => Product::inRandomOrder()->take(8)->get(),
            'popular' => Product::inRandomOrder()->take(8)->get(),
            'recently_viewed' => Product::latest()->take(8)->get(),
        ]);
    }

    public function index(Request $request) : LengthAwarePaginator
    {
        $query = Product::query();

        if ($request->has('type')) {
            $query->where('gender', $request->type);
        }

        return $query->paginate(12);
    }

    public function show(Product $product): JsonResponse
    {
         return response()->json($product);
    }

    public function byCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = $category->products()->paginate(12);

        return response()->json($products);
    }
}
