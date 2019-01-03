<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class gerenciasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	function vista(){
		$gerencias = DB::table('gerencias')->get();
		return view('gerencias', ['gerencias' => $gerencias]);
	}

	function crear(Request $request){
		$gerencia_id = 0;

		$nombre = $request->nombre;
		$prefijo = $request->prefijo;
		$gerencia_id = DB::table('gerencias')->insertGetId(['nombre' => $nombre, 'prefijo' => $prefijo]);
		DB::table('unidades')->insert(['nombre' => 'Oficina Gerencia '.$nombre, 'gerencia_id' => $gerencia_id]);
		return redirect()->back()->with('alert', 'Gerencia creada');
	}

	function editar(Request $request, $id){
		$nombre = $request->nombre;
		$prefijo = $request->prefijo;
		DB::table('gerencias')->where('id', $id)->update(['nombre' => $nombre, 'prefijo' => $prefijo]);
		return redirect()->back()->with('alert', 'Gerencia editada');
	}

	function eliminar($id){
		DB::table('gerencias')->where('id', $id)->delete();
		return redirect()->back()->with('alert', 'Gerencia eliminada');
	}



}
