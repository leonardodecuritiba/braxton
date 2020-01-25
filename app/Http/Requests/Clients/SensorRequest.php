<?php

namespace App\Http\Requests\Clients;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SensorRequest extends FormRequest {
	private $table = 'sensors';

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		if ( $this->sensor != null ) {
			return Auth::user()->isMySensor( $this->sensor );
		}
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		switch ( $this->method() ) {
			case 'GET':
			case 'DELETE':
				{
					return [];
				}
			case 'POST':
				{
					return [
						'name'          => 'required|min:3|max:200',
						'sensor_type_id'    => 'required|exists:sensor_types,id'
					];
				}
			case 'PUT':
			case 'PATCH':
				{
					return [
						'name'    => 'required|min:3|max:200',
						'sensor_type_id'    => 'required|exists:sensor_types,id'
					];

				}
			default:
				break;
		}
	}
}

