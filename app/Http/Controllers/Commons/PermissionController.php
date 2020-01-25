<?php

namespace App\Http\Controllers\Commons;

use App\Http\Requests\Clients\SubClientRequest;
use App\Models\Clients\SubClient;
use App\Models\Commons\SensorType;
use App\Models\Users\Permission;
use App\Models\Users\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class PermissionController extends Controller {

	public $entity = "permissions";
	public $sex = "M";
	public $name = "Permissão";
	public $names = "Permissões";
	public $main_folder = 'pages.admin.permissions';
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
		$data = Role::get();
		$this->page->response = $data->map( function ( $s ) {
			return [
				'entity'          => 'permissions',
				'id'              => $s->id,
				'code'            => $s->name,
				'name'            => $s->display_name,
				'description'     => $s->description
			];
		} );
		return view( $this->main_folder . '.index' )
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
		$data                   = Role::findOrFail( $id );
		$this->page->auxiliar   = [
			'permissions'   => Permission::get()
		];
		$this->page->main_title .= ' - Editar';
		return view( $this->main_folder . '.master' )
			->with( 'Data', $data )
			->with( 'Page', $this->page );
	}

	/**
	 * Store the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Clients\SubClientRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( SubClientRequest $request)
	{
		$data = $this->client->createSubClient( $request->all() );
		return $this->redirect( 'STORE', $data );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Clients\SubClientRequest $request
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( SubClientRequest $request, $id )
	{
		$data = $this->client->findMySubClient( $id );
		$data->update( $request->all() );
		return $this->redirect( 'UPDATE', $data );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Clients\SubClient $sub_client
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy( SubClient $sub_client ) {
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $sub_client->getShortName() );
		$sub_client->delete();

		return new JsonResponse( [
			'status'  => 1,
			'message' => $message,
		], 200 );
	}

}
