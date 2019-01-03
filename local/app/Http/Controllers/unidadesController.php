<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class unidadesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	function vista(){
		$unidades = DB::table('unidades')->get();
		$gerencias = DB::table('gerencias')->get();
		return view('unidades', ['unidades' => $unidades, 'gerencias' => $gerencias]);
	}

	function crear(Request $request){
		$nombre = $request->nombre;
		$gerencia_id = $request->gerencia;
		DB::table('unidades')->insert(['nombre' => $nombre, 'gerencia_id' => $gerencia_id]);
		return redirect()->back()->with('alert', 'Unidad creada');
	}

	function editar(Request $request, $id){
		$nombre = $request->nombre;
		DB::table('unidades')->where('id', $id)->update(['nombre' => $nombre]);
		return redirect()->back()->with('alert', 'Unidad editada');
	}

	function eliminar($id){
		DB::table('unidades')->where('id', $id)->delete();
		return redirect()->back()->with('alert', 'Unidad eliminada');
	}

}
