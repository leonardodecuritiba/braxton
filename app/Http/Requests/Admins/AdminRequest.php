<?php

namespace App\Http\Requests\Admins;

use App\Models\Admins\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Redirect;

class AdminRequest extends FormRequest
{
    private $table = 'admins';

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

	    $rules['username'] = 'required|min:3|max:100';

        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
	                $rules['email'] = 'required|min:3|max:100|unique:users';
                    return $rules;
                }
            case 'PUT':
            case 'PATCH':
                {
	                $rules['email'] = 'required|min:3|max:100|unique:users,email,' . Admin::find($this->admin)->user_id . ',id';
                    return $rules;
                }
            default:
                break;
        }
    }


    /**
     * Get the response that handle the request errors.
     *
     * @param  array $errors
     * @return array
     */
    public function response(array $errors)
    {
        return Redirect::back()->withErrors($errors)->withInput();
    }
}

