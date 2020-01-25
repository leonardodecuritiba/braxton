<?php

namespace App\Http\Requests\Clients;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AlertRequest extends FormRequest {
	private $table = 'alerts';
	private $rules_;

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		if ( $this->alert != null ) {
			return Auth::user()->isMyAlert( $this->alert );
		}
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {

		//REGRAS
		$this->rules_ = [
			'alert_type'    => 'required|numeric|between:0,3',
			'name'          => 'required|min:3|max:200',
			'sensor_id'     => 'required|exists:sensors,id',
//			'main_email'    => 'required|email|min:3|max:100'
		];

		//check if send_email is checked
		$this->checkSendEmail();

		//check if copy_email is correct
		$this->checkCopyEmail();

		$this->checkAlertType();
//
//		dd($this->rules_);
//		dd($this->all());



		switch ( $this->method() ) {
			case 'GET':
			case 'DELETE':
				{
					return [];
				}
			case 'POST':
				{
					return $this->rules_;
				}
			case 'PUT':
			case 'PATCH':
				{
					return $this->rules_;

				}
			default:
				break;
		}
	}

	public function checkAlertType()
	{
		switch($this->get('alert_type')){
			case 2:
				$this->checkValue();
				break;
			case 3:
				$this->checkValue();
				return;
		}
	}

	public function checkValue()
	{
		$data = $this->all();
		if($this->get('alert_type') == 2){
			$this->rules_['time_inactive'] = 'required|numeric|between:1,60';
			$data['condition_values'] = $this->get('time_inactive');
		} else if($this->get('alert_type') == 3){
			$this->rules_['condition_type'] = 'required|numeric|between:0,7';
			if($this->get('condition_type') > 1){ //single value
				$data['condition_values'] = $this->get('value');
			} else { //double value
				$data['condition_values'] = $this->get('values');
			}
		}
		$this->merge($data);
	}

	public function checkSendEmail()
	{
		if(!$this->has('send_email')){
			$data = $this->all();
			$data['send_email'] = 0;
			$this->merge($data);
		}
	}

	public function checkCopyEmail()
	{
		if($this->has('copy_email') && $this->get('copy_email')!=NULL){
			$data = $this->all();
			$data['copy_email'] = explode(',',$this->get('copy_email'));
			$this->rules_['copy_email'] = 'email|min:3|max:500';
			$this->merge($data);
		}
	}
}

