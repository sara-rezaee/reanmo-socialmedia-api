<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|unique:users,email',
            'password'=> [
                'required',
                'confirmed',
                'max:64',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->symbols(['!','@','#','$','%','^','-','_','+','='])
            ],
        ];
    }
}
