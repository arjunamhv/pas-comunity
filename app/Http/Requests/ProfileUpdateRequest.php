<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'nullable',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'telepon' => [
                'nullable',
                'string',
                'min:10',
                'max:15',
                'regex:/^\+?[0-9]{10,15}$/',
            ],
            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
            'detail_alamat' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}
