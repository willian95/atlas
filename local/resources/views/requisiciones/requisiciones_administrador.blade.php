@extends('layouts.usuario')

@section('content')
	
	@include('partials.alert')
	
	<h3 class="center-align">Requisiciones</h3>

	<div id="respuesta">
		
	</div>

	<div class="container">
		<ul class="collapsible" data-collapsible="accordion">
			@foreach($requisiciones as $requisicion)
				<?php
					$unidad = DB::table('unidades')->where('id', $requisicion->unidad_id)->pluck('nombre');
					$articulos = DB::table('articulos_requisiciones')->where('requisiciones_id', $requisicion->id)->get();
				?>
				<li>
	      			<div class="collapsible-header" onclick="ver_articulo({{$requisicion->id}})"><i class="material-icons">@if($requisicion->status == 'abierta') clear @else done @endif</i><strong>Fecha: </strong>&nbsp;{{$requisicion->fecha}} &nbsp;<strong>Unidad: </strong>&nbsp;{{$unidad}}&nbsp; <strong>Control: </strong>&nbsp;{{$requisicion->codigo}}</div>
	      			<div class="collapsible-body">
	      				<table>
	      					<thead>
	      						<tr>
	      							<th>Descripción</th>
	      							<th>Unidad</th>
	      							<th>Cantidad solicitada</th>
	      							<th>Cantidad adquirida</th>
	      							<th>Cantidad restante</th>
	      							<th>Acción</th>
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
											{{$articulo->cantidad_adquirida}}
										</td>
										<td>
											{{$articulo->cantidad_solicitada - $articulo->cantidad_adquirida}}
										</td>
										<td>
											@if($articulo->cantidad_adquirida != $articulo->cantidad_solicitada)
												Pendiente por compra
											@else
												Articulo comprado
											@endif

										</td>
									</tr>
	      						@endforeach
	      					</tbody>
	      				</table>
	      				<p class="center-align">
	      					<a href="{{url('/requisicion_pdf/'.$requisicion->id)}}" class="btn"><i class="material-icons right"></i>ver requisición</a>
	      				</p>
	      				@if($requisicion->status == 'abierta')
							<p class="center-align">
		      					<a class="waves-effect waves-light btn" href="{{url('/orden_compra/'.$requisicion->id)}}">Realizar compra</a>
		      				</p>
	      				@endif
	      			</div>
	    		</li>

			@endforeach
		</ul>
	</div>

	<script type="text/javascript">
		function ver_articulo(id){
	        $.ajax({
	              method: 'GET',
	              url: "{{url('/ver_articulo/')}}"+"/"+id
	            }).done(function(data){
	            	console.log(data); 
	            })
	      }
	</script>

@endsection