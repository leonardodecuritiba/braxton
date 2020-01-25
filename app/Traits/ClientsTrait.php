<?php

namespace App\Traits;

use App\Helpers\DataHelper;

trait ClientsTrait {

	// ******************** SCOPE ******************************
	/**
	 * Scope a query to only include legal person entities.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeLegalPerson( $query ) {
		return $query->where( 'type', 0 );
	}

	/**
	 * Scope a query to only include natural person entities.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeNaturalPerson( $query ) {
		return $query->where( 'type', 1 );
	}


	public function getFormattedBirthday() {
		return DataHelper::getPrettyDate( $this->attributes['birthday'] );
	}

	public function getFormattedFoudation() {
		return DataHelper::getPrettyDate( $this->attributes['foundation'] );
	}

	public function setFoundationAttribute( $value ) {
		$this->attributes['foundation'] = DataHelper::setDate( $value );
	}

	public function setBirthdayAttribute( $value ) {
		$this->attributes['birthday'] = DataHelper::setDate( $value );
	}

	public function setCnpjAttribute( $value ) {
		return $this->attributes['cnpj'] = DataHelper::getOnlyNumbers( $value );
	}

	public function getFormattedCnpj() {
		return DataHelper::mask( $this->attributes['cnpj'], '##.###.###/####-##' );
	}

	public function setCpfAttribute( $value ) {
		return $this->attributes['cpf'] = DataHelper::getOnlyNumbers( $value );
	}

	public function getFormattedCpf() {
		return DataHelper::mask( $this->attributes['cpf'], '###.###.###-##' );
	}

	public function setRgAttribute( $value ) {
		return $this->attributes['rg'] = DataHelper::getOnlyNumbers( $value );
	}

	public function getFormattedRg() {
		return DataHelper::mask( $this->attributes['rg'], '#.###.###-##' );
	}

	public function setIeAttribute( $value ) {
		return $this->attributes['ie'] = DataHelper::getOnlyNumbers( $value );
	}

	public function getFormattedIe() {
		return DataHelper::mask( $this->attributes['ie'], '###.###.###.###' );
	}
}