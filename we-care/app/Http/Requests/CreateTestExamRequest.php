<?php

namespace App\Http\Requests;


class CreateTestExamRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return  [
            'name' => 'required|unique:test_exams',
            'order' => 'required|integer|min:1|unique:test_exams',
            'questions' => 'present|array'
        ];
    }
    public function messages()
    {
        return [
            'order.unique' => 'Test exam order is taken',
        ];
    }
}
