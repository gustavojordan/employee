<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\FormRequest;

class IndexEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'filters.first_name' => ['filled', 'string'],
            'filters.last_name' =>  ['filled', 'string'],
        ];
    }

}
