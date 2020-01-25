<?php

namespace App\Observers\Commons;

use App\Models\Commons\SensorType;
use Illuminate\Http\Request;

class SensorTypeObserver
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Listen to the Client creating event.
     *
     * @param  \App\Models\Commons\SensorType $sensor_type
     *
     * @return void
     */
    public function creating(SensorType $sensor_type)
    {
    }

    /**
     * Listen to the Client saving event.
     *
     * @param  \App\Models\Commons\SensorType $sensor_type
     *
     * @return void
     */
    public function saving(SensorType $sensor_type)
    {
	    if ($sensor_type->active == 0) {
		    $sensor_type->sensors->each( function ( $w ) {
			    $w->disactive();
		    } );
	    }
    }

    /**
     * Listen to the Client deleting event.
     *
     * @param  \App\Models\Commons\SensorType $sensor_type
     *
     * @return void
     */
    public function deleting(SensorType $sensor_type)
    {
	    $sensor_type->sensors->each( function ( $w ) {
		    $w->delete();
	    } );
    }
}