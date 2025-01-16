<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Course;
use App\Models\StudentCourse;
use App\Models\StudentCourseTopic;
use App\Models\Topic;
use App\Services\CourseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class CourseController extends Controller
{
    public function __construct(
        private CourseService $courseService
    )
    {
    }

    public function index(): Response
    {
        return Inertia::render('Student/Courses/Index', []);
    }

    public function show($slug): Response
    {
        $student = auth()->user()->student;
        $course = Course::where('slug', $slug)->with('topics')->first();
        $enrolled = StudentCourse::where(['course_id' => $course->id, 'student_id' => $student->id])->exists();
        $course->enrolled = $enrolled;
        $topics = $course->topics->where('status', 1);
        $topics = array_values($topics->toArray());
        foreach ($topics as &$topic) {
            $topic['assessments'] = Assessment::where('after_topic_id', $topic['id'])->where('status', 1)->get();
        }

        return Inertia::render('Student/Courses/Show', [
            'course' => $course,
            'topics' => $topics,
        ]);
    }

    public function start(Course $course)
    {
        $user = auth()->user();

        $topic = Topic::where('course_id', $course->id)->orderBy('id')->first();

        $studentCourse = StudentCourse::create([
            'student_id' => $user->student->id,
            'course_id' => $course->id,
            'topic_id' => $topic ? $topic->id : null,
            'page_number' => 0,
        ]);

        // Create student course topic
        foreach ($course?->topics as $topic) {
            StudentCourseTopic::create([
                'student_course_id' => $studentCourse->id,
                'topic_id' => $topic->id,
                'status' => $topic->status,
            ]);
        }

        return redirect()->route('studentCourses.show', $course->slug)->with([
            'success' => [
                'header' => 'Successfully enrolled for ' . $course->name,
                'message' => '',
            ]
        ]);

    }

    public function getDataTable(Request $request)
    {
        return $this->courseService->getDataTable($request);
    }
}
