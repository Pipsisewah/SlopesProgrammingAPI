<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEducationRequest extends FormRequest
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
            'institution' => 'required|max:254',
            'area' => 'required|max:254',
            'study_type' => 'required|max:254',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date',
            'gpa' => 'sometimes|numeric',
        ];
    }
}
