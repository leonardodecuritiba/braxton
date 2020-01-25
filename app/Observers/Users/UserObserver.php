<?php

namespace App\Observers\Users;

use App\Models\Users\User;
use Illuminate\Http\Request;

class UserObserver {
	protected $request;

	public function __construct( Request $request ) {
		$this->request = $request;
	}


	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Users\User $user
	 *
	 * @return void
	 */
	public function deleting( User $user )
	{
	}
}