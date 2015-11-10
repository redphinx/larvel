<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class pagesController extends Controller {
	// public function about(){
	// $name = 'Tray Column';
	// return view('pages.about')->with('name',$name);
	// }
	//my menue making
	
	public function about() {
		$data = [ 
				'The Tray Column Designed uses normal specifications to form a diagram representation of an inside of a tray column.',
				'The calulations for the tray column are done with superficail velocities',
				'Calulations go all the way up to pressure drop' 
		];
		$name = 'Tray Column';
		return view ( 'pages.about', compact ( 'data' ) )->with ( 'name', $name );
	}
	public function aboutLaravel() {
		$data = [
				'The Tray Column Designed uses normal specifications to form a diagram representation of an inside of a tray column.',
				'The calulations for the tray column are done with superficail velocities',
				'Calulations go all the way up to pressure drop'
		];
		return view ( 'pages.aboutLaravel',compact ( 'data' ));
	}
	public function about2() { // array pure practice
		$name = 'Tray Column';
		return view ( 'pages.about' )->with ( [ 
				'first' => 'tray',
				'last' => 'column' 
		]
	);
	}
	public function welcome() { // array
		$message = 'worked';//nothing done just testing
		return view ( 'welcome', compact ( 'message' ) );
	}
	public function tray() { 
		
		$mov = Request::get ( 'mov' );
		$vfr = Request::get ( 'vfr' );
		$mol = Request::get ( 'mol' );
		$lfr = Request::get ( 'lfr' );
		$p = Request::get ( 'p' );
		$r = Request::get ( 'r' );
		$sigma = Request::get ( 'sigma' );
		$f = Request::get ( 'f' );
		$rou = Request::get ( 'rou' );
		$t = Request::get ( 't' );
		
		// return Request::all();
		return view ( 'pages.tray', compact ( 'mov', 'vfr', 'mol', 'lfr', 'p', 'r', 'f', 'rou','t' ) );
	}
}
