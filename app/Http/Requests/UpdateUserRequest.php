<?php

namespace App\Http\Requests;

use App\Rules\UppercaseRule;

class UpdateUserRequest extends ValidationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:6',
                new UppercaseRule
            ],
            'email' => 'required|email|unique:users,email',
        ];
    }
}
