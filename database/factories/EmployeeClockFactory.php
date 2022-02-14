<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeClock;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeClockFactory extends Factory
{
    protected $model = EmployeeClock::class;

    public function definition()
    {
        return [
            'employees_id' => Employee::inRandomOrder()->first()->id,
            'in' => now()->setHour('9')->setMinute(0)->setSeconds(rand(0, 59)),
            'out' => now()->setHour(rand(9, 17))->setMinute(rand(1, 59))->setSeconds(rand(0, 59))
        ];
    }
}
