<img style="width: 100%;" src="{!! public_path().'/img/requisicion.jpg' !!}">

@foreach($requisiciones as $requisicion)
	
	<?php  
		$articulos = DB::table('articulos_requisiciones')->where('requisiciones_id', $requisicion->id)->get();
	?>

	@if($requisicion->bienes)
		<p style="position: absolute; top: 182px; font-size: 14px; left: 176px;"><strong>X</strong></p>
	@endif
	@if($requisicion->servicios)
		<p style="position: absolute; top: 182px; font-size: 14px; left: 306px;"><strong>X</strong></p>
	@endif
	@if($requisicion->otros)
		<p style="position: absolute; top: 182px; font-size: 14px; left: 418px;"><strong>X</strong></p>
	@endif

	<p style="position: absolute; top: 185px; font-size: 14px; left: 68px;">{{$requisicion->fecha}}</p>
	<p style="position: absolute; top: 185px; font-size: 14px; left: 525px;">{{$requisicion->codigo}}</p>
	<p style="position: absolute; top: 245px; font-size: 12px; left: 350px;">{{$requisicion->funcionario}}</p>
	<p style="position: absolute; top: 245px; font-size: 12px; left: 100px;">{{DB::table('unidades')->where('id', $requisicion->unidad_id)->pluck('nombre')}}</p>
	
	<table style="position: absolute; top: 336px; left: 65px; width: 600px;">
		<tbody>
			@foreach($articulos as $articulo)
				<?php 
					$precio_unitario = DB::table('articulos_compra')->where('articulos_requisiciones_id', $articulo->id)->pluck('precio_unitario'); 

				?>
				<tr>
					<td style="font-size: 10px; padding-bottom: 5px;" width="14%">{{$articulo->partida}}</td>
					<td style="font-size: 12px; padding-bottom: 5px; text-align: center;" width="31%" >{{$articulo->descripcion}}</td>
					<td style="font-size: 12px; padding-bottom: 5px; text-align: center;" width="12%">{{$articulo->unidad}}</td>
					<td style="font-size: 12px; padding-bottom: 5px;" width="12%">{{$articulo->cantidad_solicitada}}</td>
					<td style="font-size: 12px; padding-bottom: 5px;" width="12%">{{$articulo->cantidad_adquirida}}</td>
					<td style="font-size: 12px; padding-bottom: 5px;" width="12%">@if(!$precio_unitario) 0 @else {{$precio_unitario}} @endif</td>
					<td style="font-size: 12px; padding-bottom: 5px;" width="12%">{{$precio_unitario * $articulo->cantidad_solicitada}}</td>
				</tr>

			@endforeach
		</tbody>
	</table>

	<p style="position: absolute; top: 673px; font-size: 12px; left: 75px; max-width: 550px;">{{$requisicion->observacion}}</p>
	
@endforeach