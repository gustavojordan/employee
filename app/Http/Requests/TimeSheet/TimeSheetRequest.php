<?php

namespace App\Http\Requests\TimeSheet;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rule;

class TimeSheetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'employees_id' => ['filled', 'exists:employees,id', 'string'],
            'action' => ['filled', Rule::in(['in', 'out']), 'string'],
            'start_date' =>  ['filled',  'date_format:Y-m-d H:i:s', 'before:end_date'],
            'end_date' => ['filled', 'date_format:Y-m-d H:i:s', 'after:start_date']
        ];
    }
}
