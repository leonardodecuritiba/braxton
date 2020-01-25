<?php

namespace App\Http\Requests\Commons;

use App\Models\Clients\SubClient;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SensorTypeRequest extends FormRequest
{
    private $table = 'sensor_types';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
	    if ( $this->sensor_type != null ) {
		    return Auth::user()->hasRole('admin');
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
	        'code'          => 'required|between:1,20|unique:'.$this->table.',code',
	        'description'   => 'required|between:3,200',
	        'scale'         => 'required|between:1,20',
	        'scale_name'    => 'required|between:3,20',
	        'type'          => 'required|numeric|between:0,1',
	        'range.*'       => 'required|numeric',
        ];

//        dd($this->all());

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
                    $rules['code'] = 'required|between:1,20|unique:'.$this->table.',code,'. $this->sensor_type . ',id';
                    return $rules;
                }
            default:
                break;
        }
    }
}

