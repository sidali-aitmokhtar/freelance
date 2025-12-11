<?php

namespace App\Filters;

use Illuminate\Http\Request;
use PHPStan\PhpDocParser\Ast\Type\ThisTypeNode;

class ProjectFilter extends BaseFilter
{
    // protected $query;
    // protected $request;
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
    // public function apply($query){
    //     $this->query=$query;
    //     foreach($this->filters() as $filter=>$value){
    //         if(method_exists($this,$filter)&&$value!==null){
    //             $this->$filter($value);
    //         }
    //     }
    //     return $this->query;
    // }
    // protected function filters(){
    //     return $this->request->only([
    //         'search',
    //         'al'
    //     ]);
    // }
    protected function search($value){
        $this->query->where('title','like',"%$value%");
    }  
}
