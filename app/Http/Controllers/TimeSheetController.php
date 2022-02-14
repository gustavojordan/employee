<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeSheet\TimeSheetRequest;
use App\Models\EmployeeClock;

class TimeSheetController extends Controller
{

    public function index(TimeSheetRequest $request)
    {
        $data = $request->validated();

        $timesheet = new EmployeeClock();

        $results = $timesheet->timesheet(
            $data['employees_id'] ?? null,
            $data['start_date'] ?? null,
            $data['end_date'] ?? null,
            $data['action'] ?? null
        );

        return response()->json($results->paginate(100)->withQueryString(), 200);
    }
}
