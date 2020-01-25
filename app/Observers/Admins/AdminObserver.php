<?php

namespace App\Observers\Admins;

use App\Models\Admins\Admin;
use App\Models\Users\User;
use Illuminate\Http\Request;

class AdminObserver
{
	protected $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	/**
	 * Listen to the Admin creating event.
	 *
	 * @param  \App\Models\Admins\Admin $admin
	 *
	 * @return void
	 */
	public function creating(Admin $admin)
	{
		$user = User::create( [
			'name'    => $this->request->get( 'username' ),
			'email'    => $this->request->get( 'email' ),
			'password' => bcrypt( $this->request->get( 'password' ) ),
		] );
		$user->attachRole( 3 );
		$admin->user_id    = $user->id;
	}

	/**
	 * Listen to the Admin updating event.
	 *
	 * @param  \App\Models\Admins\Admin $admin
	 *
	 * @return void
	 */
	public function saving(Admin $admin)
	{
		if ($admin->user != NULL) {
			$admin->user->update([
				'name'    => $this->request->get( 'username' ),
				'email'    => $this->request->get( 'email' ),
			]);
		}
	}


	/**
	 * Listen to the Admin deleting event.
	 *
	 * @param  \App\Models\Admins\Admin $admin
	 *
	 * @return void
	 */
	public function deleting(Admin $admin)
	{
		$admin->user->delete();
	}
}