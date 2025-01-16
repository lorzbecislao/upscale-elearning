<?php

namespace App\Http\Controllers;

use App\Jobs\SendCoursePurchasedNotificationJob;
use App\Models\Lesson;
use App\Notifications\CoursePurchasedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function __construct(
        // private LessonService $lessonService,
    ) {
    }

    public function index()
    {
        // $course = new Lesson();
        // $courses = $course->getLessons();
        // foreach ($courses as $course) {
        //     $course->description = json_decode($course->description);
        // }
     
        // return Inertia::render('CoursesPage', [
        //     'courses' => $courses->toArray()
        // ]);
    }

    // public function checkoutCourse(Lesson $lesson)
    // {
    //     return Inertia::render('CheckoutPage', [
    //         'course' => $lesson
    //     ]);
    // }

    // public function purchaseCourse(Lesson $lesson, Request $request)
    // {
    //     $input = $request->all();
    //     SendCoursePurchasedNotificationJob::dispatch($lesson, $input['email']);
    //     return redirect()->back();
    // }

    public function create()
    {
        return Inertia::render('CreateLesson', [
        ]);
    }

    public function store(Request $request)
    {
        // $this->lessonService->store($request->all());
    }

    // public function show($slug) 
    // {
    //     $lesson = Lesson::where('slug', $slug)->first();
    //     return Inertia::render('Lesson', [
    //         'lesson' => $lesson
    //     ]);
    // }
}
