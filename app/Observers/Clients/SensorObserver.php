<?php

namespace App\Observers\Clients;

use App\Models\Clients\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SensorObserver
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Listen to the Client creating event.
     *
     * @param  \App\Models\Clients\Sensor $sensor
     *
     * @return void
     */
    public function creating(Sensor $sensor)
    {
	    $sensor->author_id = Auth::user()->id;
    }

	/**
	 * Listen to the Sensor updating event.
	 *
	 * @param  \App\Models\Clients\Sensor $sensor
	 *
	 * @return void
	 */
	public function saving(Sensor $sensor)
	{
		if ($sensor->active == 0) {
			$sensor->alerts->each( function ( $w ) {
				$w->disactive();
			} );
			$sensor->dashboards->each( function ( $w ) {
				$w->disactive();
			} );
			$sensor->reports->each( function ( $w ) {
				$w->disactive();
			} );
		} else {
			if($sensor->device->active == 0){
				$sensor->active = 0;
			}
			if($sensor->sensor_type->active == 0){
				$sensor->active = 0;
			}
		}
	}


	/**
     * Listen to the Client deleting event.
     *
     * @param  \App\Models\Clients\Sensor $sensor
     *
     * @return void
     */
    public function deleting(Sensor $sensor)
    {
	    $sensor->alerts->each( function ( $w ) {
		    $w->delete();
	    } );
	    $sensor->dashboards->each( function ( $w ) {
		    $w->delete();
	    } );
	    $sensor->reports->each( function ( $w ) {
		    $w->delete();
	    } );
    }
}