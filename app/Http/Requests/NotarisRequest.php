<?php

namespace Modules\Basicdata\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotarisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('notaris');

        if (is_object($id)) {
            $id = $id->id;
        }

        return [
            'code' => 'required|string|max:255|unique:notaris,code,' . $id,
            'name' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Code wajib diisi.',
            'code.unique' => 'Code sudah digunakan.',
            'name.required' => 'Name wajib diisi.',
        ];
    }
}
