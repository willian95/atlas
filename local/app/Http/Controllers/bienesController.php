<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class bienesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	
	function vista(){

		$usuario = $this->tomarUsuario();

		$gerencias = DB::table('gerencias')->get();
		$unidades = DB::table('unidades')->get();

		if($usuario->role_id == 0){
			$unidades_gerencia = DB::table('gerencias')
									->join('unidades', 'unidades.gerencia_id', '=', 'gerencias.id')
									->get();
		}
		else{

			$gerencia_id = DB::table('unidades')->where('id', $usuario->unidad_id)->pluck('gerencia_id');
			$unidades_gerencia = DB::table('gerencias')
									->join('unidades', 'unidades.gerencia_id', '=', 'gerencias.id')
									->where('gerencias.id', $gerencia_id)
									->get();
		}


		return view('bienes', ['gerencias' => $gerencias, 'unidades' => $unidades, 'unidades_gerencia' => $unidades_gerencia]);
	}

	function unidades($id){
		$unidades = DB::table('unidades')->where('gerencia_id', $id)->get();
		return \Response::json($unidades);
	}

	function crear(Request $request){

		$fecha = date('d-m-Y');
		$contador = 0;
		$gerencia_id = $request->gerencia;
		$unidad_id = $request->unidad;
		$descripcion = $request->descripcion;
		$modelo = $request->modelo;
		$marca = $request->marca;
		$serial = $request->serial;
		$vida_util = $request->vida_util;
		$observacion = $request->observacion;

		if(!is_numeric($vida_util)){
			return redirect()->back()->with('alert', 'Vida util debe ser en numeros');
		}

		if(!$vida_util)
			$vida_util = 'No Posee';

		if(!$modelo)
			$modelo = 'Sin Modelo';

		if(!$marca)
			$marca = 'Sin Marca';

		if(!$serial)
			$serial = 'Sin Serial';
		
		$prefijo_producto = strtoupper(substr($descripcion, 0, 5));
		$prefijo_producto = str_replace(' ', '_', $prefijo_producto);
		$codigo_general = DB::table('bienes')->where('codigo_general', 'like', '%'.$prefijo_producto.'%')->orderBy('id', 'desc')->take(1)->pluck('codigo_general');
		$contador_general = substr($codigo_general, strpos('-',$codigo_general)+11);

		if(!$contador_general){
			$contador_general = 0;
		}

		$contador_general = intval($contador_general);
		$contador_general++;

		$ceros_izquierda = '';

		if($contador_general < 10){
			$ceros_izquierda_general = '00000';
		}

		else if($contador_general < 100){
			$ceros_izquierda_general = '0000';
		}

		else if($contador_general < 1000){
			$ceros_izquierda_general = '000';
		}

		else if($contador_general < 10000){
			$ceros_izquierda_general = '00';
		}

		$codigo_general = "ZF-".$prefijo_producto.$ceros_izquierda_general.$contador_general;

		$codigo_general = str_replace(' ', '_', $codigo_general);

		DB::table('bienes')->insert(['gerencia_id' => $gerencia_id, 'unidad_id' => $unidad_id, 'descripcion' => $descripcion, 'modelo' => $modelo, 'marca' => $marca, 'serial' => $serial, 'codigo_general' => $codigo_general, 'fecha' => $fecha, 'eliminado' => 0, 'observacion' => $observacion]);

		return redirect()->back()->with('alert', 'Bien insertado');

	}

	function importar_archivo(Request $request){

		
		$file = $request->file('archivo');
		$gerencia_id = $request->gerencia;
		$unidad_id = $request->unidad;

        \Excel::load($file, function($reader) use($gerencia_id, $unidad_id) {
   			 // Getting all results
    		$results = $reader->get();
    		// ->all() is a wrapper for ->get() and will work the same
    		$results = $reader->all();
    		$fecha = date('d-m-Y');
    		foreach ($results as $result) {

    			$descripcion = $result->descripcion;
				$modelo = $result->modelo;
				$marca = $result->marca;
				$serial = $result->serial;
				$observacion = $result->observaciones;

    			$prefijo_producto = strtoupper(substr($descripcion, 0, 5));
    			$prefijo_producto = str_replace(' ', '_', $prefijo_producto);

				$codigo_general = DB::table('bienes')
										->where('codigo_general', 'like', '%'.$prefijo_producto.'%')
										->orderBy('id', 'desc')
										->take(1)
										->pluck('codigo_general');

				$ceros_izquierda = '';

				$contador_general = substr($codigo_general, strpos('-',$codigo_general)+11);
				if(!$contador_general){
					$contador_general = 0;
				}

				$contador_general = intval($contador_general);
				$contador_general++;

				if($contador_general < 10){
					$ceros_izquierda_general = '00000';
				}

				else if($contador_general < 100){
					$ceros_izquierda_general = '0000';
				}

				else if($contador_general < 1000){
					$ceros_izquierda_general = '000';
				}

				else if($contador_general < 10000){
					$ceros_izquierda_general = '00';
				}

				$codigo_general = "ZF-".$prefijo_producto.$ceros_izquierda_general.$contador_general;
				$codigo_general = str_replace(' ', '_', $codigo_general);

				if($modelo == null){
					$modelo = 'Sin Modelo';
				}

				if($marca == null){
					$marca = 'Sin Marca';
				}

				if($serial == null){
					$serial = 'Sin Serial';
				}
				
				if($descripcion == null)
					break;
				
				

				DB::table('bienes')->insert(['descripcion' => $descripcion, 'modelo' => $modelo, 'marca' => $marca, 'serial' => $serial, 'observacion' => $observacion, 'gerencia_id' => $gerencia_id, 'unidad_id' => $unidad_id, 'codigo_general' => $codigo_general, 'fecha' => $fecha, 'eliminado' => 0]);

    		}

		});

		return redirect()->to('/bienes')->with('alert', 'Bienes insertados');

	}

	function editar(Request $request, $id){
		$descripcion = $request->descripcion;
		$modelo = $request->modelo;
		$marca = $request->marca;
		$serial = $request->serial;

		DB::table('bienes')->where('id', $id)->update(['descripcion' => $descripcion, 'modelo' => $modelo, 'marca' => $marca, 'serial' => $serial]);
		return redirect()->to('/bienes')->with('alert', 'Bien editado');
	}

	function eliminar($id){
		//DB::table('bienes')->where('id', $id)->update(['eliminado' => 1]);
		DB::table('bienes')->where('id', $id)->delete();
		return redirect()->to('/bienes')->with('alert', 'Bien eliminado');
	}

	function buscar(Request $request){
		$gerencias = DB::table('gerencias')->get();
		$unidades = DB::table('unidades')->get();
		$gerencia_id = $request->gerencia;
		$unidad_id = $request->unidad;
		$unidades_gerencia = DB::table('gerencias')
								->join('unidades', 'unidades.gerencia_id', '=', 'gerencias.id')
								->get();

		$bienes = DB::table('bienes')->where('gerencia_id', $gerencia_id)->where('unidad_id', $unidad_id)->where('eliminado', 0)->get();
		return view('bienes', ['bienes' => $bienes, 'gerencias' => $gerencias, 'unidades' => $unidades, 'unidades_gerencia' => $unidades_gerencia]);

	}

	function buscar_bienes(Request $request){
		
		$gerencias = DB::table('gerencias')->get();
		$unidades = DB::table('unidades')->get();
		$unidad_id = \Auth::user()->unidad_id;

		$gerencia_id = DB::table('unidades')->where('id', $unidad_id)->pluck('gerencia_id');
		$unidades_gerencia = DB::table('unidades')->where('gerencia_id', $gerencia_id)->get();

		$tipo = $request->tipo_busqueda;
		$texto = $request->buscarBienes;

		$bienes;

		if($tipo == 1){

			if($gerencia_id == 0){
				$bienes = DB::table('bienes')
							->where('serial', 'like','%'.$texto.'%')
							->get();
			}
			else{

				$bienes = DB::table('bienes')
							->where('gerencia_id', $gerencia_id)
							->where('serial', 'like','%'.$texto.'%')
							->get();
			}
		}

		else if($tipo == 2){

			if($gerencia_id == 0){
				$bienes = DB::table('bienes')
							->where('descripcion', 'like','%'.$texto.'%')
							->get();
			}
			else{
				$bienes = DB::table('bienes')
							->where('gerencia_id', $gerencia_id)
							->where('descripcion', 'like','%'.$texto.'%')
							->get();
			}
		}

		else if($tipo == 3){

			if($gerencia_id == 0){
				$bienes = DB::table('bienes')
							->where('gerencia_id', $gerencia_id)
							->where('modelo', 'like','%'.$texto.'%')
							->get();
			}
			else{
				$bienes = DB::table('bienes')
							->where('modelo', 'like','%'.$texto.'%')
							->get();
			}
		}

		else if($tipo == 4){

			if($gerencia_id == 0){
				$bienes = DB::table('bienes')
							->where('gerencia_id', $gerencia_id)
							->where('marca', 'like','%'.$texto.'%')
							->get();
			}
			else{
				$bienes = DB::table('bienes')
							->where('marca', 'like','%'.$texto.'%')
							->get();
			}
		}

		else if($tipo == 5){

			if($gerencia_id == 0){
				$bienes = DB::table('bienes')
							->where('codigo_general', 'like','%'.$texto.'%')
							->get();
			}
			else{
				$bienes = DB::table('bienes')
							->where('gerencia_id', $gerencia_id)
							->where('codigo_general', 'like','%'.$texto.'%')
							->get();
			}
		}

		return view('bienes', ['bienes' => $bienes, 'gerencias' => $gerencias, 'unidades' => $unidades, 'unidades_gerencia' => $unidades_gerencia]);

	}

	function buscar_gerente(Request $request, $id){
		$usuario = $this->tomarUsuario();
		$nombre_unidad = DB::table('unidades')->where('id', $id)->pluck('nombre');

		if(preg_match('/Oficina Gerencia/',$nombre_unidad)){

			$gerencias = DB::table('gerencias')->get();
			$unidades = DB::table('unidades')->get();
			$gerencia_id = DB::table('unidades')->where('id', $id)->pluck('gerencia_id');
			$unidad_id = $request->unidad;

			if($usuario->role_id == 0){
			$unidades_gerencia = DB::table('gerencias')
									->join('unidades', 'unidades.gerencia_id', '=', 'gerencias.id')
									->get();
			}
			else{

				$gerencia_id = DB::table('unidades')->where('id', $usuario->unidad_id)->pluck('gerencia_id');
				$unidades_gerencia = DB::table('gerencias')
										->join('unidades', 'unidades.gerencia_id', '=', 'gerencias.id')
										->where('gerencias.id', $gerencia_id)
										->get();
			}

			$bienes = DB::table('bienes')->where('gerencia_id', $gerencia_id)->where('unidad_id', $unidad_id)->get();
			return view('bienes', ['bienes' => $bienes, 'gerencias' => $gerencias, 'unidades' => $unidades, 'unidades_gerencia' => $unidades_gerencia]);

		}
		else{
			return redirect()->back();
		}
	}

	function tomarUsuario(){
		return \Auth::user();
	}

}
