<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Course;
use App\Models\StudentCourse;
use App\Models\StudentCourseTopic;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class TopicsController extends Controller
{
    public function store(StoreTopicRequest $request)
    {
        // Create a new Course instance and save it to the database
        DB::beginTransaction();
        $topic = Topic::create([
            'title' => $request['title'],
            'course_id' => $request['course_id'],
            'created_by' => auth()->user()->id,
            'slug' => Str::slug($request['title']),
        ]);

        $course = Course::find($request['course_id']);

        // Store on student course topic
        StudentCourse::where('course_id', $course->id)->get()->map(function ($studentCourse) use ($topic) {
            StudentCourseTopic::create([
                'student_course_id' => $studentCourse->id,
                'topic_id' => $topic->id,
                'status' => 0,
            ]);
        });

        DB::commit();

        return redirect()->route('admin.courses.show', $course->slug)->with([
            'success' => [
                'header' => 'Topic created successfully!',
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

    public function edit($slug)
    {
        $topic = Topic::where('slug', $slug)->first();
        $course = Course::find($topic->course_id);
        return Inertia::render('Admin/Topic/Edit', [
            'topic' => $topic,
            'course' => $course
        ]);
    }

    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        $input = $request->all();
        $topic->content = $input['content'];
        $topic->save();

        $course = Course::find($topic['course_id']);

        return redirect()->route('admin.courses.show', $course->slug)->with([
            'success' => [
                'header' => 'Topic updated successfully!',
                'message' => '',
            ]
        ]);
    }

    public function toggleStatus(Topic $topic)
    {
        DB::beginTransaction();
        $topic->toggleStatus();
        $header = 'Topic set to inactive status';

        // Toggle status on Student course topics
        StudentCourseTopic::where('topic_id', $topic->id)->get()->map(function ($studentCourseTopic) use ($topic) {
           $studentCourseTopic->status = $topic->status;
           $studentCourseTopic->save();

           $studentCourse = $studentCourseTopic->studentCourse;
           if($topic->status === 1 && !$studentCourseTopic->completed_at) {
               $studentCourse->completed_at = null;
               $studentCourse->save();
           }
        });

        if ($topic->status == 1) {
            $header = 'Topic set to active status';
        }

        $course = Course::find($topic['course_id']);
        DB::commit();
        return redirect()->route('admin.courses.show', $course->slug)->with([
            'success' => [
                'header' => $header,
                'message' => '',
            ]
        ]);
    }

    public function delete($id)
    {
        $topic = Topic::find($id);

        if ($topic) {
            $student_course_topics = StudentCourseTopic::where('topic_id', $topic->id)->get();

            foreach ($student_course_topics as $key => $student_course_topic) {
                $student_course_topic->delete();
            }

            $nextActiveTopic = Topic::where('course_id', $topic->course_id)
                ->where('id', '>', $id)
                ->where('status', 1)
                ->orderBy('id', 'asc')
                ->first();
            
            // Update all current student topics to next topic if this topic is deleted
            if ($nextActiveTopic) {
                StudentCourse::where('topic_id', $id)
                ->update(['topic_id', $nextActiveTopic->id]);
            }
            

            $topic->delete();
        }

        $course = Course::find($topic['course_id']);

        return redirect()->route('admin.courses.show', $course->slug)->with([
            'success' => [
                'header' => 'Topic deleted successfully',
                'message' => '',
            ]
        ]);
    }
   
}
