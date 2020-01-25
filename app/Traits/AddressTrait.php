<?php

namespace App\Traits;

use App\Helpers\DataHelper;

trait AddressTrait {
	public function getFormatedZip() {
		return DataHelper::mask( $this->attributes['zip'], '#####-###' );
	}

	public function getFullAddress() {
		return $this->getFullStreet() . ', ' . $this->getStateCity();
	}

	public function getFullStreet() {
		return $this->attributes['street'] . ', ' . $this->attributes['number'];
	}

	public function getStateCity() {
		return $this->attributes['city'] . ' - ' . $this->attributes['state'];
	}

	public function getCreatedAtAttribute( $value ) {
		return DataHelper::getPrettyDateTime( $value );
	}

	public function setZipAttribute( $value ) {
		return $this->attributes['zip'] = DataHelper::getOnlyNumbers( $value );
	}
}