<?php

namespace App\Observers\Clients;

use App\Models\Clients\SubClient;
use App\Models\Users\User;
use Illuminate\Http\Request;

class SubClientObserver
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Listen to the Client creating event.
     *
     * @param  \App\Models\Clients\SubClient $sub_client
     *
     * @return void
     */
    public function creating(SubClient $sub_client)
    {
	    $user = User::create( [
		    'name'    => $this->request->get( 'name' ),
		    'email'    => $this->request->get( 'email' ),
		    'password' => bcrypt( $this->request->get( 'password' ) ),
	    ] );
	    $user->attachRole( 3 );
	    $sub_client->user_id = $user->id;
    }

    /**
     * Listen to the Client updating event.
     *
     * @param  \App\Models\Clients\SubClient $sub_client
     *
     * @return void
     */
    public function saving(SubClient $sub_client)
    {
        if ($sub_client->user != NULL) {
	        $sub_client->user->update($this->request->all());
        }

	    if ($sub_client->active == 1) {
		    if($sub_client->client->active == 0){
			    $sub_client->active = 0;
		    }
	    }
    }

    /**
     * Listen to the Client deleting event.
     *
     * @param  \App\Models\Clients\SubClient $sub_client
     *
     * @return void
     */
    public function deleting(SubClient $sub_client)
    {
	    $sub_client->user->delete();
    }
}