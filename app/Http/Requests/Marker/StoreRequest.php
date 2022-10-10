<?php

namespace App\Http\Requests\Marker;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'nullable|string',
            'latitude' => 'required|min:4',
            'longitude' => 'required|min:4',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Поле назва обов`язкове',
            'latitude.required' => 'Поле latitude обов`язкове',
            'longitude.required' => 'Поле longitude обов`язкове',
        ];   
    }
}
