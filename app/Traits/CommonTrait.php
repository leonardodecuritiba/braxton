<?php

namespace App\Traits;

use App\Helpers\DataHelper;

trait CommonTrait {

	public function getCreatedAtTime() {
		return strtotime( $this->attributes['created_at'] );
	}

	public function getCreatedAtFormatted()
	{
		return DataHelper::getPrettyDateTime( $this->attributes['created_at'] );
	}

	public function getExecutionAtTime() {
		return strtotime( $this->attributes['execution_at'] );
	}

	public function getExecutionAtFormatted()
	{
		return DataHelper::getPrettyDateTime( $this->attributes['execution_at'] );
	}

	public function getValue2Currency()
	{
		return DataHelper::getFloat2Currency( $this->attributes['value'] );
	}
}