<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
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
            'price'=>$this->price,
            'dead_line'=>$this->dead_line,
            'project'=>[
                'id'=>$this->project->id,
                'title'=>$this->project->title
            ],
            'client'=>[
                'id'=>$this->project->client->id,
                'name'=>$this->project->client->name
            ],
            'freelancer'=>[
                'id'=>$this->freelancer->id,
                'name'=>$this->freelancer->name
            ]
        ];
    }
}
