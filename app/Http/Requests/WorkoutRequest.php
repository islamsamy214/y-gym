<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkoutRequest extends FormRequest
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
        $regex = '/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/';
        return [
            'name' => 'required|max:100',
            'muscle'=>'required|max:100',
            'image'=>'image|max:1024',
            'ytb_link'=>['required','regex:'.$regex],
            'equipment_type'=>'max:1000',
            'level'=>'max:100',
            'exercise_type'=>'max:1000'
        ];
    }
}
