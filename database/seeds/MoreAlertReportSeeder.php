<?php

use Illuminate\Database\Seeder;
use \App\Models\Clients\Alerts\Alert;
use \App\Models\Clients\Reports\Report;

class MoreAlertReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
	    //php artisan db:seed --class=MoreAlertReportSeeder
	    Alert::flushEventListeners();
	    Alert::getEventDispatcher();
	    Report::flushEventListeners();
	    Report::getEventDispatcher();


	    factory(Alert::class, 100)->create();
	    $this->command->info('Alert complete ...');

	    factory(Report::class, 100)->create();
	    $this->command->info('Report complete ...');
    }
}
