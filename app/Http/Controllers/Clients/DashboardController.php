<?php

namespace App\Http\Controllers\Clients;

use App\Helpers\BaseHelper;
use App\Http\Requests\Clients\DashboardRequest;
use App\Models\Clients\Dashboard;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class DashboardController extends Controller {

	public $entity = "dashboards";
	public $sex = "M";
	public $name = "Gráfico";
	public $names = "Gráficos";
	public $main_folder = 'pages.dashboards';
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
			'page_title'  => 'Meus Gráficos',
			'main_title'  => 'Meus Gráficos',
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
		$data = $this->user->getDashboards();
		$this->page->response = $data->map( function ( $s ) {
			return [
				'entity'          => $this->entity,
				'id'              => $s->id,
				'name'            => $s->getShortName(),
				'client'          => $s->getClientName(),
				'sensor'          => $s->getShortSensorName(),
				'sensor_type'     => $s->getShortSensorTypeName(),
				'period'          => $s->period,
				'created_at'      => $s->getCreatedAtFormatted(),
				'created_at_time' => $s->getCreatedAtTime(),
				'active'          => $s->getActiveFullResponse()
			];
		} );
		return view( $this->main_folder . '.index' )
			->with( 'Page', $this->page );
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$this->page->main_title .= ' - Novo';
		$this->page->auxiliar   = [
			'periods'   => array_slice(BaseHelper::$_DASHBOARD_PERIODS_, 0, 5),
			'bullets'   => BaseHelper::map_dashboard_bullets_text(5),
			'formats'   => BaseHelper::map_dashboard_formats_text(4),
			'sizes'     => BaseHelper::map_dashboard_sizes_text(3),
			'devices'       => $this->user->getActiveDevices()->map(function($s){
				return [
					'id'            => $s->id,
					'description'   => $s->getShortName()
				];
			})->pluck('description', 'id')
		];
		return view( 'pages.dashboards.master' )
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
		$data = $this->user->findMyDashboard( $id );
		$this->page->main_title         .= ' - Editar';
		$this->page->breadcrumb = [
			[ 'route' => route( 'index' ), 'text' => 'Home' ],
			[ 'route' => route( 'sensors.index' ), 'text' => trans( 'global.sensors.name') ],
			[ 'route' => route( 'sensors.edit', $data->sensor_id), 'text' => $data->sensor->getShortName() ],
			[ 'route' => route( 'dashboards.index' ), 'text' => trans( 'global.dashboards.name') ],
			[ 'route' => null, 'text' => trans( 'pages.view.EDIT', [ 'name' => $this->name ] ) ],
		];
		$this->page->auxiliar   = [
			'parent'    => $data->sensor,
			'periods'   => array_slice(BaseHelper::$_DASHBOARD_PERIODS_, 0, 5),
			'bullets'   => BaseHelper::map_dashboard_bullets_text(5),
			'formats'   => BaseHelper::map_dashboard_formats_text(4),
			'sizes'     => BaseHelper::map_dashboard_sizes_text(3),
		];

		return view( $this->main_folder . '.master' )
			->with( 'Data', $data )
			->with( 'Page', $this->page );
	}

	/**
	 * Store the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Clients\DashboardRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( DashboardRequest $request)
	{
		$data = $this->user->createDashboard( $request->all() );
		return $this->redirect( 'STORE', $data );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Clients\DashboardRequest $request
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( DashboardRequest $request, $id )
	{
		$data = $this->user->findMyDashboard( $id );
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
		$data = $this->user->findMyDashboard( $id );
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $data->getShortName() );
		$data->delete();

		return new JsonResponse( [
			'status'  => 1,
			'message' => $data,
		], 200 );
	}

}
