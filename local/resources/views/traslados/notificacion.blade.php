@extends('layouts.usuario')

@section('content')
	
	@include('partials.alert')

	<p class="center-align">
		<a class="waves-effect waves-light btn" href="{{url('/traslados/historial')}}"><i class="material-icons right">list</i>historial</a>
	</p>

	<h3 class="center-align">Solicitudes de traslado</h3>

	<div class="container">
		<ul class="collapsible" data-collapsible="accordion">
		<?php $num = 0; ?>
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
							@if($traslado->status == 'En espera')
								<a class="waves-effect waves-light btn red right modal-trigger" href="#modalRechazar{{$num}}">Rechazar</a>
								<a class="waves-effect waves-light btn green right" href="{{url('/nota_entrega/'.$traslado->id)}}">Aceptar</a>
							@else
								<strong>Status: </strong>{{$traslado->status}}
							@endif
						</div>
					</div>
				</li>

				<!-- Modal -->
				<div id="modalRechazar{{$num}}" class="modal">
			    	<div class="modal-content">
			      		<form class="col s12" method="post" action="{{url('/nota_rechazo/'.$traslado->id)}}" id="form_rechazar{{$num}}">
			      			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			      			<div class="row">
			        			<div class="input-field col s12">
			          				<textarea id="motivo{{$num}}" name="motivo" class="materialize-textarea"></textarea>
			          				<label for="textarea1">Motivo</label>
			        			</div>
			        			<p class="center-align">
			        				<a class="waves-effect waves-light btn" onclick="verificar({{$num}})"><i class="material-icons right">send</i>Aceptar</a>
			        			</p>
			      			</div>
			    		</form>
			    	</div>
			    	<div class="modal-footer">
			      		<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cerrar</a>
			    	</div>
			  	</div>
				<!---->

				<?php $num++; ?>

			@endforeach
		</ul>
	</div>
	
	<script type="text/javascript">
		
		$(document).ready(function(){
			$('.collapsible').collapsible();
			$('.modal').modal();
		});

		function verificar(id){
			var motivo = document.getElementById('motivo'+id).value;
			if(!motivo){
				Materialize.toast('Debe agregar un motivo');
			}
			else{
				document.getElementById('form_rechazar'+id).submit();
			}
		}
      
	</script>

@endsection