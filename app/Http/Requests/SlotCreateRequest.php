<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Redirect;

class SlotCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'time1' => 'required|date_format:H:i',
            'time2' => 'required|date_format:H:i|after:time1',
            'date' => ['required','regex:/^[1-4]\d{3}\-((0[1-6]\-((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/'],
        ];
    }
    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return \Illuminate\Http\JsonResponse
     */
    public function withValidator($validator)
    {

        if ($validator->fails()) {
            $errors = (new ValidationException($validator))->errors();
            return Redirect::back()->with(['msg_error' => ""]);

        }
    }
}
