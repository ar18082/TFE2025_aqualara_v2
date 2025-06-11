<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
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
            'titre' => ['required', 'string', 'max:255'],
            'nom' => ['nullable', 'string', 'max:255'],
            'email1' => ['nullable', 'email', 'max:255'],
            'tel' => ['nullable', 'string', 'max:32'],
            'gsm' => ['nullable', 'string', 'max:32'],
            'email2' => ['nullable', 'email', 'max:32'],
            'email3' => ['nullable', 'email', 'max:32'],
            'email4' => ['nullable', 'email', 'max:32'],
            'email5' => ['nullable', 'email', 'max:32'],
            'rue' => ['nullable', 'string', 'max:255'],
            'boite' => ['nullable', 'string', 'max:255'],
            'codpost' => ['nullable', 'string', 'max:24'],
            'pays' => ['nullable', 'string', 'max:255'],
            'p-g' => ['nullable', 'string', 'max:10 '],
        ];
    }
}
