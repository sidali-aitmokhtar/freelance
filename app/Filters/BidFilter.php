<?php

namespace App\Filters;

use Illuminate\Http\Request;

class BidFilter extends BaseFilter
{
    /**
     * Create a new class instance.
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    protected function filters(){
        return $this->request->only([
            'search',
            'sort'
        ]);
    }
    protected function sort($value){
        $this->query->orderBy($value);
    }
}
