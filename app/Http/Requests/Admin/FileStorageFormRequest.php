<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FileStorageFormRequest extends FormRequest
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
            //            'filename' => [
            //                'required',
            //                'string',
            //                'max:255',
            //            ],
            //            'path' => [
            //                'required',
            //                'string',
            //                'max:255',
            //            ],
            //            'extension' => [
            //                'required',
            //                'string',
            //                'max:255',
            //            ],
            //            'mime_type' => [
            //                'required',
            //                'string',
            //                'max:255',
            //            ],
            //            'size' => [
            //                'required',
            //                'integer',
            //            ],
            //            'hash' => [
            //                'required',
            //                'string',
            //                'max:64',
            //            ],
            'description' => [
                'nullable',
                'string',
                'max:255',
            ],
            //            'is_public' => [
            //                'required',
            //                'boolean',
            //            ],
            //            'is_active' => [
            //                'required',
            //                'boolean',
            //            ],
            //            'user_id' => [
            //                'required',
            //                'integer',
            //                'exists:users,id',
            //            ],
            'files' => [
                'required',
                //                'File::mimes:csv,txt,xlx,xls,pdf,png,jpeg,jpg,gif,svg,doc,docx,odt,ods,odp',
                'max:20480',

            ],
        ];
    }
}
