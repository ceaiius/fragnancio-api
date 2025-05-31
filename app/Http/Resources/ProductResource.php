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
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'brand' => $this->whenLoaded('brand', function () {
                return $this->brand ? $this->brand->name : null;
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
