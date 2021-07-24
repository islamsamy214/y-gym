<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'title'=>'required|max:150',
            'content'=>'required|max:10000',
            'image'=>'image|max:1024',
            'video'=>'mimes:mp4,mov,ogg | max:20000',
            'copied_from'=>'max:500',
            'cat_id'=>'required',
        ];
    }
}
