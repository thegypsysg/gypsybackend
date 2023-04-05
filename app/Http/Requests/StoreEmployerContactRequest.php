<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployerContactRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'position_held' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'email_id' => ['required', 'string'],
            'employer_id' => ['required', 'numeric', 'exists:employer_master,employer_id'],
        ];
    }
}
