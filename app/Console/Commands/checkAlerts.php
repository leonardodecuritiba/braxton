<?php

namespace App\Console\Commands;

use App\Models\Clients\Alerts\Alert;
use App\Models\Clients\Reports\Report;
use Carbon\Carbon;
use Illuminate\Console\Command;

class checkAlerts extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'check_alerts';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Check Alerts to execute';

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
				$alerts = Alert::allToRun();

				if($alerts->count() > 0){
					foreach($alerts as $alert){
						$alert_log = $alert->run();

						if($alert_log != NULL){
							$this->info(
								'['.$now.']' .
								'[' . $alert->id . ']' .
								'[' .$alert_log->id . ']'.
								' nxt:' . $alert_log->getDataLog()
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
