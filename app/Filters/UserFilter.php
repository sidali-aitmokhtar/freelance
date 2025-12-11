<?php

namespace App\Filters;

use App\Http\Requests\UserFilterRequest;
use Illuminate\Http\Request;


class UserFilter extends BaseFilter
{
    /**
     * Create a new class instance.
     */
    // protected $query;
    // protected $request;

    public function __construct(Request $request)
    {
        // $this->request=$request;
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

    protected function filters(){
        return $this->request->only([
            'search',
            'role'
        ]);
    }
    
    // protected function search($value){
    //     $this->query->where('name','like',"%$value%");
    // }

    protected function role($value){
        $this->query->role($value);
    }

}
