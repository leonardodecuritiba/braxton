<?php

namespace App\Http\Controllers\Clients;

use App\Helpers\PrintHelper;
use App\Models\Clients\Alerts\AlertLog;
use App\Models\Clients\Reports\ReportLog;
use App\Models\Commons\SensorType;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class AlertLogController extends Controller {

	public $entity = "alert_logs";
	public $sex = "M";
	public $name = "Alerta Gerado";
	public $names = "Alertas Gerados";
	public $main_folder = 'pages.sensors';
	public $page = [];

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Route $route)
	{
		parent::__construct();
		$this->page = (object) [
			'entity'      => $this->entity,
			'main_folder' => $this->main_folder,
			'name'        => $this->name,
			'names'       => $this->names,
			'sex'         => $this->sex,
			'auxiliar'    => array(),
			'response'    => array(),
			'page_title'  => 'Meus Alertas Gerados',
			'main_title'  => 'Meus Alertas Gerados',
			'noresults'   => '',
			'tab'         => 'data'
		];
		$this->breadcrumb($route);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  $id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy( $id ) {
		$data = AlertLog::find($id);
		$message = $this->getMessageFront( 'DELETE', $this->name . ': #' . $id );
		$data->delete();

		return new JsonResponse( [
			'status'  => 1,
			'message' => $message,
		], 200 );
	}
}
