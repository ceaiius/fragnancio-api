<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'brand' => $this->whenLoaded('brand', function () {
                return $this->brand ? $this->brand->name : null;
            }),
            'sale_price' => $this->whenLoaded('sale', function () {
                return $this->sale ? $this->sale->sale_price : null;
            }),
            'notes' => $this->whenLoaded('notes', function () {
                return $this->notes->pluck('name');
            }),
            'image' => $this->image,
            'size' => $this->size,
            'price' => (float) $this->price, // Good to cast
            'gender' => $this->gender,
            'category_id' => $this->category_id,

        ];
    }
}
