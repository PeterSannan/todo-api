<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{

  
    public function toArray($request)
    {
        return [ 
            'errors' => [
                'status' => $this->code, 
                'title' => $this->title,
                'details' => $this->details, 
            ],
        ];
    }
}
