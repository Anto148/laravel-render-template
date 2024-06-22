<?php

namespace App\Http\Requests\AppConfiguration;

use App\Traits\Requests\Requestable;
use Illuminate\Foundation\Http\FormRequest;

class SearchAppConfigurationRequest extends FormRequest
{
    use Requestable;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "code" => "nullable|string|max:255",
        ];
    }
}
