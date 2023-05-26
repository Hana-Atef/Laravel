<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitAnswerRequest;
use App\Models\Answer;
use App\Models\TestExam;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    //

    function submit(SubmitAnswerRequest $request)
    {


        $testExamId = $request->input("test_exam_id");
        $userId = $request->user()->id;

        //check if the user answer this exam before or not

        $answer = Answer::where("test_exam_id", $testExamId)->where("user_id", $userId)->first();
        if ($answer) {
            return Response::json([
                "success" => "false",
                "message" => "you answered this before"
            ], 401);
        }

        // make sure the exam is in the db
        $exam = TestExam::find($testExamId);

        if (!$exam)
            return Response::json([
                "success" => "false",
                "message" => "no exam found"
            ], 404);

        $score = 0;
        $answers_map = $request->input("answers_map");



        foreach ($answers_map as $qId => $qV) {
            $score += $qV;
        }


        return Answer::create([
            "user_id" => $userId,
            "test_exam_id" => $testExamId,
            "answers_map" => json_encode($answers_map),
            "score" => $score
        ]);
    }

    function getMyAnswers(Request $request)
    {
        $userId = $request->user()->id;
        return Answer::where("user_id", $userId)->get();
    }
}
