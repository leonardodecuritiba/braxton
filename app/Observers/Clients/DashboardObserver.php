<?php

namespace App\Observers\Clients;

use App\Models\Clients\Dashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardObserver
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Listen to the Client creating event.
     *
     * @param  \App\Models\Clients\Dashboard $dashboard
     *
     * @return void
     */
    public function creating(Dashboard $dashboard)
    {
	    $dashboard->author_id = Auth::user()->id;
	    $dashboard->client_id = $dashboard->sensor->device->client_id;
    }

	/**
	 * Listen to the Sensor updating event.
	 *
	 * @param  \App\Models\Clients\Dashboard $dashboard
	 *
	 * @return void
	 */
	public function saving(Dashboard $dashboard)
	{
		if ($dashboard->active == 1) {
			if($dashboard->sensor->active == 0){
				$dashboard->active = 0;
			}
		}
	}
    /**
     * Listen to the Client deleting event.
     *
     * @param  \App\Models\Clients\Dashboard $dashboard
     *
     * @return void
     */
    public function deleting(Dashboard $dashboard)
    {

    }
}