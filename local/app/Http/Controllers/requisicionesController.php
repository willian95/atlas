<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use PDF;
use Illuminate\Http\Request;

class requisicionesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	function vista(){
		$partidas_raiz = DB::table('partidas_raiz')->get();
		return view('requisiciones.requisiciones', ['partidas_raiz' => $partidas_raiz]);
	}

	function administrador_vista(){
		$requisiciones = DB::table('requisiciones')->orderBy('id', 'desc')->get();
		return view('requisiciones.requisiciones_administrador', ['requisiciones' => $requisiciones]);
	}

	function contar_requisiciones(){
		$contar = DB::table('requisiciones')->where('visto', 0)->count();
		return \Response::json($contar);
	}

	function crear(Request $request){

		$unidad = \Auth::user()->unidad_id;
		$nombre_unidad = DB::table('unidades')->where('id', $unidad)->pluck('nombre');
		$nombre_funcionario = \Auth::user()->nombre;
		$bienes = $request->bienes;
		$servicios = $request->servicios;
		$otros = $request->otros;
		$observacion = $request->observacion;
		$count = count($request->descripcion);
		$fecha = $fecha = date('d-m-Y');
		$n_control = $n_control = DB::table('requisiciones')->orderBy('id', 'desc')->take(1)->pluck('control');
		$gerencia_id = DB::table('unidades')->where('id', $unidad)->pluck('gerencia_id');
		$prefijo_gerencia = DB::table('gerencias')->where('id', $gerencia_id)->pluck('prefijo');

		if($count <= 0){
			return redirect()->back()->with('alert', 'No se puede crear una requisición sin articulos');
		}

		else{
			if($bienes == 'on'){
				$bienes = 1;
			}
			else{
				$bienes = 0;
			}

			if($servicios == 'on'){
				$servicios = 1;
			}
			else{
				$servicios = 0;
			}

			if($otros == 'on'){
				$otros = 1;
			}
			else{
				$otros = 0;
			}

			$annio_ultimo = DB::table('requisiciones')->orderBy('id', 'desc')->take(1)->pluck('fecha');
			$annio_ultimo = substr($annio_ultimo, 6);

			$annio_actual = substr($fecha, 6);
			
			if($annio_actual == $annio_ultimo){
				$n_control++;
			}
			else if($annio_actual > $annio_ultimo){
				$n_control=1;
			}

			$control = $prefijo_gerencia."-".$n_control."-".$annio_actual;

			$requisiciones_id = DB::table('requisiciones')->insertGetId(['unidad_id' => $unidad, 'bienes' => $bienes, 'servicios' => $servicios, 'otros' => $otros, 'funcionario' => $nombre_funcionario, 'observacion' => $observacion, 'fecha' => $fecha, 'visto' => 0, 'usuario_id' => \Auth::user()->id, 'control' => $n_control, 'codigo' => $control, 'status' => 'abierta']);

			for($i = 0; $i < $count; $i++){
				
				$partida = $request->input('partida.'.$i);
				$descripcion = $request->input('descripcion.'.$i);
				$unidad = $request->input('unidad.'.$i);
				$cantidad = $request->input('cantidad.'.$i);

				DB::table('articulos_requisiciones')->insert(['partida' => $partida, 'descripcion' => $descripcion, 'unidad' => $unidad, 'cantidad_solicitada' => $cantidad, 'requisiciones_id' => $requisiciones_id]);

			}

			return redirect()->back()->with('alert', 'Requisicion creada');
		}

	}

	function historial(){

		$requisiciones = DB::table('requisiciones')->where('unidad_id', \Auth::user()->unidad_id)->get();
		return view('requisiciones.requisiciones_historial', ['requisiciones' => $requisiciones]);

	}

	function pdf($id){
		
		if(\Auth::user()->role_id == 300){
			$requisiciones = DB::table('requisiciones')->where('id', $id)->get();
		}
		else{
			$requisiciones = DB::table('requisiciones')
									->where('id', $id)
									->where('usuario_id', \Auth::user()->id)
									->get();
		}
		
		if($requisiciones){
			$html = view('pdf.requisicion')->with('requisiciones', $requisiciones)->render();
			return PDF::load($html)->show();
		}
		else{
			return redirect()->back()->with('alert', 'Requisición no encontrada');
		}
		
	}

	public function compra($id){

		DB::table('articulos_requisiciones')
			->join('requisiciones', 'articulos_requisiciones.requisiciones_id', '=', 'requisiciones.id')
			->where('articulos_requisiciones.id', $id)
			->update(['requisiciones.visto' => 0]);

		return redirect()->back()->with('alert', 'Producto comprado');

	}

	public function ver_articulo($id){
		DB::table('requisiciones')->where('id', $id)->update(['visto' => 1]);
		return \Response::json('hey');
	}

}
