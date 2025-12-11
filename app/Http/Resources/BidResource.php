<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use PHPStan\PhpDocParser\Ast\Type\ThisTypeNode;

class BidResource extends JsonResource
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
            'bid'=>$this->bid,
            'time'=>"$this->months months and $this->days days",
            'freelancer'=>[
                'id'=>$this->freelancer->id,
                'name'=>$this->freelancer->name
            ]
        ];
    }
}
