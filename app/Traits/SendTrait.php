<?php

namespace App\Traits;


trait SendTrait {

	public function setCopyEmailAttribute($value)
	{
		$this->attributes['copy_email'] = ($value==NULL) ? $value : json_encode($value);
	}

	public function getCopyEmailText()
	{
		$emails = json_decode($this->attributes['copy_email']);
		if($emails !=NULL){
			return (count($emails) > 1) ? implode(',',$emails) : $emails[0];
		}
		return $emails;
	}

}