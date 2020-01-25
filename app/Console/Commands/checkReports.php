<?php

namespace App\Console\Commands;

use App\Models\Clients\Reports\Report;
use App\Models\Clients\Reports\ReportLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class checkReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check_reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Reports to execute';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	try {
		    $now = Carbon::now()->toDateTimeString();
		    if(!config('app.cron_debug')){
			    $reports = Report::allToRun();

			    if($reports->count() > 0){
				    foreach($reports as $report){
					    $report_log = $report->storeLog();

					    if($report_log != NULL){
						    $this->info(
							    '['.$now.']' .
							    '[' . $report->id . ']' .
							    '[' .$report_log->id . ']'.
							    ' nxt:' . $report->getExecutionAtFormatted()
						    );
					    } else {
						    $this->info(
							    '['.$now.']' .
							    '[' . $report->id . ']' .
							    '[EMPTY]' .
							    ' nxt:' . $report->getExecutionAtFormatted()
						    );
					    }
				    }
				    $this->info('-----------------------------------------------------------');
			    }

		    } else {
			    $this->info('['.$now.'] debug mode');
			    $this->info('-----------------------------------------------------------');
		    }
	    } catch (\Exception $e) {
		    $this->info($e);
	    }

    }
}
