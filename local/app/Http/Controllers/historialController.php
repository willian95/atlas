<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class historialController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	function vista(){
		return view('historial.historial');
	}

	function registrar(Request $request){
		$unidad_id = \Auth::user()->unidad_id;
		$fecha = date('d-m-Y');
		$index = count($request->input('id'));
		$motivo = $request->motivo;

		for($i = 0; $i < $index; $i++){
			DB::table('historiales')->insert(['bien_id' => $request->input('id.'.$i), 'fecha' => $fecha, 'observacion' => $motivo, 'unidad_id' => $unidad_id]);
		}

		return redirect()->back()->with('alert', 'Movimiento registrado');

	}

	function vistaRegistro(){
		return view('historial.registro');
	}

	function vistaAdministrador(){
		return view('historial.registroAdministrador');
	}

	function buscarFecha(Request $request){
		
		$unidad_id = \Auth::user()->unidad_id;

		$fecha_inicio = $request->fecha_inicio;
		$fecha_fin = $request->fecha_fin;

		$historiales = DB::table('historiales')
							->join('bienes', 'historiales.bien_id', '=', 'bienes.id')
							->whereBetween('historiales.fecha', [$fecha_inicio, $fecha_fin])
							->where('historiales.unidad_id', $unidad_id)
							->select('bienes.codigo_general', 'bienes.serial', 'bienes.descripcion', 'bienes.marca', 'historiales.observacion','historiales.fecha', 'historiales.id')
							->get();

		return view('historial.registro', ['historiales' => $historiales]);
	}

	function buscarFechaAdministrador(Request $request){
		$fecha_inicio = $request->fecha_inicio;
		$fecha_fin = $request->fecha_fin;

		$historiales = DB::table('historiales')
							->join('bienes', 'historiales.bien_id', '=', 'bienes.id')
							->join('unidades', 'historiales.unidad_id', '=', 'unidades.id')
							->whereBetween('historiales.fecha', [$fecha_inicio, $fecha_fin])
							->select('bienes.codigo_general', 'bienes.serial', 'bienes.descripcion', 'bienes.marca', 'historiales.observacion','historiales.fecha', 'historiales.id', 'unidades.nombre')
							->get();

		return view('historial.registroAdministrador', ['historiales' => $historiales]);
	}

}