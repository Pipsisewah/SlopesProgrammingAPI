<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateFeatureRequest extends FormRequest
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
            'name' => 'required|max:100',
            'description' => 'required|max:255',
            'project' => 'required|exists:projects,id',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date',
            'tags' => 'sometimes|array',
            'tags.*' => 'sometimes|exists:tags,id',
        ];
    }
}
