<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\FormRequest;
use App\Rules\Clock;
use Illuminate\Validation\Rule;

class ClockRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'employees_id' => $this->route('employee'),
            'action' => $this->route('action')
        ]);
    }

    public function rules()
    {
        return [
            'employees_id' => [Rule::exists('employees', 'id')->whereNull('deleted_at'), 'integer'],
            'action' => ['string', new Clock, Rule::in(['in', 'out'])]
        ];
    }
}
