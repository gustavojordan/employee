<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    private function generateSin($separator = ' ')
    {
        $validPrefix = array(1, 2, 4, 5, 6, 7);
        $sin = array_rand($validPrefix, 1);
        $length = 9;

        while (strlen($sin) < ($length - 1)) {
            $sin .= rand(0, 9);
        }

        $sum = 0;
        $pos = 0;

        $reversedSIN = strrev($sin);

        while ($pos < $length - 1) {
            $odd = $reversedSIN[$pos] * 2;
            if ($odd > 9) {
                $odd -= 9;
            }

            $sum += $odd;

            if ($pos != ($length - 2)) {
                $sum += $reversedSIN[$pos + 1];
            }
            $pos += 2;
        }

        $checkdigit = ((floor($sum / 10) + 1) * 10 - $sum) % 10;
        $sin .= $checkdigit;

        $sin1 = substr($sin, 0, 3);
        $sin2 = substr($sin, 3, 3);
        $sin3 = substr($sin, 6, 3);

        return $sin1 . $separator . $sin2 . $separator . $sin3;
    }

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'sin' => $this->generateSin(''),
            'hourly_wage_rate' => $this->faker->numberBetween(15, 100)
        ];
    }
}
