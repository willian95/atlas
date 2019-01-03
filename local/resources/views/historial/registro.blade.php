@extends('layouts.usuario')

@section('content')
	
	@include('partials.alert')
	<div class="container">
		<p class="center-align">
			<a class="btn red" href="{{url('/historial')}}">atras</a>
		</p>

		<h3 class="center-align">Registro de movimientos</h3>
			<h5 class="center-align">Filtrado por fechas</h5>
		<form action="{{url('/historial/filtrar_fecha')}}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="row">
				<div class="col l5">
					<div class="input-field col s12">
          				<input type="text" class="datepicker" id="fecha_inicio" name="fecha_inicio">
          				<label for="fech_inicio">Fecha de inicio</label>
        			</div>
				</div>
				<div class="col l5">
					<div class="input-field col s12">
          				<input type="text" class="datepicker" id="fecha_fin" name="fecha_fin">
          				<label for="fech_fin">Fecha final</label>
        			</div>
				</div>
				<div class="col l2">
					<button class="btn">buscar</button>
				</div>
			</div>
		</form>

		@if(isset($historiales))
			<table class="bordered">
				<thead>
					<tr>
						<th>Codigo</th>
						<th>Serial</th>
						<th>Descripcion</th>
						<th>Marca</th>
						<th>Fecha</th>
						<th>Observacion</th>
					</tr>
				</thead>
				<tbody>
					@foreach($historiales as $historial)
						<tr>
							<td>{{$historial->codigo_general}}</td>
							<td>{{$historial->serial}}</td>
							<td>{{$historial->descripcion}}</td>
							<td>{{$historial->marca}}</td>
							<td>{{$historial->fecha}}</td>
							<td><a class="btn modal-trigger" href="#observacion_modal{{$historial->id}}"><i class="material-icons">search</i></a></td>
						</tr>
						
						<div id="observacion_modal{{$historial->id}}" class="modal">
    						<div class="modal-content">
      							<p>{{$historial->observacion}}</p>
    						</div>
    						<div class="modal-footer">
      							<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cerrar</a>
    						</div>
  						</div>

					@endforeach
				</tbody>
				
			</table>
		@endif

	</div>
	
	<script type="text/javascript">

		$(document).ready(function(){
    		$('.modal').modal();
  		});

		$('.datepicker').pickadate({
			selectMonths: true, // Creates a dropdown to control month
		    selectYears: 15, // Creates a dropdown of 15 years to control year,
		    today: 'Hoy',
		    clear: 'Cerrar',
		    close: 'Ok',
		    closeOnSelect: false // Close upon selecting a date,
		 });
	</script>

@endsection