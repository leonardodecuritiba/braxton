<?php

namespace App\Http\Controllers\Clients;

use App\Helpers\BaseHelper;
use App\Http\Requests\Clients\ReportRequest;
use App\Models\Clients\Reports\Alert;
use App\Models\Clients\Reports\Report;
use App\Models\Commons\SensorType;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Redirect;

class ReportController extends Controller {

	public $entity = "reports";
	public $sex = "M";
	public $name = "Relatório";
	public $names = "Relatórios";
	public $main_folder = 'pages.reports';
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
			'page_title'  => 'Meus Relatórios',
			'main_title'  => 'Meus Relatórios',
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
		$data = $this->user->getReports();
		$this->page->response = $data->map( function ( $s ) {
			return [
				'entity'            => $this->entity,
				'id'                => $s->id,
				'name'              => $s->getName(),
				'short_name'        => $s->getShortName(),
				'client'            => $s->getClientName(),
				'sensor'            => $s->getShortSensorName(),
				'sensor_type'       => $s->getShortSensorTypeName(),
				'repetition'        => $s->getRepetitionText(),
				'interval_time'     => $s->getIntervalTimeText(),
				'execution_at'      => $s->getExecutionAtFormatted(),
				'execution_at_time' => $s->getExecutionAtTime(),
				'created_at'        => $s->getCreatedAtFormatted(),
				'created_at_time'   => $s->getCreatedAtTime(),
				'active'            => $s->getActiveFullResponse()
			];
		} );
		return view( $this->main_folder . '.index' )
			->with( 'Page', $this->page );
	}

	/**
	 * Show the application dashboard.
	 * @param  $sensor_id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create( $sensor_id = NULL)
	{
		$days = range(1,28);
		$this->page->main_title         .= ' - Novo';
		$this->page->auxiliar   = [
			'repetitions'   => BaseHelper::map_report_repetitions_text(3),
			'intervals'     => BaseHelper::map_report_intervals_text(3),
			'days'          => array_combine($days, $days),
			'days_of_week'  => BaseHelper::$_DAYS_OF_WEEK_,
			'devices'       => $this->user->getActiveDevices()->map(function($s){
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
	public function edit( $id )
	{
		$days = range(1,28);
		$data                            = $this->user->findMyReport( $id );
		$this->page->main_title         .= ' - Editar';
		$this->page->breadcrumb = [
			[ 'route' => route( 'index' ), 'text' => 'Home' ],
			[ 'route' => route( 'sensors.index' ), 'text' => trans( 'global.sensors.name') ],
			[ 'route' => route( 'sensors.edit', $data->sensor_id), 'text' => $data->sensor->getShortName() ],
			[ 'route' => route( 'reports.index' ), 'text' => trans( 'global.reports.name') ],
			[ 'route' => null, 'text' => trans( 'pages.view.EDIT', [ 'name' => $this->name ] ) ],
		];
		$this->page->auxiliar   = [
			'logs'          => $data->logs->map(function($s){
				return [
					'id'            => $s->id,
					'created_at'    => $s->created_at,
					'url'           => route('report-display',$s->id)
				];
			}),
			'parent'        => $data->sensor,
			'repetitions'   => BaseHelper::map_report_repetitions_text(3),
			'intervals'     => BaseHelper::map_report_intervals_text(3),
			'days'          => array_combine($days, $days),
			'days_of_week'  => BaseHelper::$_DAYS_OF_WEEK_,
			'devices'       => $this->user->getDevices()->map(function($s){
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
	 * @param  \App\Http\Requests\Clients\ReportRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( ReportRequest $request )
	{
		$data = $this->user->createReport( $request->all() );
		return response()->success( $this->getMessageFront( 'STORE' ), $data, route( $this->entity . '.index' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Clients\ReportRequest $request
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( ReportRequest $request, $id )
	{
		$data = $this->user->findMyReport( $id );
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
		$data = $this->user->findMyReport( $id );
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $data->getShortName() );
		$data->delete();

		return new JsonResponse( [
			'status'  => 1,
			'message' => $data,
		], 200 );
	}

	/**
	 * display the specified resource from storage.
	 *
	 * @param  $id
	 *
	 */
	public function display( $id ) {
		$data = $this->user->findMyReport( $id );
	}
}
