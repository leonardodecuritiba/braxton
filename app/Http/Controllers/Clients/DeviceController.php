<?php

namespace App\Http\Controllers\Clients;

use App\Http\Requests\Clients\DeviceRequest;
use App\Models\Clients\Device;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class DeviceController extends Controller {

	public $entity = "devices";
	public $sex = "F";
	public $name = "Controladora";
	public $names = "Controladoras";
	public $main_folder = 'pages.devices';
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
			'page_title'  => 'Meus Dispositivos',
			'main_title'  => 'Meus Dispositivos',
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
		$data = $this->user->getDevices();
		$this->page->response = $data->map( function ( $s ) {
			return [
				'entity'          => 'devices',
				'id'              => $s->id,
				'name'            => $s->getShortName(),
				'client'          => $s->getClientName(),
				'author'          => $s->getShortAuthorName(),
				'short_content'   => $s->getShortContent(),
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
	public function create()
	{
		$this->page->main_title .= ' - Novo';

		if($this->user->hasRole('admin')){
			$this->page->auxiliar['clients'] = $this->user->getActiveClients()->map( function ( $s ) {
				return [
					'id'              => $s->id,
					'name'            => $s->getShortName(),
				];
			})->pluck('name', 'id');
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
		$data                    = $this->user->findMyDevice( $id );
		$this->page->main_title .= ' - Editar';
		return view( $this->main_folder . '.master' )
			->with( 'Data', $data )
			->with( 'Page', $this->page );
	}

	/**
	 * Store the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Clients\DeviceRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( DeviceRequest $request)
	{
		$data = $this->user->createDevice( $request->all() );
		return $this->redirect( 'STORE', $data );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Clients\DeviceRequest $request
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( DeviceRequest $request, $id ) {
		$data = $this->user->findMyDevice( $id );
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
		$data = $this->user->findMyDevice( $id );
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $data->getShortName() );
		$data->delete();

		return new JsonResponse( [
			'status'  => 1,
			'message' => $data,
		], 200 );
	}
}
