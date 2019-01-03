<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use PDF;
use Illuminate\Http\Request;

class ordenesCompraController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	function vista($requisicion){

		$requisiciones = DB::table('requisiciones')
						->join('unidades', 'requisiciones.unidad_id', '=', 'unidades.id')
						->where('requisiciones.id', $requisicion)
						->select('requisiciones.id', 'unidades.nombre', 'requisiciones.codigo')
						->get();

		$articulos = DB::table('articulos_requisiciones')
							->where('requisiciones_id', $requisicion)
							->get();

		$proveedores = DB::table('proveedores')
							->get();

		return view('ordenes_compra.orden_compra', ['requisiciones' => $requisiciones, 'articulos' => $articulos, 'proveedores' => $proveedores]);
	}

	function vistaAdministrador(){

		$ordenes = DB::table('ordenes_compra')
						->join('requisiciones', 'ordenes_compra.requisicion_id', '=', 'requisiciones.id')
						->select('requisiciones.codigo', 'ordenes_compra.fecha as fecha_orden_compra', 'requisiciones.fecha as fecha_requisicion', 'ordenes_compra.correlativo', 'ordenes_compra.id')
						->get();
		return view('ordenes_compra.ordenes_compra_administrador', ['ordenes' => $ordenes]);

	}

	function registrarCompra(Request $request, $id){
		$b = 0;
		$fecha = date('d-m-Y');
		$indexId = count($request->id);
		$b = $this->isExisteCompra($request, $id);
		
		$correlativo = DB::table('ordenes_compra')->orderBy('id', 'desc')->take(1)->pluck('correlativo');
		$correlativo++;

		if($b == 1){

			if($request->proveedor_id == 0){
				$id_proveedor = $this->registrarProveedor($request->proveedor, $request->rif, $request->direccion, $request->telefono);
			}
			else{
				$this->editarProveedor($request->proveedor, $request->rif, $request->direccion, $request->telefono, $request->proveedor_id);
				$id_proveedor = $request->proveedor_id;
			}

			$orden_compra_id = DB::table('ordenes_compra')->insertGetId(['requisicion_id' => $id, 'fecha' => $fecha, 'proveedor_id' => $id_proveedor, 'correlativo' => $correlativo]);
			$id_proveedor;

			for($i = 0; $i < $indexId; $i++){

				if($request->input('cantidad.'.$i) > 0){

					$cantidad = $request->input('cantidad.'.$i);
					$id_articulo = $request->input('id.'.$i);
					$precio_unitario = $request->input('precio_unitario.'.$i);
					
					DB::table('articulos_compra')->insert(['articulos_requisiciones_id' => $id_articulo, 'orden_compra_id' => $orden_compra_id, 'precio_unitario' => $precio_unitario, 'cantidad' => $cantidad]);
					$this->actualizarArticulosRequisiciones($id_articulo, $cantidad);

				}

			}

			$this->actualizarRequiscion($id);
			return redirect()->to('/requisiciones_administrador');
		}
		else{
			return redirect()->back()->with('alert', 'Ningún producto fue comprado');
		}
		
	}

	function isExisteCompra($request, $id){
		$b=0;
		$indexId = count($request->id);
		for($i = 0; $i < $indexId; $i++){

			if($request->input('cantidad.'.$i) > 0){
				$b = 1;
			}

		}
		return $b;
	}

	function registrarProveedor($nombre, $rif, $direccion, $telefono){

		$proveedor_id = DB::table('proveedores')->insertGetId(['nombre' => $nombre, 'rif' => $rif, 'direccion' => $direccion, 'telefono' => $telefono]);
		return $proveedor_id;
	}

	function editarProveedor($nombre, $rif, $direccion, $telefono, $id){
		DB::table('proveedores')->where('id', $id)->update(['nombre' => $nombre, 'rif' => $rif, 'direccion' => $direccion, 'telefono' => $telefono]);
	}

	function actualizarArticulosRequisiciones($articulos_requisiciones_id, $cantidad_comprada){
		$cantidad = DB::table('articulos_requisiciones')->where('id', $articulos_requisiciones_id)->pluck('cantidad_adquirida');
		$cantidad = $cantidad + $cantidad_comprada;
		DB::table('articulos_requisiciones')->where('id', $articulos_requisiciones_id)->update(['cantidad_adquirida' => $cantidad]);
	}

	function actualizarRequiscion($id){
		$cantidad = DB::table('articulos_requisiciones')->where('requisiciones_id', $id)->count();
		$i = 0;
		$articulos_requisiciones = DB::table('articulos_requisiciones')->where('requisiciones_id', $id)->get();

		foreach($articulos_requisiciones as $articulo_requisicion){

			if($articulo_requisicion->cantidad_solicitada == $articulo_requisicion->cantidad_adquirida){
				$i++;
			}

		}
		if($cantidad == $i){
			DB::table('requisiciones')->where('id', $id)->update(['status' =>'cerrada']);
		}


	}

	function getProveedores($id){
		
		$proveedores = DB::table('proveedores')->where('id', $id)->get();
		return \Response::json($proveedores);
	}

	function ordenCompraPdf($id){

		$requisicion_id = DB::table('ordenes_compra')->where('id', $id)->pluck('requisicion_id');
		$unidad_solicitante_id = DB::table('requisiciones')->where('id', $requisicion_id)->pluck('unidad_id');
		
		$unidad_solicitante = DB::table('unidades')->where('id', $unidad_solicitante_id)->pluck('nombre');
		$n_requisicion = DB::table('requisiciones')->where('id', $requisicion_id)->pluck('codigo');
		$fecha_compra = DB::table('ordenes_compra')->where('id', $id)->pluck('fecha');
		$proveedor = DB::table('ordenes_compra')
							->join('proveedores', 'ordenes_compra.proveedor_id', '=', 'proveedores.id')
							->where('ordenes_compra.id', $id)
							->pluck('proveedores.nombre');
		$rif = DB::table('ordenes_compra')
							->join('proveedores', 'ordenes_compra.proveedor_id', '=', 'proveedores.id')
							->where('ordenes_compra.id', $id)
							->pluck('proveedores.rif');
		$direccion = DB::table('ordenes_compra')
							->join('proveedores', 'ordenes_compra.proveedor_id', '=', 'proveedores.id')
							->where('ordenes_compra.id', $id)
							->pluck('proveedores.direccion');
		$telefono = DB::table('ordenes_compra')
							->join('proveedores', 'ordenes_compra.proveedor_id', '=', 'proveedores.id')
							->where('ordenes_compra.id', $id)
							->pluck('proveedores.telefono');

		$articulos = DB::table('articulos_compra')->where('orden_compra_id', $id)->get();

		$html = view('pdf.orden_compra')->with('unidad_solicitante', $unidad_solicitante)->with('numero_requisicion', $n_requisicion)->with('fecha_compra', $fecha_compra)->with('proveedor', $proveedor)->with('rif', $rif)->with('direccion', $direccion)->with('telefono', $telefono)->with('articulos', $articulos)->render();
		return PDF::load($html)->show();
	}


}
