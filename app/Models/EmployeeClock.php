<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeClock extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    public function timesheet($employees_id, $start_date, $end_date, $action = 'in')
    {

        $query = $this->join('employees AS e', 'e.id', '=', 'employee_clocks.employees_id');

        $query->select([
            'employee_clocks.id',
            'employee_clocks.in',
            'employee_clocks.out',
            'employee_clocks.employees_id',
            'e.hourly_wage_rate'
        ]);

        $query->selectRaw('(TIMESTAMPDIFF(SECOND, `in`, `out`) * (e.hourly_wage_rate / 60)) / 60 as gross_pay_calculated_hours');

        if (isset($employees_id)) {
            $query->where('employees_id', $employees_id);
        }

        if (isset($start_date) && isset($end_date)) {
            $query->where(function ($query) use ($start_date, $end_date, $action) {
                if ($action === 'in') {
                    $query->whereBetween('in', [$start_date, $end_date]);
                } else {
                    $query->WhereBetween('out', [$start_date, $end_date]);
                }
            });
        }

        return $query;
    }
}
