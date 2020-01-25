<?php

namespace App\Http\Requests\Clients;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Redirect;

class ClientRequest extends FormRequest
{
    private $table = 'clients';

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

//    	$this->transformIsentionIe();
        /*
        contact_id
        address_id
        type
        */
        if ($this->get('type')) {
            $rules = [
//                'cnpj'         => 'required|min:3|max:20|unique:' . $this->table . ',cnpj',
//                'ie'           => $this->get('isention_ie') ? '' : 'required|min:3|max:20|unique:' . $this->table . ',ie',
                'fantasy_name' => 'required|min:3|max:100',
                'company_name' => 'required|min:3|max:100',
//				'foundation'    => 'date_format:"dmY"',
            ];
            //juridica

        } else {
            //fisica
            $rules = [
//                'cpf' => 'required|min:3|max:20|unique:' . $this->table . ',cpf',
//                'rg' => 'required|min:3|max:20|unique:' . $this->table . ',rg',
                'name' => 'required|min:3|max:100',
                'sex' => 'required',
//                'birthday' => 'required|date_format:"dmY"',
            ];
        }
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
	                $rules['email'] = 'required|min:3|max:100|unique:users,email,' . $this->client->user_id . ',id';
//                    if ($this->get('type')) {
//                        $rules['cnpj'] = 'required|min:3|max:20|unique:' . $this->table . ',cnpj,' . $this->client->id . ',id';
//                        $rules['ie'] = $this->get('isention_ie') ? '' : 'required|min:3|max:20|unique:' . $this->table . ',ie,' . $this->client->id . ',id';
//                        //juridica
//
//                    } else {
//                        //fisica
//                        $rules['cpf'] = 'required|min:3|max:20|unique:' . $this->table . ',cpf,' . $this->client->id . ',id';
//                        $rules['rg'] = 'required|min:3|max:20|unique:' . $this->table . ',rg,' . $this->client->id . ',id';
//                    }
                    return $rules;
                }
            default:
                break;
        }
    }

    /**
     * Get the response that handle the request errors.
     *
     */
//    public function transformIsentionIe()
//    {
//	    $this->merge(['isention_ie' => $this->has('isention_ie')]);
//    }

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

