<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'condition',
        'category_id',
        'image',
        'size'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function notes(): BelongsToMany
    {
        return $this->belongsToMany(Note::class);
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function scopeFilter($query, $request)
    {
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
        return $query;
    }

    public function scopeSort($query, $sort)
    {
        switch ($sort) {
            case 'price_asc':
                $query->leftJoin('sales', 'products.sale_id', '=', 'sales.id')
                    ->orderByRaw('COALESCE(sales.sale_price, products.price) asc')
                    ->select('products.*');
                break;
            case 'price_desc':
                $query->leftJoin('sales', 'products.sale_id', '=', 'sales.id')
                    ->orderByRaw('COALESCE(sales.sale_price, products.price) desc')
                    ->select('products.*');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'relevance':
            default:
                break;
        }
        return $query;
    }

}
