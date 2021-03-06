<?php

namespace App\Http\Requests;

use App\Model\NewsletterCriterion;
use Illuminate\Foundation\Http\FormRequest;

class UnreadArticlesRequest extends FormRequest
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
            'timespan' => 'required|integer',
            'articles_count' => 'required|integer',
            'criteria.*' => 'required|string|in:' . NewsletterCriterion::allCriteriaConcatenated(),
            'user_ids.*' => 'required|integer',
            'ignore_authors.*' => 'string',
        ];
    }
}
