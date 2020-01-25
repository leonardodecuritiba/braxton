<?php

namespace App\Observers\Clients;

use App\Models\Clients\Alerts\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlertObserver
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Listen to the Client creating event.
     *
     * @param  \App\Models\Clients\Alerts\Alert $alert
     *
     * @return void
     */
    public function creating(Alert $alert)
    {
	    $alert->author_id = Auth::user()->id;
	    switch($alert->alert_type){
		    case 0:
		    case 1:
			    $alert->condition_type = NULL;
			    $alert->condition_values = NULL;
			    $alert->time = ['00:00','23:59'];
			    $alert->days = ['0','1','2','3','4','5','6'];
			    break;
	    }
    }

	/**
	 * Listen to the Sensor updating event.
	 *
	 * @param  \App\Models\Clients\Alerts\Alert $alert
	 *
	 * @return void
	 */
	public function saving(Alert $alert)
	{
		if ($alert->active == 1) {
			if($alert->sensor->active == 0){
				$alert->active = 0;
			}
		}
	}

    /**
     * Listen to the Client deleting event.
     *
     * @param  \App\Models\Clients\Alerts\Alert $alert
     *
     * @return void
     */
    public function deleting(Alert $alert)
    {
	    $alert->logs->each( function ( $w ) {
		    $w->delete();
	    } );
    }
}