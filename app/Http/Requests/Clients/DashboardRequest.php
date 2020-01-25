<?php

namespace App\Http\Requests\Clients;

use App\Models\Clients\SubClient;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class DashboardRequest extends FormRequest
{
    private $table = 'dashboards';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
	    if ( $this->dashboard != null ) {
		    return Auth::user()->isMyDashboard( $this->dashboard );
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
	        'period'          => 'required|numeric|between:0,4',
	        'color'          => 'required',
	        'bullet'          => 'required|numeric|between:0,4',
	        'format'          => 'required|numeric|between:0,3',
        ];

        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
	                $rules['sensor_id'] = 'required|exists:sensors,id';
                    return $rules;
                }
            case 'PUT':
            case 'PATCH':
                {
                    return $rules;
                }
            default:
                break;
        }
    }
}

