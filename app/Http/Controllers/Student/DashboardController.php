<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\CourseService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(
        private CourseService $courseService
    )
    {
    }

    public function index(): Response
    {
        $student = auth()->user()->student;

        return Inertia::render('Student/Dashboard/Index', [
            'courses' => $this->courseService->getMyCourses($student),
            'completed_count' => count($this->courseService->getMyCoursesStatus($student, 'completed')),
            'ongoing' => $this->courseService->getMyCoursesStatus($student, 'ongoing'),
        ]);
    }
}
