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
        $suggested = Product::with(['brand', 'sale'])->inRandomOrder()->take(12)->get();
        $popular = Product::with(['brand', 'sale'])->inRandomOrder()->take(12)->get();
        $recentlyViewed = Product::with(['brand', 'sale'])->latest()->take(6)->get();

        return response()->json([
            'suggested' => ProductResource::collection($suggested),
            'popular' => ProductResource::collection($popular),
            'recently_viewed' => ProductResource::collection($recentlyViewed),
        ]);
    }

    public function show(Product $product): ProductResource
    {
        $product->loadMissing('brand');
        return new ProductResource($product);
    }

    public function byCategory(Request $request, $slug)
    {
        if ($slug === 'sale') {
            $query = Product::with(['brand', 'notes', 'sale'])
                ->whereNotNull('sale_id')
                ->filter($request)
                ->sort($request->input('sort', 'relevance'));
        } else {
            $category = Category::where('slug', $slug)->firstOrFail();
            $query = $category->products()->with(['brand', 'notes', 'sale'])
                ->filter($request)
                ->sort($request->input('sort', 'relevance'));
        }

        $products = $query->paginate(12);
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
