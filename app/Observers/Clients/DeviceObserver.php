<?php

namespace App\Observers\Clients;

use App\Models\Clients\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceObserver
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Listen to the Client creating event.
     *
     * @param  \App\Models\Clients\Device $device
     *
     * @return void
     */
    public function creating(Device $device)
    {
	    $device->author_id = Auth::user()->id;
    }


	/**
	 * Listen to the Sensor updating event.
	 *
	 * @param  \App\Models\Clients\Device $device
	 *
	 * @return void
	 */
	public function saving(Device $device)
	{
		if ($device->active == 0) {
			$device->sensors->each( function ( $w ) {
				$w->disactive();
			} );
		} else {
			if($device->client->user->active == 0){
				$device->active = 0;
			}
		}
	}

    /**
     * Listen to the Client deleting event.
     *
     * @param  \App\Models\Clients\Device $device
     *
     * @return void
     */
    public function deleting(Device $device)
    {
	    $device->sensors->each( function ( $w ) {
		    $w->delete();
	    } );
    }
}