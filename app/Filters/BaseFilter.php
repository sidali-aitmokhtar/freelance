<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

abstract class BaseFilter
{
    protected $query;
    protected $request;
    public function __construct(Request $request)
    {
        $this->request=$request;
    }


    public function apply($query){
        $this->query=$query;
        foreach($this->filters() as $filter=>$value){
            if(method_exists($this,$filter)&&$value!==null){
                $this->$filter($value);
            }
        }
        return $this->query;
    }

    protected function filters(){
        return $this->request->only([
            'search',
            'anything'
        ]);
    }
    protected function search($value){
        $this->query->where('name','like',"%$value%");
    }
}
