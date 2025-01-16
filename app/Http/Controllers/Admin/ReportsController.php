<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CourseExport;
use App\Exports\StudentExport;
use App\Http\Controllers\Controller;
use App\Services\ProgramService;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    public function __construct(
        private ProgramService $programService
    ) {
    }

    public function index(): Response
    {
        return Inertia::render('Admin/Reports/Index', [
            'programs' => $this->programService->getAsDropdown(),
        ]);
    }

    public function export($type, Request $request)
    {
        $filters = $request->filters;

        $created_start = $filters['enrolled_from'];
        $created_end = $filters['enrolled_till'];
        $program_id = $filters['program'];

        if ($type === 'students') {
            return Excel::download(new StudentExport($program_id, $created_start, $created_end), 'students.xlsx');
        } else {
            return Excel::download(new CourseExport($created_start, $created_end), 'courses.xlsx');
        }

    }
}
