<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Redirect;

class AthleteCreateRequest extends FormRequest
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
            'date' => 'required|date',
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
            //dd($errors["time"][0]);
            
            // throw new HttpResponseException(
            //     response()->json(['errors' => $errors], 422)
            // );
            //return Redirect::back()->withErrors($validator);
            return Redirect::back()->with(['msg_error' => ""]);

        }
    }
}
