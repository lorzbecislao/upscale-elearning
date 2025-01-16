<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentOption;
use App\Models\AssessmentResult;
use App\Models\StudentCourse;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class AssessmentController extends Controller
{
    public function show(Assessment $assessment): Response
    {
        $student = auth()->user()->student;

        $topic = Topic::find($assessment->after_topic_id);
        $studentCourse = StudentCourse::where(['course_id' => $topic->course->id, 'student_id' => $student->id])->first();
        $topic->course->enrolled = (bool)$studentCourse;
        $topic->course->show_route = $studentCourse ? route('studentCourses.show', $topic->course->slug) : route('courses.show', $topic->course->slug);

        $next_topic = Topic::where('course_id', $topic->course->id)
            ->where('id', '>', $topic->id)
            ->where('status', 1)
            ->orderBy('id')
            ->first();

        $topic->next_topic_route = null;
        if ($next_topic) {
            $topic->next_topic_route = route('topics.show', $next_topic->slug);
        }

        $assessment->start = null;
        $question = $assessment->option->whereNull('deleted_at')->first();
        if ($question) {
            $assessment->start = route('assessment.showQuestion', [$assessment->id, $question->id]);
        }

        $result = AssessmentResult::where(['student_id' => $student->id, 'assessment_id' => $assessment->id])->first();
      
        $assessment->completed = (bool)$result;

        return Inertia::render('Student/Assessment/Show', [
            'assessment' => $assessment,
            'topic' => $topic
        ]);
    }

    public function startAssessment($id)
    {
        Session::forget('quiz_score');
        $assessment = Assessment::find($id);
        $question = $assessment->option()->whereNull('deleted_at')->first();
        Session::get('quiz_score', 0);

        // If practical
        if ($assessment->type == 1) {
            return redirect()->route('assessment.showPractical', $assessment->id);
        } else {
            return redirect()->route('assessment.showQuestion', [
                'assessment' => $assessment->id,
                'question' => $question->id
            ]);
        }
        
    }

    public function showPractical($id)
    {
        $student = auth()->user()->student;
        $assessment = Assessment::with(['course', 'afterTopic'])->find($id);
        $topic = Topic::find($assessment->after_topic_id);
        $topic->course = $topic->course;
        $studentCourse = StudentCourse::where(['course_id' => $topic->course->id, 'student_id' => $student->id])->first();
        $topic->course->enrolled = (bool)$studentCourse;
        $topic->course->show_route = $studentCourse ? route('studentCourses.show', $topic->course->slug) : route('courses.show', $topic->course->slug);
        $topic->course->student_course_id = $studentCourse->id;

        $result = AssessmentResult::where(['student_id' => $student->id, 'assessment_id' => $assessment->id])->first();

        $assessment->completed = (bool)$result;

        return Inertia::render('Student/Assessment/Practical', [
            'assessment' => $assessment,
            'topic' => $topic
        ]);
        
    }

    public function showQuestion(Assessment $assessment, AssessmentOption $question)
    {
        $student = auth()->user()->student;
        $nextQuestion = AssessmentOption::where('id', '>', $question->id)
            ->whereNull('deleted_at')
            ->where('assessment_id', $assessment->id)
            ->orderBy('id')
            ->first();

        $topic = Topic::find($assessment->after_topic_id);
        $studentCourse = StudentCourse::where(['course_id' => $topic->course->id, 'student_id' => $student->id])->first();
        $topic->course->show_route = $studentCourse ? route('studentCourses.show', $topic->course->slug) : route('courses.show', $topic->course->slug);

        $isLastQuestion = !$nextQuestion;
        return Inertia::render('Student/Assessment/Question', [
            'question' => $question,
            'assessment' => $assessment,
            'isLastQuestion' => $isLastQuestion,
            'topic' => $topic
        ]);
    }

    public function nextQuestion($id, Request $request)
    {
        $data = $request->all();
        $assessment = Assessment::find($data['assessment_id']);
        $currentQuestion = AssessmentOption::find($data['question_id']);

        // Initialize or retrieve the current score from the session
        if ($data['answer'] == $currentQuestion->answer) {
            $request->session()->increment('quiz_score');
        }

        $nextQuestion = AssessmentOption::where('id', '>', $currentQuestion->id)
            ->whereNull('deleted_at')
            ->where('assessment_id', $assessment->id)
            ->orderBy('id')
            ->first();

        if ($data['isLastQuestion']) {
            return redirect()->route('assessment.result', $assessment->id);
        }

        return redirect()->route('assessment.showQuestion', [
            'assessment' => $assessment->id,
            'question' => $nextQuestion->id
        ]);

    }

    public function result($id)
    {
        $student = auth()->user()->student;
        $score = Session::get('quiz_score');
        $assessment = Assessment::find($id);
        $topic = Topic::find($assessment->after_topic_id);
        $studentCourse = StudentCourse::where(['course_id' => $topic->course->id, 'student_id' => $student->id])->first();
        $topic->course->show_route = $studentCourse ? route('studentCourses.show', $topic->course->slug) : route('courses.show', $topic->course->slug);

        $nextTopic = Topic::where('id', '>', $topic->id)
            ->where('status', 1)
            ->orderBy('id')
            ->first();

        $topic->next_topic_route = null;
        if ($nextTopic) {
            $topic->next_topic_route = route('topics.show', $nextTopic->slug);
        }

        $no_of_items = AssessmentOption::where('assessment_id', $assessment->id)
            ->whereNull('deleted_at')
            ->count();

        // Create assessment result if
        $result = AssessmentResult::where(['student_id' => $student->id, 'assessment_id' => $assessment->id])->first();
        if ($studentCourse && !$result) {
            $result = AssessmentResult::create([
                'hash' => Hash::make($assessment->title),
                'student_id' => $student->id,
                'assessment_id' => $assessment->id,
                'score' => $score ?: 0,
                'total_items' => $no_of_items,
            ]);
        }
        Session::forget(['quiz_score']);
        return Inertia::render('Student/Assessment/Result', [
            'assessment' => $assessment,
            'course_id' => $assessment->course_id,
            'nextTopic' => $nextTopic,
            'result' => $result,
            'topic' => $topic,
        ]);

    }

    public function markPracticalCompleted($id)
    {
        $student = auth()->user()->student;
        $assessment = Assessment::find($id);
        $topic = Topic::find($assessment->after_topic_id);
        $topic->course = $topic->course;
        $studentCourse = StudentCourse::where(['course_id' => $topic->course->id, 'student_id' => $student->id])->first();
        $topic->course->enrolled = (bool)$studentCourse;
        $topic->course->show_route = $studentCourse ? route('studentCourses.show', $topic->course->slug) : route('courses.show', $topic->course->slug);
        $topic->course->student_course_id = $studentCourse->id;
        $result = AssessmentResult::where(['student_id' => $student->id, 'assessment_id' => $assessment->id])->first();
        if ($studentCourse && !$result) {
            $result = AssessmentResult::create([
                'hash' => Hash::make($assessment->title),
                'student_id' => $student->id,
                'assessment_id' => $assessment->id,
                'score' => null,
                'total_items' => null,
            ]);
        }

        return redirect()->back()->with([
            'success' => [
                'header' => 'Mark as completed!',
                'message' => '',
            ]
        ]);
    }
}
