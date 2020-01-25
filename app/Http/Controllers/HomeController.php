<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
	public $page = [];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
	    parent::__construct();
	    $this->page = (object) [
		    'auxiliar'    => array(),
		    'response'    => array(),
		    'page_title'  => 'Início',
		    'main_title'  => 'Início',
	    ];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $this->page->response = $this->user->getActiveDashboards();
	    return view( 'welcome')
		    ->with( 'Page', $this->page );
    }
}
