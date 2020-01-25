<?php

namespace App\Traits;


use App\Models\Users\User;

trait UserTrait {
	public function getShortName() {
		return $this->user->getShortName();
	}

	public function getShortEmail() {
		return $this->user->getShortEmail();
	}

	public function getShortNickname() {
		return $this->user->getShortNickname();
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}