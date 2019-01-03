<img style="width: 100%;" src="{!! public_path().'/img/nota_entrega.jpg' !!}">

@foreach($traslados as $traslado)

<?php
	$gerencia = DB::table('gerencias')->where('id', $traslado->gerencia_id)->pluck('nombre');
	$nombre_gerencia = "Oficina Gerencia ".$gerencia;

	$unidad_id = DB::table('unidades')->where('nombre', $nombre_gerencia)->pluck('id');
	$responsable = DB::table('usuarios')->where('unidad_id', $unidad_id)->pluck('nombre');

	$reponsable_final = DB::table('usuarios')->where('unidad_id', $traslado->unidad_fin)->pluck('nombre');
	$unidad_final = DB::table('unidades')->where('id', $traslado->unidad_fin)->pluck('nombre');

	$articulos = DB::table('articulos_traslados')
						->join('bienes', 'articulos_traslados.bienes_id', '=', 'bienes.id')
						->where('traslados_id', $traslado->id)
						->get();
?>

<p style="position: absolute; top: 171px; font-size: 10px; left: 50px;">{{$traslado->fecha}}</p>
<p style="position: absolute; top: 226px; font-size: 14px; left: 55px;">{{$responsable}}</p>
<p style="position: absolute; top: 226px; font-size: 14px; left: 320px;">{{$gerencia}}</p>
<p style="position: absolute; top: 282px; font-size: 14px; left: 55px;">{{$traslado->responsable}}</p>
<p style="position: absolute; top: 282px; font-size: 14px; left: 320px;">{{$unidad_final}}</p>

<p style="position: absolute; top: 325px; font-size: 14px; left: 442px;"><strong>X</strong></p>
<p style="position: absolute; top: 345px; font-size: 14px; left: 442px;"><strong>X</strong></p>
<!--<p style="position: absolute; top: 325px; font-size: 14px; left: 640px;"><strong>X</strong></p>-->
<!--<p style="position: absolute; top: 345px; font-size: 14px; left: 640px;"><strong>X</strong></p>-->

<table style="position: absolute; top: 426px; left: 37px; width: 700px;">
	<tbody>
		@foreach($articulos as $articulo)
			<tr>
				<td style="font-size: 8px;" width="12%">{{$articulo->codigo_general}}</td>
				<td style="font-size: 10px; overflow: hidden;" width="40%">{{$articulo->descripcion}}</td>
				<td style="font-size: 12px;">Unidad</td>
				<td style="font-size: 14px;">1</td>
				<td style="font-size: 14px;">1</td>
			</tr>
		@endforeach
	</tbody>
</table>

<p style="position: absolute; top: 782px; font-size: 14px; left: 145px;">{{$traslado->motivo}}<p>

@endforeach