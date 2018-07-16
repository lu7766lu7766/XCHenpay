<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'email' => 'required|email|unique:users,email',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'email' => 'required|unique:users,email,' . $this->user->id,
                    'password_confirm' => 'sometimes|same:password',
                    'pic_file' => 'image|mimes:jpg,jpeg,bmp,png|max:10000'
                ];
            }
            default:
                break;
        }

        return [

        ];
    }


}

