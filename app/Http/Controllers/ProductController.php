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




    public function show(Product $product): ProductResource
    {
        $product->loadMissing('brand');
        return new ProductResource($product);
    }

    public function byCategory(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $query = $category->products()->with(['brand', 'notes', 'sale']);
        
        if ($request->filled('brand')) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        if ($request->filled('note')) {
            $query->whereHas('notes', function ($q) use ($request) {
                $q->where('name', $request->note);
            });
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->filled('size')) {
            $query->where('size', $request->size);
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        if ($request->boolean('on_sale')) {
            $query->whereNotNull('sale_id');
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
