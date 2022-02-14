<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\FormRequest;
use App\Rules\ValidSin;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => ['required', 'filled', 'string'],
            'last_name' =>  ['required', 'filled', 'string'],
            'email' =>  ['required', 'filled', 'email'],
            'sin' => ['required', 'filled', 'string', new ValidSin, 'unique:employees,sin'],
            'sin_expiry_date' =>  ['filled', 'date'],
            'hourly_wage_rate' =>  ['required', 'filled', 'between:0,99.9999'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'sin' => str_replace(array('-', '/', ' ', "\t"), '', trim($this->sin))
        ]);
    }
}
