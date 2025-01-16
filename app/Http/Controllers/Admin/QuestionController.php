<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Assessment;
use App\Models\AssessmentOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function store(StoreQuestionRequest $request)
    {
        $question = AssessmentOption::create([
            'assessment_id' => $request['assessment_id'],
            'question' => $request['question'],
            'option_a' => $request['option_a'],
            'option_b' => $request['option_b'],
            'option_c' => $request['option_c'],
            'option_d' => $request['option_d'],
            'answer' => $request['answer']
        ]);

        $assessment = Assessment::find($request['assessment_id']);

        return redirect()->route('admin.assessments.show', $assessment->id)->with([
            'success' => [
                'header' => 'Assessment question added successfully!',
                'message' => '',
            ]
        ]);
    }

    public function getDataTable(Request $request)
    {
        $assessment_id = $request->input('assessment_id');
        $query = AssessmentOption::where('deleted_at', null)->where('assessment_id', $assessment_id);

        // Apply search
        if ($request && $request->has('search')) {
            $query->where('question', 'like', '%' . $request->input('search') . '%')
                ->orWhere('option_a', 'like', '%' . $request->input('search') . '%');
        }

        if ($request && $request->has('sort_column') && $request->has('sort_direction')) {
            $query->orderBy($request->input('sort_column'), $request->input('sort_direction'));
        }

        $questions = $query->paginate(10);
        return $questions;
    }

    public function delete($id)
    {
        $question = AssessmentOption::find($id);
        $assessment = Assessment::find($question->assessment_id);
        if ($question) {
            $question->delete();
        }

        return redirect()->route('admin.assessments.show', $assessment->id)->with([
            'success' => [
                'header' => 'Question deleted successfully!',
                'message' => '',
            ]
        ]);
    }

    public function update(UpdateQuestionRequest $request, $id)
    {
        DB::beginTransaction();
        
        $question = AssessmentOption::find($id);
        $assessment = Assessment::find($question->assessment_id);

        $question->question = $request['question'];
        $question->option_a = $request['option_a'];
        $question->option_b = $request['option_b'];
        $question->option_c = $request['option_c'];
        $question->option_d = $request['option_d'];
        $question->answer = $request['answer'];
        $question->save();

        DB::commit();
        return redirect()->route('admin.assessments.show', $assessment->id)->with([
            'success' => [
                'header' => 'Question updated successfully!',
                'message' => '',
            ]
        ]);
    }
}
