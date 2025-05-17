<?php

    namespace Modules\Basicdata\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class CurrencyRequest extends FormRequest
    {
        /**
         * Get the validation rules that apply to the request.
         */
        public function rules()
        : array
        {
            $rules = [
                'name'              => 'required|string|max:255',
                'symbol'            => 'required|string|max:10',
                'decimal_places'    => 'nullable|integer|between:0,3',
                'status'            => 'nullable|boolean',
                'authorized_at'     => 'nullable|datetime',
                'authorized_status' => 'nullable|string|max:1',
                'authorized_by'     => 'nullable|exists:users,id',
            ];

            if ($this->method() == 'PUT') {
                $id = $this->id ? (int)$this->id : null;
                $rules['code'] = 'required|string|max:3|unique:currencies,code,' . $id;
            } else {
                $rules['code'] = 'required|string|max:3|unique:currencies,code';
            }

            return $rules;
        }

        /**
         * Determine if the user is authorized to make this request.
         */
        public function authorize()
        : bool
        {
            $user = auth()->guard('web')->user();

            if ($this->method() == 'PUT') {
                return $user && $user->can('basic-data.update');
            } elseif ($this->method() == 'POST') {
                return $user && $user->can('basic-data.create');
            }

            return true;
        }
    }
