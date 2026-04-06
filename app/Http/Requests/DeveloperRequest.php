<?php

namespace Modules\Basicdata\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeveloperRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $id = $this->route('developer');

        if (is_object($id)) {
            $id = $id->id;
        }

        return [
            'code' => 'required|string|max:255|unique:developer,code,' . $id,
            'name' => 'required|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'code.required' => 'Code wajib diisi.',
            'code.unique' => 'Code sudah digunakan.',
            'name.required' => 'Name wajib diisi.',
        ];
    }
}
