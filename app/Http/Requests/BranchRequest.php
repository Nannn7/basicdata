<?php

    namespace Modules\Basicdata\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class BranchRequest extends FormRequest
    {
        /**
         * Get the validation rules that apply to the request.
         */
        public function rules()
        : array
        {
            $rules = [
                'name'              => 'required|string|max:255',
                'status'            => 'nullable|boolean',
                'authorized_at'     => 'nullable|datetime',
                'authorized_status' => 'nullable|string|max:1',
                'authorized_by'     => 'nullable|exists:users,id',
            ];

            if ($this->method() == 'PUT') {
                $rules['code'] = 'required|string|max:3|unique:branches,code,' . $this->id;
            } else {
                $rules['code'] = 'required|string|max:3|unique:branches,code';
            }

            return $rules;
        }

        /**
         * Determine if the user is authorized to make this request.
         */
        public function authorize()
        : bool
        {
            return true;
        }
    }
