<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use PDF;

class trasladosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	function vistaGerente(Request $request){
		$gerencias = DB::table('gerencias')->get();

		return view('traslados.trasladosGerente', ['gerencias' => $gerencias]);
	}

	function buscar($id){
		$bienes = DB::table('bienes')->where('id', $id)->get();
		return \Response::json($bienes);
	}

	function buscarBienes($texto, $tipo){

		$unidad_id = \Auth::user()->unidad_id;
		$nombre_unidad = DB::table('unidades')->where('id', $unidad_id)->pluck('nombre');
		
		if(preg_match('/Oficina Gerencia/',$nombre_unidad))
		{
				
			$gerencia_id = DB::table('unidades')->where('id', \Auth::user()->unidad_id)->pluck('gerencia_id');
			$bienes;

			if($tipo == 1){

				$bienes = DB::table('bienes')
								->where('gerencia_id', $gerencia_id)
								->where('serial', 'like','%'.$texto.'%')
								->get();
			}

			else if($tipo == 2){

				$bienes = DB::table('bienes')
								->where('gerencia_id', $gerencia_id)
								->where('descripcion', 'like','%'.$texto.'%')
								->get();
			}

			else if($tipo == 3){

				$bienes = DB::table('bienes')
								->where('gerencia_id', $gerencia_id)
								->where('modelo', 'like','%'.$texto.'%')
								->get();
			}

			else if($tipo == 4){

				$bienes = DB::table('bienes')
								->where('gerencia_id', $gerencia_id)
								->where('marca', 'like','%'.$texto.'%')
								->get();
			}

			else if($tipo == 5){

				$bienes = DB::table('bienes')
								->where('gerencia_id', $gerencia_id)
								->where('codigo_general', 'like','%'.$texto.'%')
								->get();
			}
			
			return \Response::json($bienes);
		}

	}

	function trasladar(Request $request, $unidad_fin){
		
		$motivo = $request->motivo;
		$index = count($request->id);
		$fecha = date('d-m-Y');

		$gerencia_id = DB::table('gerencias')
							->join('unidades', 'unidades.gerencia_id', '=', 'gerencias.id')
							->where('unidades.id', \Auth::user()->unidad_id)
							->pluck('gerencias.id');

		$gerencia_fin = DB::table('unidades')
							->where('id', $unidad_fin)
							->pluck('gerencia_id');

		$unidad_gerencia = DB::table('unidades')
								->where('nombre', 'like', '%oficina gerencia%')
								->where('gerencia_id', $gerencia_fin)
								->pluck('id');

		$unidad_id = DB::table('unidades')->where('gerencia_id', $gerencia_fin)->where('nombre', 'like', '%Oficina Gerencia%')->pluck('id');
		$responsable = DB::table('usuarios')->where('unidad_id', $unidad_id)->pluck('nombre');

		$traslados_id = DB::table('traslados')->insertGetId(['unidad_fin' => $unidad_fin, 'status' => 'En espera', 'motivo' => $motivo, 'fecha' => $fecha, 'gerencia_id' => $gerencia_id, 'responsable' => $responsable, 'gerencia_fin' => $gerencia_fin]);

		for($i = 0; $i < $index; $i++){

			$id = $request->input("id.".$i);
			$unidad_origen = DB::table('bienes')->where('id', $id)->pluck('unidad_id');

			DB::table('articulos_traslados')->insert(['traslados_id' => $traslados_id, 'bienes_id' => $id, 'unidad_origen' => $unidad_origen]);

		}

		return redirect()->back()->with('alert', 'Traslado realizado. Aguarde su respuesta');

	}

	function notificaciones(){

		$traslados = DB::table('traslados')->where('status', 'En espera')->get();

		return view('traslados.notificacion', ['traslados' => $traslados]);

	}

	function notas_entrega($traslado_id){

		$traslado = DB::table('traslados')->where('id', $traslado_id)->get();
		$unidad_fin = DB::table('traslados')->where('id', $traslado_id)->pluck('unidad_fin');
		$gerencia_id = DB::table('unidades')->where('id', $unidad_fin)->pluck('gerencia_id');
		DB::table('traslados')->where('id', $traslado_id)->update(['status' => 'aprobado']);

		$unidad_id = \Auth::user()->unidad_id;
      	$gerencia_user = DB::table('unidades')->where('id', $unidad_id)->pluck('gerencia_id');
			
		DB::table('traslados')->where('id', $traslado_id)->where('gerencia_fin', $gerencia_user)->update(['visto_fin' => '1']);

		DB::table('traslados')->where('id', $traslado_id)->where('gerencia_id', $gerencia_user)->update(['visto_inicio' => '1']);

		$articulos_traslados = DB::table('articulos_traslados')
									->join('bienes', 'articulos_traslados.bienes_id', '=', 'bienes.id')
									->where('traslados_id', $traslado_id)
									->get();

		foreach ($articulos_traslados as $articulo) {
			DB::table('bienes')
				->where('id', $articulo->id)
				->update(['gerencia_id' => $gerencia_id, 'unidad_id' => $unidad_fin]);
		}

		$html = view('pdf.notaEntrega')->with('traslados', $traslado)->render();
		return PDF::load($html)->show();

	}

	function notas_rechazo(Request $request, $traslado_id){

		$motivo = $request->motivo;
		DB::table('traslados')->where('id', $traslado_id)->update(['motivo_rechazo' => $motivo, 'status' => 'rechazado']);
		return redirect()->back()->with('alert', 'Traslado rechazado');

	}

	function historial(){
		$historiales = DB::table('traslados')->where('status', '!=', 'En espera')->get();
		return view('traslados.historial', ['traslados' => $historiales]);
	}

}
