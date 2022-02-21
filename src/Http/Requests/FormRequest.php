<?php

namespace TypiCMS\Modules\News\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'image_id' => 'nullable|integer',
            'title.*' => 'nullable|max:255',
            'slug.*' => 'nullable|alpha_dash|max:255|required_if:status.*,1|required_with:title.*',
            'status.*' => 'boolean',
            'summary.*' => 'nullable',
            'body.*' => 'nullable',

            'category_id' => 'integer',
            //meta
            'meta_title.*'=>'nullable',
            'meta_keywords.*'=>'nullable',
            'meta_description.*'=>'nullable',

            //date
            'show_date' => 'required|date_format:Y-m-d',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
            'no_end_date'=>'boolean',
        ];
    }
}
