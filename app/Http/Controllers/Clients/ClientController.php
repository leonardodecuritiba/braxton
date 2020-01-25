<?php

namespace App\Http\Controllers\Clients;

use App\Http\Requests\Clients\ClientRequest;
use App\Models\Clients\Client;
use App\Models\Commons\CepStates;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class ClientController extends Controller
{
    public $entity = "clients";
    public $sex = "M";
    public $name = "Cliente";
    public $names = "Clientes";
    public $main_folder = 'pages.clients';
	public $page = [];

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
		    'page_title'  => 'Clientes',
		    'main_title'  => 'Clientes',
		    'noresults'   => '',
		    'tab'         => 'data'
	    ];
	    $this->breadcrumb($route);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $data = Client::all();
	    $this->page->response = $data->map( function ( $s ) {
		    return [
			    'entity'          => $this->entity,
			    'id'              => $s->id,
			    'name'            => $s->getShortName(),//Nome/Razão Social
			    'email'           => $s->getShortEmail(),//Nome/Razão Social
			    'created_at'      => $s->getCreatedAtFormatted(),
			    'created_at_time' => $s->getCreatedAtTime(),
			    'active'          => $s->user->getActiveFullResponse()//Status
		    ];
	    } );
	    return view( 'pages.clients.index' )
		    ->with( 'Page', $this->page );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    $this->page->main_title .= ' - Novo';
        $this->page->auxiliar['states'] = CepStates::getAlltoSelectList(['id', 'description']);
        return view('pages.clients.master')
	        ->with( 'Page', $this->page );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Clients\ClientRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
	    $data = Client::create($request->all());
	    return $this->redirect( 'STORE', $data );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clients\Client $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
	    $this->page->main_title .= ' - Editar';
        $this->page->auxiliar['states'] = CepStates::getAlltoSelectList(['id', 'description']);
        return view('pages.clients.master')
            ->with('Page', $this->page)
            ->with('Data', $client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Clients\ClientRequest $request
     * @param  \App\Models\Clients\Client $client
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, Client $client)
    {
        $client->update($request->all());
	    return $this->redirect( 'UPDATE', $client );
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
		$data = Client::findOrFail( $id );
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $data->getShortName() );
		$data->delete();

		return new JsonResponse( [
			'status'  => 1,
			'message' => $message,
		], 200 );
	}
}
