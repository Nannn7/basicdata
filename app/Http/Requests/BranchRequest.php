<?php

    namespace Modules\Basicdata\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

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
                'parent_id' => [
                    'nullable',
                    'exists:branches,id',
                    function ($attribute, $value, $fail) {
                        if ($value == $this->route('branch')) {
                            $fail('Cabang tidak dapat menjadi induk dari dirinya sendiri.');
                        }
                    },
                ],
                'status'            => 'nullable|boolean',
                'authorized_at'     => 'nullable|datetime',
                'authorized_status' => 'nullable|string|max:1',
                'authorized_by'     => 'nullable|exists:users,id',
                'is_dalam_kota'     => 'nullable|in:0,1',
            ];

            if ($this->method() == 'PUT') {
                $rules['code'] = [
                    'required',
                    'string',
                    'max:10',
                    Rule::unique('branches')->ignore($this->id)->where(function ($query) {
                        return $query->whereNull('deleted_at');
                    }),
                ];
            } else {
                $rules['code'] = [
                    'required',
                    'string',
                    'max:10',
                    Rule::unique('branches')->where(function ($query) {
                        return $query->whereNull('deleted_at');
                    }),
                ];
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
