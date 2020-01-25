<?php

namespace App\Http\Controllers\Clients;

use App\Http\Requests\Clients\SensorRequest;
use App\Models\Clients\Sensor;
use App\Models\Commons\SensorType;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class SensorController extends Controller {

	public $entity = "sensors";
	public $sex = "M";
	public $name = "Sensor";
	public $names = "Sensores";
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
			'page_title'  => 'Meus Sensores',
			'main_title'  => 'Meus Sensores',
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
		$data = $this->user->getSensors();
		$this->page->response = $data->map( function ( $s ) {
			return [
				'entity'          => 'sensors',
				'id'              => $s->id,
				'name'            => $s->getShortName(),
				'short_content'   => $s->getShortContent(),
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
	public function create( $device_id ) {
		$device = $this->user->findMyDevice( $device_id );
		$this->page->main_title         .= ' - Novo';
		$this->page->breadcrumb = [
			[ 'route' => route( 'index' ), 'text' => 'Home' ],
			[ 'route' => route( 'devices.index' ), 'text' => trans( 'global.devices.name') ],
			[ 'route' => route( 'devices.edit', $device->id), 'text' => $device->getShortName() ],
			[ 'route' => null, 'text' => trans( 'pages.view.CREATE', [ 'name' => $this->name ] ) ],
		];
		$this->page->auxiliar   = [
			'parent' => $device,
			'sensor_types' => SensorType::getAllActiveToSelectList(),
		];
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
		$data                            = $this->user->findMySensor( $id );
		$this->page->main_title         .= ' - Editar';
		$this->page->breadcrumb = [
			[ 'route' => route( 'index' ), 'text' => 'Home' ],
			[ 'route' => route( 'devices.index' ), 'text' => trans( 'global.devices.name') ],
			[ 'route' => route( 'devices.edit', $data->device_id), 'text' => $data->device->getShortName() ],
			[ 'route' => null, 'text' => trans( 'pages.view.EDIT', [ 'name' => $this->name ] ) ],
		];
		$this->page->auxiliar   = [
			'parent' => $data->device,
			'sensor_types' => SensorType::getAllActiveToSelectList(),
		];
		return view( $this->main_folder . '.master' )
			->with( 'Data', $data )
			->with( 'Page', $this->page );
	}
	/**
	 * Store the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Clients\SensorRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( SensorRequest $request )
	{
		$data = $this->user->createSensor( $request->all() );
		return $this->redirect( 'STORE', $data );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Clients\SensorRequest $request
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( SensorRequest $request, $id ) {
		$data = $this->user->findMySensor( $id );
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
		$data = $this->user->findMySensor( $id );
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $data->getShortName() );
		$data->delete();

		return new JsonResponse( [
			'status'  => 1,
			'message' => $message,
		], 200 );
	}
}
