<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['sale_price', 'start_date', 'end_date'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
