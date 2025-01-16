<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AssessmentResult;
use App\Models\Course;
use App\Models\StudentCourse;
use App\Services\CourseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StudentCourseController extends Controller
{
    public function __construct(
        private CourseService $courseService
    )
    {
    }

    public function index(): Response
    {
        $student = auth()->user()->student;

        return Inertia::render('Student/StudentCourses/Index', [
            'courses' => $this->courseService->getMyCourses($student),
            'ongoing' => $this->courseService->getMyCoursesStatus($student, 'ongoing'),
            'completed' => $this->courseService->getMyCoursesStatus($student, 'completed')
        ]);
    }

    public function show($slug): Response|RedirectResponse
    {
        $student = auth()->user()->student;
        $course = Course::where('slug', $slug)->first();
        $studentCourse = StudentCourse::where(['course_id' => $course->id, 'student_id' => $student->id])->first();
        if(!$studentCourse) {
            return redirect()->route('courses.show', $slug);
        }
        $studentCourseTopics = $studentCourse->studentCourseTopics()->where('status', 1)->with('topic')->get()->map(function ($studentCourseTopic) {
            $assessments = $studentCourseTopic->topic?->assessments()->where('status', 1)->get()->map(function ($assessment) {
                $result = AssessmentResult::where(['student_id' => auth()->user()->student->id, 'assessment_id' => $assessment->id])->first();
                return [
                    'id' => $assessment->id,
                    'title' => $assessment->title,
                    'content' => $assessment->content,
                    'instruction' => $assessment->instruction,
                    'after_topic_id' => $assessment->after_topic_id,
                    'course_id' => $assessment->course_id,
                    'type' => $assessment->type,
                    'status' => $assessment->status,
                    'completed' => (bool)$result,
                ];
            });

            // Use optional chaining for accessing topic properties
            return [
                'id' => $studentCourseTopic->id,
                'completed' => (bool)$studentCourseTopic->completed_at,
                'slug' => $studentCourseTopic->topic?->slug, // Use optional chaining here
                'title' => $studentCourseTopic->topic?->title, // Use optional chaining here
                'content' => $studentCourseTopic->topic?->content, // Use optional chaining here
                'assessments' => $assessments
            ];
        });


        return Inertia::render('Student/StudentCourses/Show', [
            'course' => $course,
            'topics' => $studentCourseTopics,
        ]);
    }
}
