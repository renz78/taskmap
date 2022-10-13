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
            'lat' => 'required|min:-90|max:90|numeric',
            'lng' => 'required|min:-180|max:180|numeric',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Поле назва обов`язкове',
            'lat.required' => 'Поле latitude обов`язкове',
            'lng.required' => 'Поле longitude обов`язкове',
        ];   
    }
}
