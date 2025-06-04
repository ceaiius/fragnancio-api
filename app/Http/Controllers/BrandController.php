<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{


    public function index() {
        return Brand::all();
    }


    public function products(Request $request, $slug) {
        $brand = Brand::where('slug', $slug)->firstOrFail();
        $products = $brand->products()->with(['brand', 'notes', 'sale'])
            ->filter($request)
            ->sort($request->input('sort', 'relevance'))
            ->paginate(12);
        
        return ProductResource::collection($products);
    }

}
