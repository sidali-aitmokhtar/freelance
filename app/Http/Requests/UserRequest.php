<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>$this->isMethod('POST')?['required','string','max:255']:['nullable','string','max:255'],
            'money'=>$this->isMethod('POST')?['required']:['nullable'],
            'email'=>$this->isMethod('POST')?['required']:['nullable'],
            'password'=>$this->isMethod('POST')?['required']:['nullable']
            ];
    }
}
