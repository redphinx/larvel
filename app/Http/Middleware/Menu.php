<?php

namespace App\Http\Middleware;

use Closure;

class OldMiddleware {
	/**
	 * Run the request filter.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param \Closure $next        	
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		// my menue making
		Menu::make ( 'MyNavBar', function ($menu) {
			$menu->add ( 'Welcome' );
			$menu->add ( 'About', 'about' );
		} );
		return $next ( $request );
	}
	{!! menu !!}
}