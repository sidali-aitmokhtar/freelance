<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use PHPStan\PhpDocParser\Ast\Type\ThisTypeNode;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'details'=>$this->details,
            'client'=>[
                'id'=>$this->client->id,
                'name'=>$this->client->name
            ]
        ];
    }
}
