<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployerRequest extends FormRequest
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
            'employer_name' => ['required', 'string', 'unique:employer_master,employer_name'],
            'hs_id' => ['required', 'string', 'exists:healthcare_settings,hs_id'],
            'country_id' => ['required', 'string', 'exists:country_master,country_id'],
            'city_id' => ['required', 'string', 'exists:city_master,city_id'],
            'town_id' => ['nullable', 'string', 'exists:town_master,town_id'],
        ];
    }
}
