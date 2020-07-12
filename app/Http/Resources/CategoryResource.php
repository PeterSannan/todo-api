<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{


    public function toArray($request)
    {
        return [
            'type' => 'Categories',
            'id' => (int)$this->id,
            'attributes' => [
                'Name' => $this->name, 
            ],
        ];
    }
}
