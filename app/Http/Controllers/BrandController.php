<?php

namespace App\Http\Controllers;

use App\Models\Brand;


class BrandController extends Controller
{


    public function index() {
        return Brand::all();
    }


    public function show($slug) {
        $brand = Brand::where('slug', $slug)->firstOrFail();
        return $brand->products()->paginate(12);
    }

}
