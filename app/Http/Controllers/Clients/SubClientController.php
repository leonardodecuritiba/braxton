<?php

namespace App\Http\Controllers\Clients;

use App\Http\Requests\Clients\SubClientRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class SubClientController extends Controller {

	public $entity = "sub_clients";
	public $sex = "M";
	public $name = "Operador";
	public $names = "Operadores";
	public $main_folder = 'pages.sub_clients';
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
			'page_title'  => 'Meus Operadores',
			'main_title'  => 'Meus Operadores',
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
		$data = $this->user->getSubclients();
		$this->page->response = $data->map( function ( $s ) {
			return [
				'entity'          => $this->entity,
				'id'              => $s->id,
				'name'            => $s->getShortName(),
				'email'           => $s->getShortEmail(),
				'client'          => $s->getClientName(),
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
		$data                   = $this->user->findMySubClient( $id );
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
		$data = $this->user->createSubClient( $request->all() );
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
		$data = $this->user->findMySubClient( $id );
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
		$data = $this->user->findMySubClient( $id );
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $data->getShortName() );
		$data->delete();

		return new JsonResponse( [
			'status'  => 1,
			'message' => $message,
		], 200 );
	}

}
