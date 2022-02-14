<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\FormRequest;
use App\Rules\ValidSin;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => ['filled', 'string'],
            'last_name' =>  ['filled', 'string'],
            'email' =>  ['filled', 'email'],
            'sin' => ['string', new ValidSin, 'unique:employees,sin'],
            'sin_expiry_date' =>  ['filled', 'date'],
            'hourly_wage_rate' =>  ['filled', 'between:0,99.9999'],
        ];
    }

    protected function prepareForValidation()
    {
        if (isset($this->sin)) {
            $this->merge([
                'sin' => str_replace(array('-', '/', ' ', "\t"), '', trim($this->sin))
            ]);
        }
    }
}
