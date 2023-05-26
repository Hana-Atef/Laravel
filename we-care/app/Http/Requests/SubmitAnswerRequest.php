<?php

namespace App\Http\Requests;


class SubmitAnswerRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return  [
            'test_exam_id' => 'required',
            'answers_map' => 'present|array',
        ];
    }
}
