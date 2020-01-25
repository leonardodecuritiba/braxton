<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('index')->middleware('auth');

Route::group( [ 'prefix' => 'ajax', 'middleware' => [ 'auth' ] ], function () {
	Route::get( 'state-city', 'Commons\AjaxController@getStateCityToSelect' )->name( 'ajax.get.state-city' );
	Route::get( 'set-active', 'Commons\AjaxController@setActive' )->name( 'ajax.set.active' );
	Route::get( 'set-active-permissions', 'Commons\AjaxController@setActivePermissions' )->name( 'ajax.set.active_permissions' );
	Route::get( 'device-sensors', 'Commons\AjaxController@getDeviceSensorsToSelect' )->name('ajax.get.device-sensors');
	Route::get( 'sensor-sensor_type', 'Commons\AjaxController@getSensorSensorType' )->name('ajax.get.sensor-sensor_type');
	Route::get( 'sensor-last_data', 'Commons\AjaxController@getSensorLastData' )->name('ajax.get.sensor-last_data');

} );

Route::group(['prefix' => 'system', 'middleware' => 'auth'], function () {
	/*
	|--------------------------------------------------------------------------
	| Admins Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::resource('admins', 'Admins\AdminController');
	/*
	|--------------------------------------------------------------------------
	| Clients Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::resource('clients', 'Clients\ClientController');
	/*
	|--------------------------------------------------------------------------
	| SubClients Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::resource('sub_clients', 'Clients\SubClientController');
    /*
    |--------------------------------------------------------------------------
    | Devices Routes
    |--------------------------------------------------------------------------
    |
    */
    Route::resource('devices', 'Clients\DeviceController');
    /*
    |--------------------------------------------------------------------------
    | Sensors Routes
    |--------------------------------------------------------------------------
    |
    */
    Route::resource('sensors', 'Clients\SensorController');
	Route::get('sensors/create/{device_id}', 'Clients\SensorController@create' )->name('sensors.create');
	/*
	|--------------------------------------------------------------------------
	| SensorTypes Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::resource('sensor_types', 'Commons\SensorTypeController');
	/*
	|--------------------------------------------------------------------------
	| Dashboards Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::resource('dashboards', 'Clients\DashboardController');
	/*
	|--------------------------------------------------------------------------
	| Alerts Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::resource('alerts', 'Clients\AlertController');
	Route::get('alerts/create/{sensor_id}', 'Clients\AlertController@create' )->name('alerts.create');
	/*
	|--------------------------------------------------------------------------
	| Reports Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::resource('reports', 'Clients\ReportController');
	Route::get('reports/create/{sensor_id}', 'Clients\ReportController@create' )->name('reports.create');
	/*
	|--------------------------------------------------------------------------
	| Reports-Logs Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::resource('reports_logs', 'Clients\ReportLogController');
	/*
	|--------------------------------------------------------------------------
	| Alerts-Logs Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::resource('alerts_logs', 'Clients\AlertLogController');
	/*
	|--------------------------------------------------------------------------
	| Permissions Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::resource('permissions', 'Commons\PermissionController');

//
//    /*
//    |--------------------------------------------------------------------------
//    | SubGroups Routes
//    |--------------------------------------------------------------------------
//    |
//    */
//    Route::resource('sub_groups', 'Commons\SubGroupController');
//    Route::get('sub_groups/create/{group_id}', 'Commons\SubGroupController@create')->name('sub_groups.create');
//    /*
//    |--------------------------------------------------------------------------
//    | Groups Routes
//    |--------------------------------------------------------------------------
//    |
//    */
//    Route::resource('plights', 'Commons\PlightController');
//    /*
//    |--------------------------------------------------------------------------
//    | Products Routes
//    |--------------------------------------------------------------------------
//    |
//    */
//    Route::resource('products', 'Commons\ProductController');
//    Route::get('products-export', 'Commons\ProductController@export')->name('products.export');
//
//    /*
//    |--------------------------------------------------------------------------
//    | Brands Routes
//    |--------------------------------------------------------------------------
//    |
//    */
//    Route::resource('brands', 'Commons\BrandController');
});

Route::group(['prefix' => 'users', 'middleware' => 'auth'], function () {
    /*
    |--------------------------------------------------------------------------
    | My profile Routes
    |--------------------------------------------------------------------------
    |
    */
	Route::get( 'my-profile', 'Commons\CommonController@myProfile' )->name( 'users.profile' );
	Route::post( 'password-change', 'Commons\CommonController@updatePassword' )->name( 'change.password' );

});

/*
|--------------------------------------------------------------------------
| Print-Report
|--------------------------------------------------------------------------
|
*/
Route::get('report-display/{id}', function ($id)
{
	$report_log = \App\Models\Clients\Reports\ReportLog::find($id);
	return \App\Helpers\PrintHelper::reportLogExport($report_log);

})->name('report-display');




Route::group(['prefix' => 'teste'], function () {

    Route::get('sendemail', function () {
//		return "Your email has been sent successfully";


        $user = array(
            'email' => "silva.zanin@gmail.com",
            'name' => "Leonardo",
            'mensagem' => "TESTE OK",
        );

        Mail::raw($user['mensagem'], function ($message) use ($user) {
            $message->to($user['email'], $user['name'])->subject('Welcome!');
            $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
        });

        return "Your email has been sent successfully";

    });


    Route::get('get-logs', function () {
	    $dashboard = \App\Models\Clients\Dashboard::where('sensor_id',1)->first();
	    return $dashboard->getDataChart();
    });

	Route::get('send-report/{id}', function ($id)
	{
		$report_log = \App\Models\Clients\Reports\ReportLog::find($id);
		return $report_log->notify();
	});

	Route::get('generate-report/{id}', function ($id)
	{
		$report = \App\Models\Clients\Reports\Report::find($id);
		return $report->storeLog();
	});


	Route::get('send-alert/{id}', function ($id)
	{
		$alert = \App\Models\Clients\Alerts\Alert::find($id);
		return $alert->run();

	})->name('report-display');
});

