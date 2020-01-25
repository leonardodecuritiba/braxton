<?php

namespace App\Http\Requests\Clients;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReportRequest extends FormRequest {
	private $table = 'reports';
	private $rules_;

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		if ( $this->report != null ) {
			return Auth::user()->isMyReport( $this->report );
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
			'repetition'    => 'required|numeric|between:0,2',
			'name'          => 'required|min:3|max:200',
			'sensor_id'     => 'required|exists:sensors,id',
//			'main_email'    => 'required|email|min:3|max:100'
		];

		//check if send_email is checked
		$this->checkSendEmail();

		//check if copy_email is correct
		$this->checkCopyEmail();

		$this->checkRepetition();
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

	public function checkRepetition()
	{
		switch($this->get('repetition')){
			case 0:
				//MENSALMENTE
				$this->rules_['day'] = 'required|numeric|between:1,28';
				break;
			case 1:
				//SEMANALMENTE
				$this->rules_['day_of_week'] = 'required|numeric|between:0,6';
				break;
			case 2:
				//DIARIAMENTE
				$this->rules_['interval'] = 'required|numeric|between:0,2';
				break;
		}
		return;
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
//			$this->rules_['copy_email'] = 'email|min:3|max:500';
			$this->merge($data);
		}
	}
}

