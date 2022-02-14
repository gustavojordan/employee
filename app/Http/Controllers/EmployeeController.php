<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\ClockRequest;
use App\Http\Requests\Employee\IndexEmployeeRequest;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\EmployeeClock;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{

    public function index(IndexEmployeeRequest $request)
    {
        $employees = Employee::query();

        $data = $request->validated();

        if (isset($data['filters'])) {
            foreach ($data['filters'] as $filter => $value) {
                $employees->orWhere($filter, 'LIKE', '%' . $value . '%');
            }
        }

        return response()->json($employees->paginate(2)->withQueryString(), 200);
    }


    public function store(StoreEmployeeRequest $request)
    {
        $employee = Employee::create($request->validated());
        return response()->json($employee, Response::HTTP_CREATED);
    }

    public function show(Employee $employee)
    {
        return response()->json($employee, 200);
    }


    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->validated());
        return response()->json($employee, Response::HTTP_ACCEPTED);
    }


    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json(null, Response::HTTP_OK);
    }

    public function clock(ClockRequest $request)
    {
        $data = $request->validated();

        $clock = [
            'employees_id' => $data['employees_id']
        ];

        if ($data['action'] === 'in') {
            $clock['in'] = now();
            EmployeeClock::create($clock);
        } else {
            $clock = EmployeeClock::where('employees_id', $data['employees_id'])
                ->orderBy('id', 'desc')
                ->limit(1)
                ->first();

            $clock->out = now();
            $clock->save();
        }

        return response()->json(null, Response::HTTP_CREATED);
    }
}
