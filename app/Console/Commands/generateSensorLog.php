<?php

namespace App\Console\Commands;

use App\Helpers\BaseHelper;
use App\Models\Clients\Sensor;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class generateSensorLog extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'generate_logs';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate Logs';

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
			$start = microtime(true);
			DB::table('sensor_logs')->truncate();

			$days = 30;
			$id = 1;
			$end_date =  Carbon::now();
			$scale =  'PT1M';

			while($id > 0){
				$sensor = Sensor::find($id);

				while($days > 0){

					$start_date = clone $end_date;
					$start_date->subDays(1);
					$start_date->addSecond();
//			$array = \App\Helpers\BaseHelper::generateDateRangeInsert($sensor->id,$start_date, $end_date, 'P1S',$sensor->getRange());
//			$array = \App\Helpers\BaseHelper::generateDateRangeInsert($sensor->id,$start_date, $end_date, 'PT10S',$sensor->getRange());
					$array = BaseHelper::generateDateRangeInsert($sensor->id,$start_date, $end_date, $scale, $sensor->getRange());
//			RETURN count($array);
					DB::table('sensor_logs')->insert($array);

					$end_date->subDays(1);

					$this->info("day: " . $days);
					$days--;
				}
				$id--;
			}


			$this->info("*** Success em " . round((microtime(true) - $start), 3) . "s ***");

		} catch (\Exception $e) {
			$this->info($e);
		}

	}
}
