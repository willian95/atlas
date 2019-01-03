@extends('layouts.usuario')

@section('content')
	
	@include('partials.alert')
	
	<div id="respeusta">
		
	</div>

	@if(\Auth::user()->role_id != 245)
		<h3 class="center-align">Notificaciones de traslado</h3>
		<div class="container">
			<ul class="collapsible" data-collapsible="accordion">
				@foreach($notificaciones as $notificacion)
					
					<li>
		      			<div class="collapsible-header"><i class="material-icons">send</i>{{$notificacion->motivo}} {{$notificacion->fecha}}</div>
		      			<div class="collapsible-body">
		      				<strong>Status: </strong>{{$notificacion->status}}
		      				<p class="center-align">
		      					@if($notificacion->status == 'aprobado')
		      						<a href="{{url('/nota_entrega/'.$notificacion->id)}}" class="waves-effect waves-light btn"><i class="material-icons right">search</i>nota de entrega</a>
		      					@else
		      						<p class="center-align">
		      							{{$notificacion->motivo_rechazo}}
		      						</p>
		      					@endif
		      				</p>
		      			</div>
		    		</li>

				@endforeach
			</ul>
		</div>
	@endif

	<h3 class="center-align">Notificaciones de requisiciones</h3>
	<div class="container">
		<ul class="collapsible" data-collapsible="accordion">
			@foreach($notificaciones_requisiciones as $requisicion)
				
				<?php
					$unidad = DB::table('unidades')->where('id', $requisicion->unidad_id)->pluck('nombre');
					$articulos = DB::table('articulos_requisiciones')->where('requisiciones_id', $requisicion->id)->get();
				?>
				<li>
	      			<div class="collapsible-header" onclick="visto({{$requisicion->id}})"><i class="material-icons">send</i><strong>Fecha: </strong>&nbsp;{{$requisicion->fecha}} &nbsp;<strong>Unidad: </strong>&nbsp;{{$unidad}}&nbsp; <strong>Control: </strong>&nbsp;{{$requisicion->codigo}}</div>
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

	<script type="text/javascript">
		$(document).ready(function(){
    		$('.collapsible').collapsible();
  		});

		function visto(id){
			$.ajax({
	            type: "GET",
	            url: "{{url('/ver_articulo')}}/"+id,
	            success: function(respuesta) {
	            	console.log(respuesta)
	            }
	        });
		}

	</script>

@endsection