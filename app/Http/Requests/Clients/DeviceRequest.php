<?php

namespace App\Http\Requests\Clients;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeviceRequest extends FormRequest {
	private $table = 'devices';

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		if ( $this->device != null ) {
			return Auth::user()->isMyDevice( $this->device );
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
						'name'    => 'required|min:3|max:200|unique:' . $this->table,
						'content' => 'required|min:3|max:500'
					];
				}
			case 'PUT':
			case 'PATCH':
				{
					return [
						'name'    => 'required|min:3|max:200|unique:' . $this->table . ',name,' . $this->device . ',id',
						'content' => 'required|min:3|max:500'
					];

				}
			default:
				break;
		}
	}
}

