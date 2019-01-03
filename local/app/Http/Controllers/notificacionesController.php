<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class notificacionesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	function vista(){

		$notificaciones = DB::table('traslados')
								->orWhere(function($query)
					            {
					            	$gerencia_id = DB::table('unidades')->where('id', \Auth::user()->unidad_id)->pluck('gerencia_id');
					                $query->where('gerencia_id', $gerencia_id)
					                      ->where('status', '<>', 'En espera');
					            })
					            ->orWhere(function($query)
					            {
					                $query->where('unidad_fin',  \Auth::user()->unidad_id)
					                      ->where('status', '<>', 'En espera');
					            })
					            ->get();

		$notificaciones_requisiciones = DB::table('requisiciones')
											->where('visto', 0)
											->where('requisiciones.unidad_id', \Auth::user()->unidad_id)
											->get();
													

		return view('notificaciones', ['notificaciones' => $notificaciones, 'notificaciones_requisiciones' => $notificaciones_requisiciones]);
	}

}
