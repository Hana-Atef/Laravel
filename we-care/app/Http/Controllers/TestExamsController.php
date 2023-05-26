<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTestExamRequest;
use App\Models\Question;
use App\Models\TestExam;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class TestExamsController extends Controller
{
    //
    function getTestExamDetails(Request $request, $test_exam_order)
    {
        $examWithQuestions = TestExam::where('order', $test_exam_order)
            ->with(array('questions' => function ($query) {
                $query->select('id', 'text', "test_exam_id");
            }))
            ->first();

        if (!$examWithQuestions)
            return Response::json([
                "success" => "false",
                "message" => "no exam found"
            ], 404);

        return $examWithQuestions;
    }

    function getAll()
    {
        return TestExam::all();
    }

    function create(CreateTestExamRequest $request)
    {

        $createdExam = TestExam::create([
            'name' => $request->input('name'),
            'order' => $request->input('order'),
        ]);

        $saved_questions = array();

        $questions = $request->input("questions");
        foreach ($questions as $question_label) {
            array_push($saved_questions, [
                "test_exam_id" => $createdExam->id,
                'text' => $question_label
            ]);
        }
        Question::insert($saved_questions);

        return $createdExam;
    }
}
