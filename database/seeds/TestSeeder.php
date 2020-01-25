<?php

use Illuminate\Database\Seeder;
use \App\Models\Clients\Client;
use \App\Models\Clients\SubClient;
use \App\Models\Clients\Device;
use \App\Models\Clients\Sensor;
use \App\Models\Clients\Dashboard;
use \App\Models\Clients\Alerts\Alert;
use \App\Models\Clients\Reports\Report;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //php artisan db:seed --class=TestSeeder
	    $start = microtime(true);
	    /**/
        Client::flushEventListeners();
        Client::getEventDispatcher();
        SubClient::flushEventListeners();
        SubClient::getEventDispatcher();
	    Device::flushEventListeners();
	    Device::getEventDispatcher();
	    Sensor::flushEventListeners();
	    Sensor::getEventDispatcher();
	    Alert::flushEventListeners();
	    Alert::getEventDispatcher();
	    Dashboard::flushEventListeners();
	    Dashboard::getEventDispatcher();
	    Report::flushEventListeners();
	    Report::getEventDispatcher();

        factory(Client::class, 'legal', 2)->create();
	    $Client = Client::find(1);
	    $Client->user->update(['email'=>'client@email.com']);
        $this->command->info('Client-legal complete ...');


//        return;
/*

	    factory(Client::class, 'natural', 1)->create();
        $this->command->info('Client-natural complete ...');

        factory(Client::class, 'legal', 4)->create();
        $this->command->info('Client-legal complete ...');
*/
        factory(SubClient::class, 10)->create();
	    $Client->sub_clients->first()->user->update(['email'=>'operator@email.com']);
        $this->command->info('SubClient complete ...');

	    factory(Device::class, 1)->create();
	    $this->command->info('Device complete ...');

	    factory(Sensor::class, 1)->create();
	    $this->command->info('Sensor complete ...');

	    factory(Alert::class, 2)->create();
	    $this->command->info('Alert complete ...');

	    factory(Report::class, 2)->create();
	    $this->command->info('Report complete ...');

	    factory(Dashboard::class, 1)->create();
	    $this->command->info('Dashboard complete ...');

        $this->command->info("*** Importacao IMPORTSEEDER realizada com sucesso em " . round((microtime(true) - $start), 3) . "s ***");

    }
}
