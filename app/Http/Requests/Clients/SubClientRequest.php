<?php

namespace App\Http\Requests\Clients;

use App\Models\Clients\SubClient;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SubClientRequest extends FormRequest
{
    private $table = 'sub_clients';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
	    if ( $this->sub_client != null ) {
		    return Auth::user()->isMySubClient( $this->sub_client );
	    }
	    return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /*
        contact_id
        address_id
        type
        */
        $rules = [
//            'cpf' => 'required|min:3|max:20|unique:' . $this->table . ',cpf',
//            'rg' => 'required|min:3|max:20|unique:' . $this->table . ',rg',
//            'sex' => 'required',
//            'birthday' => 'required|date_format:"dmY"',

            'name' => 'required|min:3|max:100',
            'email' => 'required|min:3|max:100|unique:users,email',
        ];

        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    return $rules;
                }
            case 'PUT':
            case 'PATCH':
                {
                	$SubClient = SubClient::find($this->sub_client);
                    //sub_clients
//                    $rules['cpf'] = 'required|min:3|max:20|unique:' . $this->table . ',cpf,' . $SubClient->id . ',id';
//                    $rules['rg'] = 'required|min:3|max:20|unique:' . $this->table . ',rg,' . $SubClient->id . ',id';
                    $rules['email'] = 'required|min:3|max:100|unique:users,email,'. $SubClient->user_id .',id';
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

