<?php

    namespace Modules\Basicdata\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

    class HolidayCalendarRequest extends FormRequest
    {
        /**
         * Get the validation rules that apply to the request.
         */
        public function rules()
        : array
        {
            return [
                'date'        => ['required', 'date'],
                'description' => ['required', 'string', 'max:255'],
                'type'        => ['required', Rule::in(['national_holiday', 'collective_leave'])],
            ];
        }

        /**
         * Get custom messages for validator errors.
         */
        public function messages()
        : array
        {
            return [
                'date.required'        => 'The date field is required.',
                'date.date'            => 'The date must be a valid date.',
                'description.required' => 'The description field is required.',
                'description.string'   => 'The description must be a string.',
                'description.max'      => 'The description may not be greater than 255 characters.',
                'type.required'        => 'The type field is required.',
                'type.in'              => 'The type must be either national holiday or collective leave.',
            ];
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
