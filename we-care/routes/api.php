<?php

use App\Http\Controllers\AnswersController;
use App\Http\Controllers\TestExamsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//////  /api/v1/auth/login
/////   /api/v1/answers/submit


Route::prefix('/v1')->group(function () {


    //==================== Auth Routes
    Route::prefix('/auth')->group(function () {
        Route::post("/sign-up", [UsersController::class, "create"]);
        Route::post("/login", [UsersController::class, "login"]);


        Route::middleware('auth:sanctum')->get('/me', [UsersController::class, "getMyself"]);
        Route::middleware('auth:sanctum')->delete("/logout", [UsersController::class, "logout"]);
    });

    //====================


    //==================== Test Exams Routes
    Route::middleware('auth:sanctum')->prefix("test-exams")->group(function () {
        Route::get("/", [TestExamsController::class, "getAll"]);
        Route::get("/{test_exam_order}", [TestExamsController::class, "getTestExamDetails"]);
        Route::post("/", [TestExamsController::class, "create"]); //FIXME: this is a dev only route
    });
    //====================



    //==================== Answers Routes

    Route::middleware('auth:sanctum')->prefix("answers")->group(function () {
        Route::post("/submit", [AnswersController::class, "submit"]);
        Route::get("/get-my-answers", [AnswersController::class, "getMyAnswers"]);
    });

    //====================


});
