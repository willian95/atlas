@extends('layouts.usuario')

@section('content')
	
	<p class="center-align">
		<a class="btn red" href="{{url('/requisiciones')}}"><i class="material-icons left">reply</i>Atras</a>
	</p>

	<div class="container">
		
		<ul class="collapsible" data-collapsible="accordion">
			
			@foreach($requisiciones as $requisicion)
				<?php
					$unidad = DB::table('unidades')->where('id', $requisicion->unidad_id)->pluck('nombre');
					$articulos = DB::table('articulos_requisiciones')->where('requisiciones_id', $requisicion->id)->get();
				?>
				<li>
	      			<div class="collapsible-header"><i class="material-icons">send</i><strong>Fecha: </strong>&nbsp;{{$requisicion->fecha}} &nbsp;<strong>Unidad: </strong>&nbsp;{{$unidad}}&nbsp; <strong>Control: </strong>&nbsp;{{$requisicion->codigo}}</div>
	      			<div class="collapsible-body">
	      				<table>
	      					<thead>
	      						<tr>
	      							<th>Descripción</th>
	      							<th>Unidad</th>
	      							<th>Cantidad</th>
	      							<th>Estado</th>
	      						</tr>
	      					</thead>
	      					<tbody>
	      						@foreach($articulos as $articulo)
									<tr>
										<td>
											{{$articulo->descripcion}}
										</td>
										<td>
											{{$articulo->unidad}}
										</td>
										<td>
											{{$articulo->cantidad_solicitada}}
										</td>
										<td>
											@if($articulo->comprado == 0)
												<strong>No ha sido comprado aún</strong>
											@else
												<strong>Comprado</strong>
											@endif
										</td>
									</tr>
	      						@endforeach
	      					</tbody>
	      				</table>
	      				<p class="center-align">
	      					<a href="{{url('/requisicion_pdf/'.$requisicion->id)}}" class="btn"><i class="material-icons right"></i>ver requisición</a>
	      				</p>
	      			</div>
	    		</li>

			@endforeach
		</ul>

	</div>

@endsection