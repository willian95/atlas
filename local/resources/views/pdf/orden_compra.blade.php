<img src="{!! public_path().'/img/cintillo.jpg' !!}" style="width: 100%;">

<h2 style="text-align: center;">ORDEN DE COMPRA</h2>
<table style="border: 1px solid; border-collapse: collapse; width: 100%; font-size: 13px; margin-bottom: 10px;">
	<tbody style="border: 1px solid;">
		<tr style="border: 1px solid;">
			<td style="border: 1px solid; font-size: 12px;" width="40%">
				<strong>Unidad Solicitante:</strong> {{$unidad_solicitante}}
			</td>
			<td style="border: 1px solid; font-size: 12px;" width="30%">
				<strong>Requisición N°:</strong> {{$numero_requisicion}}
			</td>
			<td style="border: 1px solid; font-size: 12px;" width="30%">
				<strong>Fecha:</strong> {{$fecha_compra}}
			</td>
		</tr>
		<tr style="border: 1px solid;">
			<td style="border: 1px solid; font-size: 12px;" width="40%">
				<strong>Nombre del proveedor:</strong> {{$proveedor}}
			</td>
			<td style="border: 1px solid; font-size: 12px;" width="30%">
				<strong>RIF:</strong> {{$rif}}
			</td>
			<td style="border: 1px solid; font-size: 12px;" width="30%">
				<strong>Código:</strong>
			</td>
		</tr>
		<tr style="border: 1px solid;">
			<td style="border: 1px solid; font-size: 12px;" colspan="2">
				<strong>Dirección:</strong> {{$direccion}}
			</td>
			<td style="border: 1px solid; font-size: 12px;" width="30%">
				<strong>Teléfono:</strong> {{$telefono}}
			</td>
		</tr>
		<tr style="border: 1px solid;">
			<td style="border: 1px solid; font-size: 12px;">
				<strong>Despachado a ZONFIPCA</strong>
			</td>
			<td style="border: 1px solid; font-size: 12px;">
				<strong>Condición de pago:</strong>
			</td>
			<td style="border: 1px solid; font-size: 12px;">
				<strong>Plazo de entrega:</strong>
			</td>
		</tr>
	</tbody>
</table>

<table style="border: 1px solid; border-collapse: collapse; width: 100%; font-size: 13px; margin-bottom: 10px;">
	<thead>
		<tr>
			<th style="border: 1px solid;">Partida</th>
			<th style="border: 1px solid;">Renglón</th>
			<th style="border: 1px solid;">Descripción</th>
			<th style="border: 1px solid;">Cantidad</th>
			<th style="border: 1px solid;">Precio Unitario</th>
			<th style="border: 1px solid;">Total</th>
		</tr>
	</thead>
	<tbody style="border: 1px solid;">
		@foreach($articulos as $articulo)
			<tr style="border: 1px solid;">
				<td style="border: 1px solid; font-size: 12px;">
					<?php 
						$articulos_requisiciones_id = DB::table('articulos_compra')->where('id', $articulo->id)->pluck('articulos_requisiciones_id');
						$partida = DB::table('articulos_requisiciones')->where('id', $articulos_requisiciones_id)->pluck('partida');
					?>
					{{$partida}}
				</td>
				<td style="border: 1px solid; font-size: 10px;">
					
				</td>
				<td style="border: 1px solid; font-size: 10px;">
					<?php 
						$articulos_requisiciones_id = DB::table('articulos_compra')->where('id', $articulo->id)->pluck('articulos_requisiciones_id');
						$descripcion = DB::table('articulos_requisiciones')->where('id', $articulos_requisiciones_id)->pluck('descripcion');
					?>
					{{$descripcion}}
					
				</td>
				<td style="border: 1px solid; font-size: 10px;">
					{{$articulo->cantidad}}
				</td>
				<td style="border: 1px solid; font-size: 10px;">
					{{number_format($articulo->precio_unitario, 2, ',', '.')}}
				</td>
				<td style="border: 1px solid; font-size: 10px;">
					<?php 
						$iva_pc = DB::table('articulos_compra')->where('id', $articulo->id)->pluck('iva');
						$subtotal=$articulo->cantidad * $articulo->precio_unitario;
						$iva = $subtotal * ($iva_pc/100);
						$total = $subtotal + $iva;
					?>
					{{number_format($total, 2, ',', '.')}}
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

<table style="border: 1px solid; border-collapse: collapse; width: 100%; font-size: 13px; margin-bottom: 10px; position: absolute; bottom: 40px;">
	<thead style="border: 1px solid; font-size: 10px;">
		<tr style="border: 1px solid; font-size: 10px;">
			<th style="border: 1px solid; font-size: 10px;">Nota de Entrega</th>
			<th style="border: 1px solid; font-size: 10px;">Factura</th>
			<th style="border: 1px solid; font-size: 10px;">Otro</th>
		</tr>
	</thead>
	<tbody>
		<tr style="border: 1px solid;">
			<td style="border: 1px solid; font-size: 10px;">
				N° <u></u>
			</td>
			<td style="border: 1px solid; font-size: 10px;">
				N° <u></u>
			</td>
			<td style="border: 1px solid; font-size: 10px;">
				N° <u></u>
			</td>
		</tr>
	</tbody>
</table>