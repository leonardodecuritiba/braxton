<?php

use Illuminate\Database\Seeder;
use App\Models\Clients\Reports\Report;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    //php artisan db:seed --class=ReportSeeder
	    factory(Report::class, 100)->create();
	    $this->command->info('Report complete ...');
    }
}
