<?php

namespace App\Http\Requests\Cobro;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCobroRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'value'         => ['sometimes', 'required', 'number', 'between:50,500000'],
            'description'   => ['sometimes', 'required', 'string'],
        ];
    }
}
