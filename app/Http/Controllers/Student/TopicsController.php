<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentCourse;
use App\Models\StudentCourseTopic;
use App\Models\Topic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TopicsController extends Controller
{
    public function show($slug): Response
    {
        $student = auth()->user()->student;
        $topic = Topic::where('slug', $slug)->with('course')->first();
        $studentCourse = StudentCourse::where(['course_id' => $topic->course->id, 'student_id' => $student->id])->first();
        $topic->course->enrolled = (bool)$studentCourse;
        $topic->course->student_course_id = $studentCourse ? $studentCourse->id : null;
        $topic->course->show_route = $studentCourse ? route('studentCourses.show', $topic->course->slug) : route('courses.show', $topic->course->slug);
        $topic->completed = false;
        $next_topic = Topic::where('course_id', $topic->course->id)
            ->where('id', '>', $topic->id)
            ->where('status', 1)
            ->orderBy('id')
            ->first();

        $topic->next_topic_route = null;
        if($next_topic) {
            $topic->next_topic_route = route('topics.show', $next_topic->slug);
        }

        $assessment = $topic->assessments()->where('status', 1)->orderBy('id')->first();
        if($assessment) {
            $topic->next_topic_route = route('assessment.show', $assessment->id);
        }

        if($studentCourse) {
            $studentCourseTopic = StudentCourseTopic::where(['student_course_id' => $studentCourse->id, 'topic_id' => $topic->id])->first();
            $topic->completed = (bool) $studentCourseTopic?->completed_at;
        }

        return Inertia::render('Student/Topic/Show', [
           'topic' => $topic
        ]);
    }

    function markAsComplete(StudentCourse $studentCourse, Topic $topic)
    {
        $studentCourse->page_number = $studentCourse->page_number + 1;
        $studentCourse->save();

        $studentCourseTopic = StudentCourseTopic::where(['student_course_id' => $studentCourse->id, 'topic_id' => $topic->id])->first();
        $studentCourseTopic->completed_at = Carbon::now();
        $studentCourseTopic->save();

        // Mark course as completed if all topics are completed
        $count = StudentCourseTopic::where(['student_course_id' => $studentCourse->id, 'status' => 1])->count();
        if($count === $studentCourse->page_number) {
            $studentCourse->completed_at = Carbon::now();
            $studentCourse->save();
        }


        return redirect()->back()->with([
            'success' => [
                'header' => 'Mark as completed!',
                'message' => '',
            ]
        ]);
    }

    public function getDataTable(Request $request)
    {
        $course_id = $request->input('course_id');
        $query = Topic::query()->select('topics.*', 'users.name as createdBy')->where('course_id', $course_id)
            ->join('users', 'users.id', '=', 'topics.created_by');

        // Apply search
        if ($request && $request->has('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        if ($request && $request->has('sort_column') && $request->has('sort_direction')) {
            $query->orderBy($request->input('sort_column'), $request->input('sort_direction'));
        }

        $topics = $query->paginate(10);
        return $topics;
    }
}
