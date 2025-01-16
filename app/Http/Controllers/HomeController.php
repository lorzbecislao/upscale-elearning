<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssessmentOption;
use App\Models\Course;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class HomeController extends Controller
{
    public function index() 
    {
        $courses = Course::where('status', 1)->get();

        return Inertia::render('Home', [
            'courses' => $courses
        ]);
    }

    public function showCourse($id): InertiaResponse 
    {
        $course = Course::find($id);
        $topics = $course->topics->where('status', 1);
        $topics = array_values($topics->toArray());
        foreach ($topics as &$topic) {
            $topic['assessments'] = Assessment::where('after_topic_id', $topic['id'])->where('status', 1)->get();
        }
        
        return Inertia::render('Student/TopicList', [
            'course' => $course,
            'topics' => $topics,
        ]);
    }

    public function showLesson($slug)
    {
        $topic = Topic::where('slug', $slug)->first();
       
        $assessment_topic = null;
        if ($topic->assessments) {
            foreach ($topic->assessments as $assessment) {
                $assessment_topic = $assessment;
            }
        }
       
        $nextTopic = Topic::where('id', '>', $topic->id)
            ->where('status', 1)
            ->orderBy('id')
            ->first();

        // Check if there are no more active topics with status 1 and no next topic available
        $isLastTopic = !$nextTopic;
        
        return Inertia::render('ViewTopic', [
            'topic' => $topic,
            'isLastTopic' => $isLastTopic,
            'nextTopic' => $nextTopic,
            'assessment' => $assessment_topic
        ]);
    }

    public function showAssessment($id)
    {
        $assessment = Assessment::find($id);
        $topic = Topic::find($assessment->after_topic_id);
        $topic->course = $topic->course;
        $topic->course->show_route = route('courses.show', $topic->course->slug);

        $nextTopic = Topic::where('id', '>', $topic->id)
            ->where('status', 1)
            ->orderBy('id')
            ->first();

        // Check if there are no more active topics with status 1 and no next topic available
        $isLastTopic = !$nextTopic;
        return Inertia::render('ViewAssessment', [
            'topic' => $topic,
            'isLastTopic' => $isLastTopic,
            'nextTopic' => $nextTopic,
            'assessment' => $assessment,
            'course_id' => $assessment->course_id
        ]);
       
    }

    public function startAssessment($id)
    {
        Session::forget('quiz_score');
        $assessment = Assessment::find($id);
        $question = $assessment->option()->whereNull('deleted_at')->first();

        Session::get('quiz_score', 0);
       
        if ($assessment->type == 1) {
            return redirect()->route('home.assessments.showPractical', $assessment->id);
        } else {
            return redirect()->route('home.assessments.show-question', [
                'assessment_id' => $assessment->id,
                'question_id' => $question->id
            ]);
        }
    }

    public function showQuestion($assessment_id, $question_id)
    {
        // If there's no next question, handle the end of the assessment
        $assessment = Assessment::find($assessment_id);
        $question = AssessmentOption::find($question_id);

        $nextQuestion = AssessmentOption::where('id', '>', $question->id)
            ->whereNull('deleted_at')
            ->where('assessment_id', $assessment->id)
            ->orderBy('id')
            ->first();

        $isLastQuestion = !$nextQuestion;

        return Inertia::render('QuizPage', [
            'question' => $question,
            'assessment' => $assessment,
            'course_id' => $assessment->course_id,
            'isLastQuestion' => $isLastQuestion
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
            return redirect()->route('home.assessments.result', $assessment->id);
        }
     
        return redirect()->route('home.assessments.show-question', [
            'assessment_id' => $assessment->id,
            'question_id' => $nextQuestion->id
        ]);

    }

    public function result($id)
    {
        $score = Session::get('quiz_score');
        Session::forget(['quiz_score']);
        $assessment = Assessment::find($id);

        $topic = Topic::find($assessment->after_topic_id);

        $nextTopic = Topic::where('id', '>', $topic->id)
            ->where('status', 1)
            ->orderBy('id')
            ->first();

        $no_of_items = AssessmentOption::where('assessment_id', $assessment->id)
            ->whereNull('deleted_at')
            ->count();

        return Inertia::render('QuizResult', [
            'assessment' => $assessment,
            'current_score' => $score,
            'course_id' => $assessment->course_id,
            'no_of_items' => $no_of_items,
            'nextTopic' => $nextTopic
        ]);

    }

    public function showPractical($id)
    {
        $assessment = Assessment::with(['course', 'afterTopic'])->find($id);

        $topic = Topic::find($assessment->after_topic_id);
        $topic->course = $topic->course;
        $topic->course->show_route = route('courses.show', $topic->course->slug);

        $nextTopic = Topic::where('id', '>', $topic->id)
            ->where('status', 1)
            ->orderBy('id')
            ->first();

        // Check if there are no more active topics with status 1 and no next topic available
        $isLastTopic = !$nextTopic;

        return Inertia::render('PracticalPage', [
            'assessment' => $assessment,
            'topic' => $topic,
            'isLastTopic' => $isLastTopic
        ]);
    }

}
