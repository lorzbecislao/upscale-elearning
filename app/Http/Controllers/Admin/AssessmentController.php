<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssessmentRequest;
use App\Http\Requests\UpdateAssessmentRequest;
use App\Models\Assessment;
use App\Models\Course;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Inertia\Inertia;

class AssessmentController extends Controller
{
    public function index()
    {
        $courses = Course::all()->map(function ($course) {
            return [
                'id' => $course->id,
                'name' => $course->name,
                'label' => $course->name,
                'value' => $course->id
                
            ];
        })->toArray();

        return Inertia::render('Admin/Assessment/Index', [
            'courses' => $courses
        ]);
    }

    public function store(StoreAssessmentRequest $request)
    {
        // Create a new Assessment instance and save it to the database
        $assessment = Assessment::create([
            'title' => $request['title'],
            'instruction' => $request['instruction'],
            'course_id' => $request['course_id'],
            'after_topic_id' => $request['topic_id'],
            'created_by' => auth()->user()->id,
            'type' => $request['type']
        ]);

        return redirect()->back()->with([
            'success' => [
                'header' => 'Topic created successfully!',
                'message' => '',
            ]
        ]);
    }

    public function getDataTable(Request $request)
    {
        $query = Assessment::with(['option', 'course', 'afterTopic']);

        // Apply search
        if ($request && $request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($subQuery) use ($searchTerm) {
                $subQuery->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('course', function ($courseQuery) use ($searchTerm) {
                        $courseQuery->where('name', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('afterTopic', function ($topicQuery) use ($searchTerm) {
                        $topicQuery->where('title', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        if ($request && $request->has('sort_column') && $request->has('sort_direction')) {
            $query->orderBy($request->input('sort_column'), $request->input('sort_direction'));
        }

        $assessments = $query->paginate(10);
        return $assessments;
    }

    public function getTopicsByCourse($id)
    {
        return Topic::where('course_id', $id)->get()->map(function ($topic) {
            return [
                'id' => $topic->id,
                'name' => $topic->title,
                'label' => $topic->title,
                'value' => $topic->id
            ];
        })->toArray();
    }

    public function create()
    {
        return Inertia::render('Admin/Assessment/Create', [
        ]);
    }

    public function delete($id)
    {
        $assessment = Assessment::find($id);
        if ($assessment) {
            $assessment->delete();
        }

        return redirect()->route('admin.assessments')->with([
            'success' => [
                'header' => 'Assessment deleted successfully!',
                'message' => '',
            ]
        ]);
    }

    public function update(UpdateAssessmentRequest $request, $id)
    {
        DB::beginTransaction();
    
        $assessment = Assessment::find($id);

        $assessment->title = $request['title'];
        $assessment->instruction = $request['instruction'];
        $assessment->course_id = $request['course_id'];
        $assessment->after_topic_id = $request['topic_id'];
        $assessment->type = $request['type'];
        $assessment->save();

        DB::commit();
        return redirect()->route('admin.assessments')->with([
            'success' => [
                'header' => 'Assessment updated successfully!',
                'message' => '',
            ]
        ]);
    }

    public function toggleStatus(Assessment $assessment)
    {
        $assessment->toggleStatus();
        $header = 'Assessment set to inactive status';

        if ($assessment->status == 1) {
            $header = 'Assessment set to active status';
        }

        return redirect()->route('admin.assessments')->with([
            'success' => [
                'header' => $header,
                'message' => '',
            ]
        ]);
    }

    public function show($id)
    {
        $assessment = Assessment::where('id', $id)->with(['option', 'course', 'afterTopic'])->first();

        return Inertia::render('Admin/Assessment/Show', [
            'assessment' => $assessment
        ]);
    }

    public function updatePracticalContent($id, Request $request)
    {
        $input = $request->all();
        $assessment = Assessment::find($id);
        $assessment->content = $input['content'];
        $assessment->save();

        return redirect()->back()->with([
            'success' => [
                'header' => 'Assessment updated successfully!',
                'message' => '',
            ]
        ]);
    }
}
