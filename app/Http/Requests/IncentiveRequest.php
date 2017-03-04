<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncentiveRequest extends FormRequest
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
        $days = implode(array_keys(config('constants.days')), ',');

        return [
            'description' => 'required',
            'day' => "required|In:{$days}",
            'photo' => 'image|mimes:jpeg,bmp,png'
        ];
    }
}
