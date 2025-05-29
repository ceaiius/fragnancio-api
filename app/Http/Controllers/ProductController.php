<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class ProductController extends Controller
{
    public function home(): JsonResponse
    {
        $suggested = Product::with('brand')->inRandomOrder()->take(12)->get();
        $popular = Product::with('brand')->inRandomOrder()->take(12)->get();
        $recentlyViewed = Product::with('brand')->latest()->take(6)->get();

        return response()->json([
            'suggested' => ProductResource::collection($suggested),
            'popular' => ProductResource::collection($popular),
            'recently_viewed' => ProductResource::collection($recentlyViewed),
        ]);
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Product::query()->with('brand');

        if ($request->has('type')) {
            $query->where('gender', $request->type);
        }

        return ProductResource::collection($query->paginate(12));
    }

    public function show(Product $product): ProductResource
    {
        $product->loadMissing('brand');
        return new ProductResource($product);
    }

    public function byCategory($slug): AnonymousResourceCollection
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = $category->products()->with('brand')->paginate(12);

        return ProductResource::collection($products);
    }

    public function suggested(Request $request): AnonymousResourceCollection
    {
        $products = Product::with('brand')->latest()->paginate(10);
        return ProductResource::collection($products);
    }

    public function popular(Request $request): AnonymousResourceCollection 
    {
        $products = Product::with('brand')->inRandomOrder()->paginate(10);
        return ProductResource::collection($products);
    }

    public function recentlyViewed(Request $request): AnonymousResourceCollection 
    {

        $products = Product::with('brand')->inRandomOrder()->paginate(10);
        return ProductResource::collection($products);
    }
}
