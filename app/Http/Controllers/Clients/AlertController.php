<?php

namespace App\Http\Controllers\Clients;

use App\Helpers\BaseHelper;
use App\Http\Requests\Clients\AlertRequest;
use App\Models\Clients\Alerts\Alert;
use App\Models\Commons\SensorType;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Redirect;

class AlertController extends Controller {

	public $entity = "alerts";
	public $sex = "M";
	public $name = "Alerta";
	public $names = "Alertas";
	public $main_folder = 'pages.alerts';
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
			'page_title'  => 'Meus Alertas',
			'main_title'  => 'Meus Alertas',
			'noresults'   => '',
			'tab'         => 'data'
		];
		$this->breadcrumb($route);
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$data = $this->user->getAlerts();
		$this->page->response = $data->map( function ( $s ) {
			return [
				'entity'          => $this->entity,
				'id'              => $s->id,
				'name'            => $s->getShortName(),
				'client'          => $s->getClientName(),
				'type'            => $s->getAlertTypeText(),
				'sensor'          => $s->getShortSensorName(),
				'sensor_type'     => $s->getShortSensorTypeName(),
				'condition'       => $s->getAlertConditionText(),
				'time'            => $s->getTimeText(),
				'created_at'      => $s->getCreatedAtFormatted(),
				'created_at_time' => $s->getCreatedAtTime(),
				'active'          => $s->getActiveFullResponse()
			];
		} );
		return view( 'pages.alerts.index' )
			->with( 'Page', $this->page );
	}

	/**
	 * Show the application dashboard.
	 * @param  $sensor_id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create( $sensor_id = NULL )
	{
		$this->page->main_title         .= ' - Novo';
		$this->page->auxiliar   = [
//			'alert_types'       => array_slice(BaseHelper::$_ALERT_TYPES_,2),
			'alert_types'       => BaseHelper::$_ALERT_TYPES_,
			'alert_conditions'  => BaseHelper::$_ALERT_CONDITIONS_,
			'days_of_week'      => BaseHelper::$_DAYS_OF_WEEK_,
			'devices'           => $this->user->getActiveDevices()->map(function($s){
				return [
					'id'            => $s->id,
					'description'   => $s->getShortName()
				];
			})->pluck('description', 'id')
		];

		if($sensor_id != NULL){
			$sensor = $this->user->findMySensor($sensor_id);
			$this->page->auxiliar['device_id'] = $sensor->device_id;
			$this->page->auxiliar['sensor_id'] = $sensor->id;
		}

		return view( $this->main_folder . '.master' )
			->with( 'Page', $this->page );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		$data                            = $this->user->findMyAlert( $id );
		$this->page->main_title         .= ' - Editar';
		$this->page->breadcrumb = [
			[ 'route' => route( 'index' ), 'text' => 'Home' ],
			[ 'route' => route( 'sensors.index' ), 'text' => trans( 'global.sensors.name') ],
			[ 'route' => route( 'sensors.edit', $data->sensor_id), 'text' => $data->sensor->getShortName() ],
			[ 'route' => route( 'alerts.index' ), 'text' => trans( 'global.alerts.name') ],
			[ 'route' => null, 'text' => trans( 'pages.view.EDIT', [ 'name' => $this->name ] ) ],
		];
		$this->page->auxiliar   = [
			'logs'          => $data->logs->map(function($s){
				return [
					'id'            => $s->id,
					'message'       => $s->getMessage(),
					'created_at'    => $s->created_at,
					'url'           => route('report-display',$s->id)
				];
			}),
			'parent'            => $data->sensor,
			'alert_types'       => BaseHelper::$_ALERT_TYPES_,
			'alert_conditions'  => BaseHelper::$_ALERT_CONDITIONS_,
			'days_of_week'      => BaseHelper::$_DAYS_OF_WEEK_,
			'devices'           => $this->user->getActiveDevices()->map(function($s){
				return [
					'id'            => $s->id,
					'description'   => $s->getShortName()
				];
			})->pluck('description', 'id')
		];
		return view( $this->main_folder . '.master' )
			->with( 'Data', $data )
			->with( 'Page', $this->page );
	}
	/**
	 * Store the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Clients\AlertRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( AlertRequest $request )
	{
//		return Redirect::back()->withErrors(['Funcionalidade ainda não finalizada']);
		$data = $this->user->createAlert( $request->all() );
		return response()->success( $this->getMessageFront( 'STORE' ), $data, route( $this->entity . '.index' ) );
		return $this->redirect( 'STORE', $data );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Clients\AlertRequest $request
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( AlertRequest $request, $id ) {
		$data = $this->user->findMyAlert( $id );
		$data->update( $request->all() );
		return $this->redirect( 'UPDATE', $data );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  $id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy( $id ) {
		$data = $this->user->findMyAlert( $id );
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $data->getShortName() );
		$data->delete();

		return new JsonResponse( [
			'status'  => 1,
			'message' => $data,
		], 200 );
	}
}
