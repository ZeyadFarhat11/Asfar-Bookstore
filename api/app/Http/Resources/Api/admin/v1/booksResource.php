<?php

namespace App\Http\Resources\Api\admin\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class booksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id ,
            "title" => $this->title ,
            "writter" => $this->writter ,
            "publisher" => $this->publisher,
            "vendor" => $this->vendor,
            "img" => $this->img ? env("APP_URL" , "http://localhost:8000")."/storage/books/{$this->img}":null,
            "created_at" => date("Y-m-d" , strtotime($this->created_at))
        ];
    }
}