@extends('layouts.usuario')

@section('content')
	
	<p class="center-align">
		<a class="waves-effect waves-light btn red" href="{{url('/traslados/notificaciones')}}"><i class="material-icons left">reply</i>atras</a>
	</p>

	<h3 class="center-align">historial</h3>

	<div class="container">
		<ul class="collapsible" data-collapsible="accordion">
			@foreach($traslados as $traslado)
				<li>
					<div class="collapsible-header"><i class="material-icons">send</i>{{$traslado->motivo}}  {{$traslado->fecha}}</div>
					<div class="collapsible-body">
						<div class="row">
							<strong>Gerencia Origen: </strong>{{DB::table('gerencias')->where('id', $traslado->gerencia_id)->pluck('nombre')}}
							<strong>Unidad Final: </strong>{{DB::table('unidades')->where('id', $traslado->unidad_fin)->pluck('nombre')}}
						</div>
						<div class="row">
							<h5 class="center-align">Articulos</h5>
						</div>
						<table class="bordered" style="margin-bottom: 15px;">
							<thead>
								<tr>
									<th>Código</th>
					  				<th>Descripción</th>
					  				<th>Modelo</th>
					  				<th>Marca</th>
					  				<th>Serial</th>
								</tr>
							</thead>
							<tbody>
								<?php $articulos = DB::table('articulos_traslados')
														->join('bienes', 'articulos_traslados.bienes_id', '=', 'bienes.id')
														->where('traslados_id', $traslado->id)
														->get(); ?>
								@foreach($articulos as $articulo)
									<tr>
										<td>{{$articulo->codigo_general}}</td>
										<td>{{$articulo->descripcion}}</td>
										<td>{{$articulo->modelo}}</td>
										<td>{{$articulo->marca}}</td>
										<td>{{$articulo->serial}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						<div class="row">
							<strong>Status: </strong>{{$traslado->status}}
						</div>
						<div class="row">
							<p class="center-align">
								<a class="waves-effect waves-light btn" href="{{url('/nota_entrega/'.$traslado->id)}}"><i class="material-icons right">search</i>Nota de entrega</a>
							</p>
						</div>
					</div>
				</li>
			@endforeach
		</ul>
	</div>

@endsection