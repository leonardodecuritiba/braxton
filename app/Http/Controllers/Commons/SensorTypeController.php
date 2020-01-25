<?php

namespace App\Http\Controllers\Commons;

use App\Http\Requests\Commons\SensorTypeRequest;
use App\Models\Commons\SensorType;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class SensorTypeController extends Controller {

	public $entity = "sensor_types";
	public $sex = "M";
	public $name = "Tipo de Sensor";
	public $names = "Tipo de Sensores";
	public $main_folder = 'pages.admin.sensor_types';
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
			'page_title'  => 'Tipos de Sensores',
			'main_title'  => 'Tipos de Sensores',
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
		$this->page->response = SensorType::all()->map( function ( $s ) {
			return [
				'entity'          => $this->entity,
				'id'              => $s->id,
				'name'            => $s->getName(),
				'code'            => $s->code,
				'description'     => $s->description,
				'scale'           => $s->scale . ' (' . $s->scale_name . ')',
				'range'           => $s->getRangeText(),
				'type'            => $s->getType(),
				'n_sensors'       => $s->getSensorsCount(),
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
	public function create() {
		$this->page->main_title .= ' - Novo';
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
		$data                   = SensorType::findOrFail( $id );
		$this->page->main_title .= ' - Editar';
		return view( $this->main_folder . '.master' )
			->with( 'Data', $data )
			->with( 'Page', $this->page );
	}

	/**
	 * Store the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Commons\SensorTypeRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( SensorTypeRequest $request)
	{
		$data = SensorType::create( $request->all() );
		return $this->redirect( 'STORE', $data );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Commons\SensorTypeRequest $request
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( SensorTypeRequest $request, $id )
	{
		$data = SensorType::findOrFail( $id );
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
	public function destroy( $id )
	{
		$data = SensorType::findOrFail( $id );
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $data->getShortName() );
		$data->delete();

		return new JsonResponse( [
			'status'  => 1,
			'message' => $message,
		], 200 );
	}

}
