<?php

namespace App\Rules;

use App\Models\EmployeeClock;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;

class Clock implements Rule, DataAwareRule
{

    protected $data = [];

    public function authorize()
    {
        return true;
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    private function validAction($action)
    {
        $last_clock = EmployeeClock::where('employees_id', $this->data['employees_id'])
            ->orderBy('id', 'desc')
            ->limit(1)
            ->first();

        if (isset($last_clock->in) && isset($last_clock->out) && $action === 'in') {
            return true;
        }

        if ($action == 'in' && !isset($last_clock->out)) {
            if (isset($last_clock->in)) {
                return false;
            } else {
                return true;
            }
        }

        if ($action == 'out' && isset($last_clock->in)) {
            if (isset($last_clock->out)) {
                return false;
            } else {
                return true;
            }
        }

        return false;
    }

    public function passes($attribute, $value)
    {
        return $this->validAction($value);
    }

    public function message()
    {
        return 'This action is not allowed.';
    }
}
