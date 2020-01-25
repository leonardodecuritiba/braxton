<?php

namespace App\Providers;

use App\Models\Admins\Admin;
use App\Models\Clients\Alerts\Alert;
use App\Models\Clients\Client;
use App\Models\Clients\Dashboard;
use App\Models\Clients\Device;
use App\Models\Clients\Reports\Report;
use App\Models\Clients\Sensor;
use App\Models\Clients\SubClient;
use App\Models\Commons\SensorType;
use App\Observers\Admins\AdminObserver;
use App\Observers\Clients\ClientObserver;
use App\Observers\Commons\SensorTypeObserver;
use App\Observers\Clients\AlertObserver;
use App\Observers\Clients\DashboardObserver;
use App\Observers\Clients\DeviceObserver;
use App\Observers\Clients\ReportObserver;
use App\Observers\Clients\SensorObserver;
use App\Observers\Clients\SubClientObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Faker\Generator as FakerGenerator;
use Faker\Factory as FakerFactory;
use Zizaco\Entrust\MigrationCommand;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		Schema::defaultStringLength( 191 );
		Admin::observe( AdminObserver::class );
		Client::observe( ClientObserver::class );
		SubClient::observe( SubClientObserver::class );
		Device::observe( DeviceObserver::class );
		Sensor::observe( SensorObserver::class );
		Alert::observe( AlertObserver::class );
		Dashboard::observe( DashboardObserver::class );
		Report::observe( ReportObserver::class );
		SensorType::observe( SensorTypeObserver::class );
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		$this->app->singleton( FakerGenerator::class, function () {
			return FakerFactory::create( 'pt_BR' );
		} );
//		$this->app->extend('command.entrust.migration', function () {
//			return new class extends MigrationCommand {
//				public function handle() {
//					parent::fire();
//				}
//			};
//		});
	}
}
