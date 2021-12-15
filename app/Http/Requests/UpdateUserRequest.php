<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
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
            'avatar' => ['sometimes', 'image'],
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(auth()->id())],
            'password'=> [
                'filled',
                'confirmed',
                'max:64',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->symbols(['!','@','#','$','%','^','-','_','+','='])
            ],
            'password_old' => 'password',
        ];
    }
}
