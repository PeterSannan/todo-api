<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    protected $token;

    public function __construct($resource, $token)
    {
        parent::__construct($resource);
        $this->resource = $resource;
        $this->token = $token;
    }

    public function toArray($request)
    {
        return [
            'type' => 'users',
            'id' => (int)$this->id,
            'attributes' => [
                'Email' => $this->email,
                'Gender' => $this->gender,
                'Birthday' => $this->birthday,
                'Phone' => $this->mobile,
                'created_at' => $this->created_at,
            ],

            'token' => $this->token
        ];
    }
}
