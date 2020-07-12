<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{


    public function toArray($request)
    {
      
        return [
            'type' => 'tasks',
            'id' => (int)$this->id,
            'attributes' => [
                'name' => $this->name, 
                'description' => $this->description, 
                'datetime' => $this->datetime, 
                'status' => $this->status, 
                'category'=> new CategoryResource($this->category)
            ],

        ];
    }
}
