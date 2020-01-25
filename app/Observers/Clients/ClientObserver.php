<?php

namespace App\Observers\Clients;

use App\Models\Clients\Client;
use App\Models\Commons\Address;
use App\Models\Commons\Contact;
use App\Models\Users\User;
use Illuminate\Http\Request;

class ClientObserver
{
	protected $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	/**
	 * Listen to the Client creating event.
	 *
	 * @param  \App\Models\Clients\Client $client
	 *
	 * @return void
	 */
	public function creating(Client $client)
	{
		$user = User::create( [
			'name'    => $this->request->get( 'username' ),
			'email'    => $this->request->get( 'email' ),
			'password' => bcrypt( $this->request->get( 'password' ) ),
		] );
		$user->attachRole( 2 );
		$client->user_id    = $user->id;
		$contact = Contact::create($this->request->all());
		$address = Address::create($this->request->all());
		$client->contact_id = $contact->id;
		$client->address_id = $address->id;
	}

	/**
	 * Listen to the Client updating event.
	 *
	 * @param  \App\Models\Clients\Client $client
	 *
	 * @return void
	 */
	public function saving(Client $client)
	{
		if ($client->user != NULL) {
			$client->user->update([
				'name'    => $this->request->get( 'username' ),
				'email'    => $this->request->get( 'email' ),
			]);
			$client->address->update($this->request->all());
			$client->contact->update($this->request->all());
		}
		if ($client->active == 0) {
			$client->devices->each( function ( $w ) {
				$w->disactive();
			} );
		}
	}


	/**
	 * Listen to the Client deleting event.
	 *
	 * @param  \App\Models\Clients\Client $client
	 *
	 * @return void
	 */
	public function deleting(Client $client)
	{
		$client->devices->each( function ( $w ) {
			$w->delete();
		} );
		$client->address->delete();
		$client->contact->delete();
		$client->user->delete();

	}
}