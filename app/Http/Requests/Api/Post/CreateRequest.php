<?php

namespace App\Http\Requests\Api\Post;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'message' => [ 'required', 'string', 'min:2', 'max:3000' ]
        ];
    }

    public function validated()
    {
        $validated = parent::validated();
        $validated['user_id'] = Auth::id();
        return $validated;
    }
}
