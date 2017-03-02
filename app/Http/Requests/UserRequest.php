<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;

class UserRequest extends FormRequest
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
        $user = User::find($this->user);
        switch($this->method())
        {
            case 'DELETE':
            {
                return [];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'       => 'required',
                    'email'      => 'required|email|unique:users,email,'.$user->id,
                    'photo'      => 'image|mimes:jpeg,bmp,png'
                ];
            }
            default:break;
        }
    }
}
