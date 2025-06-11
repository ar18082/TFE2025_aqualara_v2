<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PropertyFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'DesApp' => ['nullable', 'string', 'max:255'],
            'RefAppCli' => ['required', 'string', 'max:32'],
            'ReAppTR' => ['nullable', 'string', 'max:255'],
            'Codecli' => ['nullable', 'string', 'max:255'],
            'datefin' => ['nullable', 'string', 'max:64'],
            'lanco' => ['nullable', 'string', 'max:24'],
            'bloc' => ['nullable', 'string', 'max:255'],
            'proprietaire' => ['nullable', 'string', 'max:225'],
            'cellule' => ['nullable', 'string', 'max:225'],

        ];
    }
}
