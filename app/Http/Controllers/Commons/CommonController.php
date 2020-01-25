<?php

namespace App\Http\Controllers\Commons;

use App\Http\Controllers\Controller;
use App\Http\Requests\Commons\UpdatePasswordRequest;
use Illuminate\Support\Facades\Auth;

class CommonController extends Controller {



	/**
	 * Show the application dashboard.
	 *
	 * @param \App\Http\Requests\Commons\UpdatePasswordRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updatePassword( UpdatePasswordRequest $request )
	{
		$user = Auth::user();
		$user->updatePassword( $request->get( 'password' ) );
		$role = $user->getRole();

		switch ($role->name){
			case 'admin':
				$route = route('admins.edit',$user->admin->id);
				break;
			case 'client':
				$route = route('clients.edit',$user->client->id);
				break;
			case 'subclient':
				$route = route('sub_clients.edit',$user->sub_client->id);
				break;
		}
		return response()->success( trans('messages.UPDATE-PASSWORD.SUCCESS'), $user, $route );
	}

	/**
	 * Show the application dashboard.
	 *
	 * @param $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function myProfile(  )
	{
		$user = Auth::user();
		$role = $user->getRole();

		switch ($role->name){
			case 'admin':
				return redirect()->route('admins.edit',$user->admin->id);
			case 'client':
				return redirect()->route('clients.edit',$user->client->id);
			case 'subclient':
				return redirect()->route('sub_clients.edit',$user->sub_client->id);
		}
	}
}
