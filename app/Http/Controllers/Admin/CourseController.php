<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function __construct(
        private CourseService $courseService,
    ) {
    }

    public function index()
    {
        return Inertia::render('Admin/Courses/Index', [
        ]);
    }

    public function show($slug)
    {
        $course = Course::where('slug', $slug)->with('topics')->first();
     
        return Inertia::render('Admin/Courses/Show', [
            'course' => $course
        ]);
    }

    public function getDataTable(Request $request)
    {
        $query = Course::with(['topics', 'assessments']);

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

    public function store(StoreCourseRequest $request)
    {
        DB::beginTransaction();
        // Create a new Course instance and save it to the database
        $storagePath = $request->file('image')->store('images', 'public');
        $filePath = Storage::url($storagePath);

        $course = Course::create([
            'name' => $request['name'],
            'code' => $request['code'],
            'description' => $request['description'],
            'slug' => Str::slug($request['name']),
            'image_url' => $filePath,
            'created_by' => auth()->user()->id
        ]);

        DB::commit();
        return redirect()->route('admin.courses')->with([
            'success' => [
                'header' => 'Course created successfully!',
                'message' => '',
            ]
        ]);
    }

    public function delete($id)
    {
        $course = Course::find($id);
        if ($course) {
            $course->delete();
        }

        return redirect()->route('admin.courses')->with([
            'success' => [
                'header' => 'Course deleted successfully!',
                'message' => '',
            ]
        ]);
    }

    public function toggleStatus(Course $course)
    {
        $course->toggleStatus();
        $header = 'Course set to inactive status';
        
        if ($course->status == 1) {
            $header = 'Course set to active status';
        } 

        return redirect()->route('admin.courses')->with([
            'success' => [
                'header' => $header,
                'message' => '',
            ]
        ]);
    }

    public function update(UpdateCourseRequest $request, $id)
    {
        DB::beginTransaction();

        $course = Course::find($id);

        if ($request->file('image')) {
            $storagePath = $request->file('image')->store('images', 'public');
            $filePath = Storage::url($storagePath);
            $course->image_url = $filePath;
        } 

        $course->name = $request['name'];
        $course->code = $request['code'];
        $course->description = $request['description'];
        $course->save();

        DB::commit();
        return redirect()->route('admin.courses')->with([
            'success' => [
                'header' => 'Course updated successfully!',
                'message' => '',
            ]
        ]);
    }
}
