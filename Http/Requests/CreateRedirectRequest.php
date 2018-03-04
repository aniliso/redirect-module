<?php

namespace Modules\Redirect\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateRedirectRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'from'   => 'required|different:to',
            'to'     => 'required|different:from',
            'status' => 'required|numeric|digits_between:3,3'
        ];
    }

    public function attributes()
    {
        return trans('redirect::redirects.form');
    }

    public function translationRules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

    public function translationMessages()
    {
        return [];
    }
}
