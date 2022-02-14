<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeClock;
use Illuminate\Database\Seeder;

class EmployeeClockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = Employee::all();

        for ($day = 30; $day > 0; $day--) {
            $date = today()->subDays($day);
            foreach ($employees as $employee) {
                EmployeeClock::factory([
                    'employees_id' => $employee->id,
                    'in' => $date->setHour('9')->setMinute(0)->setSeconds(rand(0, 59)),
                    'out' => $date->copy()->setHour(rand(9, 17))->setMinute(rand(1, 59))->setSeconds(rand(0, 59)),
                ])->create();
            }
        }
    }
}
