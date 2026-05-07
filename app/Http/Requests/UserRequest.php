<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ];
        if ($this->isMethod('post')) {
            $rules['password'] = 'required|string|min:6';
        }
        return $rules;
    }
}
