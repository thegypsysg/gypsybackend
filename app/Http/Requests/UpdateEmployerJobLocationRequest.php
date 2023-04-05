<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployerJobLocationRequest extends FormRequest
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
            'country_id' => ['required', 'string', 'exists:country_master,country_name'],
            'city_id' => ['required', 'string', 'exists:city_master,city_name'],
            'town_id' => ['required', 'string', 'exists:town_master,town_name'],
            'zone_id' => ['required', 'string', 'exists:zone_master,name'],
            'employer_id' => ['required', 'string', 'exists:employer_master,employer_id'],
        ];
    }
}
