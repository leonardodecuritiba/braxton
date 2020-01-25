<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController {
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public $user;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware( 'auth' );
		$this->middleware( function ( $request, $next ) {
			$this->user = Auth::user();
			return $next( $request );
		} );
	}

	/**
	 * Define getMessageFront.
	 *
	 * @param $type
	 * @param $data
	 *
	 * @return string
	 *
	 */
	public function redirect( $type, $data ) {
		return response()->success( $this->getMessageFront( $type ), $data, route( $this->entity . '.edit', $data->id ) );
	}

	/**
	 * Define getMessageFront.
	 *
	 * @param $type
	 *
	 * @return string
	 *
	 */
	public function getMessageFront( $type, $name = null ) {
		if ( $type == 'DELETE' ) {
			return trans( 'messages.crud.' . $this->sex . '.' . strtoupper( $type ) . '.SUCCESS', [ 'name' => $name ] );
		}

		return trans( 'messages.crud.' . $this->sex . '.' . strtoupper( $type ) . '.SUCCESS', [ 'name' => $this->name ] );
	}

	/**
	 * Define breadcrumb.
	 *
	 * @param  \Illuminate\Routing\Route $route
	 *
	 */
	public function breadcrumb( $route ) {
		$action                 = $route->getActionMethod();
		$this->page->page_title = trans( 'pages.view.' . strtoupper( $action ), [ 'name' => $this->names ] );
		$this->page->main_title = trans( 'pages.view.' . strtoupper( $action ), [ 'name' => $this->name ] );
		$this->page->noresults  = trans( 'pages.view.NORESULTS.' . $this->sex, [ 'name' => $this->name ] );

		switch ( $action ) {
//			case 'index':
//				$this->PageResponse->breadcrumb = [
//					['route'=>route('index'),'text'=>'Home'],
//					['route'=>NULL,'text'=> $this->names]
//				];
//				break;
			case 'create':
				$this->page->breadcrumb = [
					[ 'route' => route( 'index' ), 'text' => 'Home' ],
					[ 'route' => route( $this->entity . '.index' ), 'text' => $this->names ],
					[ 'route' => null, 'text' => trans( 'pages.view.CREATE', [ 'name' => $this->name ] ) ],
				];
				break;
			case 'edit':
				$this->page->breadcrumb = [
					[ 'route' => route( 'index' ), 'text' => 'Home' ],
					[ 'route' => route( $this->entity . '.index' ), 'text' => $this->names ],
					[ 'route' => null, 'text' => trans( 'pages.view.EDIT', [ 'name' => $this->name ] ) ],
				];
				break;
			default:
				$this->page->breadcrumb = [
					[ 'route' => route( 'index' ), 'text' => 'Home' ],
					[ 'route' => null, 'text' => $this->names ]
				];
				break;
		}
	}
}
