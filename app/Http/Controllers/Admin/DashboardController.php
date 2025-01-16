<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\StudentCourse;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $courses = Course::where('status', 1)->get();
        $numberOfStudents = $courses->map(function ($course) {
            return [
                'course_id' => $course->id,
                'student_count' => $course->numberOfStudents(),
            ];
        })->keyBy('course_id');

        $numberOfCompletedStudents = $courses->map(function ($course) {
            return [
                'course_id' => $course->id,
                'completed_student_count' => $course->numberOfCompletedStudents(),
            ];
        })->keyBy('course_id');

        $courseCompleted = 0;
       
        foreach ($numberOfCompletedStudents as $key => $value) {
            $courseCompleted += $value['completed_student_count'];
        }

        $newUsersThisWeek = User::where('created_at', '>=', Carbon::now()->startOfWeek())
            ->where('created_at', '<=', Carbon::now()->endOfWeek())
            ->count();


        $totalUsers = User::where('user_type', UserType::Student()->value)
            ->whereNull('deleted_at')
            ->count();

        $activeUsers = User::where('user_type', UserType::Student()->value)
            ->whereNull('deleted_at')
            ->where('status', 1)
            ->count();

        $inactiveUsers = User::where('user_type', UserType::Student()->value)
            ->whereNull('deleted_at')
            ->where('status', 0)
            ->count();

        return Inertia::render('Admin/Dashboard/Index', [
            'courses' => $courses,
            'numberOfStudents' => $numberOfStudents,
            'numberOfCompletedStudents' => $numberOfCompletedStudents,
            'newUsers' => $newUsersThisWeek,
            'courseCompleted' => $courseCompleted,
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'inactiveUsers' => $inactiveUsers
        ]);
    }

    public function getUserCount()
    {
        $year =  Carbon::now()->year;
        $month =  Carbon::now()->month;

        $daysInMonth = Carbon::createFromDate($year, $month)->daysInMonth;
        $countByDay = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($year, $month, $day);

            $count = User::whereDate('created_at', $date)
                ->where('user_type', UserType::Student()->value)
                ->count();

            $countByDay[$date->format('Y-m-d')] = $count ?: 0;
        }

        $total = number_format(array_sum($countByDay));

        return [
            'total' => $total,
            'count' => $countByDay,
        ];
    }

    public function getStudentsCount()
    {
        
        $year = Carbon::now()->year;
        $months = [];
        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::createFromDate($year, $month, 1);
            $months[] = $startDate->format('Y-m');
        }
        
        $totalEnrolledStudents = array_fill(0, 12, 0);
        $graduatedStudents = array_fill(0, 12, 0);

        $currentYear = Carbon::now()->year;

        // Retrieve all enrollments for the current year
        $enrollments = StudentCourse::whereYear('created_at', $currentYear)
            ->get(['created_at']);

        foreach ($enrollments as $enrollment) {
            $enrollMonth = Carbon::parse($enrollment->created_at)->month;
            $totalEnrolledStudents[$enrollMonth - 1]++;
        }

        // Retrieve all completions for the current year
        $completions = StudentCourse::whereNotNull('completed_at')
            ->whereYear('completed_at', $currentYear)
            ->get(['completed_at']);

        foreach ($completions as $completion) {
            $completeMonth = Carbon::parse($completion->completed_at)->month;
            $graduatedStudents[$completeMonth - 1]++;
        }

        return [
            "months" => $months,
            "totalEnrolledStudents" => $totalEnrolledStudents,
            "graduatedStudents" => $graduatedStudents,
        ];
    }
}
