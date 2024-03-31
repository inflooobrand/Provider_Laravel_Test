<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource{

  public function toArray($request)
  {
    return [
      'name'=>$this->name,
      'email'=>$this->email,
    ];
  }
}