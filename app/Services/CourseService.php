<?php

namespace App\Services;

use App\Models\Course;
use App\Models\StudentCourse;
use Carbon\Carbon;
use Illuminate\Support\Str;


class CourseService
{
    public function store($data)
    {

    }

    public function getAll(): array
    {
        return Course::all()->map(function ($course) {
            return [
                'id' => $course->id,
                'name' => $course->name,
                'description' => $course->description,
                'code' => $course->code,
                'image' => $course->image_url
            ];
        })->toArray();
    }

    public function getMyCourses($student): array
    {
        return StudentCourse::where('student_id', $student->id)->get()->map(function ($studentCourse) {
            return [
                'id' => $studentCourse->course->id,
                'slug' => $studentCourse->course->slug,
                'name' => $studentCourse->course->name,
                'description' => $studentCourse->course->description,
                'code' => $studentCourse->course->code,
                'image' => $studentCourse->course->image_url,
                'page_number' => $studentCourse->studentCourseTopics()->where('status', 1)->whereNotNull('completed_at')->count(),
                'completed_at' => $studentCourse->completed_at,
                'topic_total' => $studentCourse->studentCourseTopics()->where('status', 1)->count(),
                'show_route' => route('studentCourses.show', $studentCourse->course->slug),
                'created_at' => Carbon::parse($studentCourse->created_at)->format('M d, Y')
            ];
        })->toArray();
    }

    public function getMyCoursesStatus($student, $status): array
    {

        // ->where('status', 1)->with('topic')->get()->map(

        return StudentCourse::where('student_id', $student->id)->when($status === 'ongoing', function ($query) {
            $query->whereNull('completed_at');
        })->when($status === 'completed', function ($query) {
            $query->whereNotNull('completed_at');
        })->get()->map(function ($studentCourse) {
            return [
                'id' => $studentCourse->course->id,
                'name' => $studentCourse->course->name,
                'description' => $studentCourse->course->description,
                'code' => $studentCourse->course->code,
                'image' => $studentCourse->course->image_url,
                'page_number' => $studentCourse->studentCourseTopics()->where('status', 1)->whereNotNull('completed_at')->count(),
                'completed_at' => $studentCourse->completed_at,
                'topic_total' => $studentCourse->studentCourseTopics()->where('status', 1)->count(),
                'show_route' => $studentCourse->completed_at ? route('studentCourses.show', $studentCourse->course->slug) : route('topics.show', $studentCourse->topic?->slug),
                'created_at' => Carbon::parse($studentCourse->created_at)->format('M d, Y')
            ];
        })->toArray();
    }

    public function getDataTable($request)
    {
        if ($request->has('status') && $request->input('status')) {
            $query = Course::where('status', 1)->with(['topics', 'assessments']);
        } else {
            $query = Course::with(['topics', 'assessments']);
        }

        // Apply search
        if ($request && $request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%')
                ->orWhere('code', 'like', '%' . $request->input('search') . '%');
        }

        if ($request && $request->has('sort_column') && $request->has('sort_direction')) {
            $query->orderBy($request->input('sort_column'), $request->input('sort_direction'));
        }

        // Load related topics
        $query->with('topics');


        $courses = $query->paginate(10);
        return $courses;
    }
}
