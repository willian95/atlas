<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use PDF;

class reportesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	function vista(){
		$gerencias = DB::table('gerencias')->get();
		return view('reportes', ['gerencias' => $gerencias]);
	}

	function vista_pdf(){
		$gerencias = DB::table('gerencias')->get();
		return view('reportes_pdf', ['gerencias' => $gerencias]);
	}

	function etiquetas_unidad(Request $request){
		$gerencia = $request->gerencia;
		$unidad = $request->unidad;

		$bienes = DB::table('bienes')
						->where('gerencia_id', $gerencia)
						->where('unidad_id', $unidad)						
						->get();

		$html = view('pdf.etiquetas')->with('etiquetas', $bienes)->render();
		return PDF::load($html)->show();

	}

	function reportes_unidad(Request $request){
		$gerencia = $request->gerencia;
		$unidad = $request->unidad;

		$gerencia_nombre = DB::table('gerencias')->where('id', $gerencia)->pluck('nombre');
		$unidad_nombre = DB::table('unidades')->where('id', $unidad)->pluck('nombre');

		$bienes = DB::table('bienes')
						->where('gerencia_id', $gerencia)
						->where('unidad_id', $unidad)						
						->get();

		$html = view('pdf.reportes')->with('bienes', $bienes)->with('unidad', $unidad_nombre)->with('gerencia', $gerencia_nombre)->render();
		return PDF::load($html)->show();

	}

	function etiquetas_gerencia(Request $request){
		$gerencia = $request->gerencia;

		$bienes = DB::table('bienes')
						->where('gerencia_id', $gerencia)					
						->get();

		$html = view('pdf.etiquetas')->with('etiquetas', $bienes)->render();
		return PDF::load($html)->show();
	}

	function reportes_gerencia(Request $request){
		
		$gerencia = $request->gerencia;
		$gerencia_nombre = DB::table('gerencias')->where('id', $gerencia)->pluck('nombre');

		$html = view('pdf.reporte_gerencia')->with('gerencia', $gerencia)->with('gerencia_nombre', $gerencia_nombre)->render();
		return PDF::load($html)->show();

	}

}
