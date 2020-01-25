<?php

namespace App\Observers\Clients;

use App\Models\Clients\Reports\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportObserver
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Listen to the Client creating event.
     *
     * @param  \App\Models\Clients\Reports\Report $report
     *
     * @return void
     */
    public function creating(Report $report)
    {
	    $report->author_id = Auth::user()->id;
	    switch($this->request->get('repetition')){
		    case 0:
			    //MENSALMENTE
			    $report->repetition_option = $this->request->get('day');
			    $report->interval = 3;
			    break;
		    case 1:
			    //SEMANALMENTE
			    $report->repetition_option = $this->request->get('day_of_week');
			    $report->interval = 3;
			    break;
		    case 2:
			    //DIARIAMENTE
			    $report->repetition_option = NULL;
			    break;
	    }
	    $report->execution_at = Report::getNextExecution($report);
    }

    /**
     * Listen to the Client saving event.
     *
     * @param  \App\Models\Clients\Reports\Report $report
     *
     * @return void
     */
    public function saving(Report $report)
    {
	    switch($this->request->get('repetition')){
		    case 0:
			    //MENSALMENTE
			    $report->repetition_option = $this->request->get('day');
			    $report->interval = 3;
			    break;
		    case 1:
			    //SEMANALMENTE
			    $report->repetition_option = $this->request->get('day_of_week');
			    $report->interval = 3;
			    break;
		    case 2:
			    //DIARIAMENTE
			    $report->repetition_option = NULL;
			    break;
	    }
	    $report->execution_at = Report::getNextExecution($report);

	    if ($report->active == 1) {
		    if($report->sensor->active == 0){
			    $report->active = 0;
		    }
	    }
    }

    /**
     * Listen to the Client deleting event.
     *
     * @param  \App\Models\Clients\Reports\Report $report
     *
     * @return void
     */
    public function deleting(Report $report)
    {
	    $report->logs->each( function ( $w ) {
		    $w->delete();
	    } );
    }
}