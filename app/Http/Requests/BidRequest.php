<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BidRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bid'=>$this->isMethod('POST')?['required','numeric']:['nullable','numeric'],
            'months'=>$this->isMethod('POST')?['required']:['nullable'],
            'days'=>$this->isMethod('POST')?['required']:['nullable'],
            'milestone_json'=>$this->isMethod('POST')?['required']:['nullable']
        ];
    }
}
