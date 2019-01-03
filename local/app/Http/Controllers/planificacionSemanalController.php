<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use PDF;
use Illuminate\Http\Request;

class planificacionSemanalController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	function vista(){
		$annio = date("Y");
		$unidad_id = \Auth::user()->unidad_id;
		$gerencia_id = DB::table('unidades')->where('id', $unidad_id)->pluck('gerencia_id');

		$metas = DB::table('POA')->where('gerencia_id', $gerencia_id)->orderBy('id', 'desc')->get();
		$semanas = DB::table('actividades_semanales')->groupby('semana')->distinct()->get();

		return view('planificacion_semanal.planificacionSemanal',  ['metas' => $metas, 'semanas' => $semanas, 'gerencia_id' => $gerencia_id]);
	}

	function vistaAdministrador(){

		$gerencias = DB::table('gerencias')->get();
		$semanas = DB::table('actividades_semanales')->groupby('semana')->distinct()->get();

		return view('planificacion_semanal.planificacionSemanalAdministrador', ['gerencias' => $gerencias, 'semanas' => $semanas]);
	}

	function vistaAdministradorActividades($id){
		$annio = date("Y");

		$semanas = DB::table('actividades_semanales')->groupby('semana')->distinct()->get();	
		return view('planificacion_semanal.planificacionSemanalAdministradorActividades', ['semanas' => $semanas, 'gerencia_id' => $id]);
	}

	function generarReporte(Request $request){

		$annio = date("Y");
		$gerencias = DB::table('gerencias')->get();
		$semana = $request->semana;

		$html = view('pdf.actividades_semanales')->with('gerencias', $gerencias)->with('semana', $semana)->render();
		return PDF::load($html)->show();

	}

	function registrarPoa(Request $request){

		$titulo = $request->titulo;
		$descripcion = $request->descripcion;
		$unidad_id = \Auth::user()->unidad_id;
		$gerencia_id = DB::table('unidades')->where('id', $unidad_id)->pluck('gerencia_id');

		DB::table('POA')->insert(['titulo' => $titulo, 'descripcion' => $descripcion, 'gerencia_id' => $gerencia_id]);

		return redirect()->back()->with('alert', 'Meta del POA registrada');

	}

	function registrarSemanal(Request $request){

		$descripcion = $request->descripcion;
		$unidad_id = \Auth::user()->unidad_id;
		$gerencia_id = DB::table('unidades')->where('id', $unidad_id)->pluck('gerencia_id');
		$semana = date('W');
		$fecha = date('d-m-Y');
		$annio = date("Y");
		$semana = intval($semana);

		DB::table('actividades_semanales')->insert(['descripcion' => $descripcion, 'gerencia_id' => $gerencia_id, 'semana' => $semana, 'fecha' => $fecha, 'annio' => $annio]);

		return redirect()->back()->with('alert', 'Actividad semanal registrada');

	}

	function editarPoa($id){

		$meta = DB::table('POA')->where('id', $id)->get();

		return view('planificacion_semanal.editarPoa',['meta' => $meta]); 

	}

}
