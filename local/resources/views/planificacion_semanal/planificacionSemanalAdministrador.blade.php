@extends('layouts.usuario')

@section('content')
	
	@include('partials.alert')

	<div class="container">
		
		<h3 class="center-align">Informe Semanal</h3>

		<div class="row">
			<form class="col l12" method="post" action="{{url('/planificacionSemanal/administrador/reporte')}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
      			<div class="row">
        			<div class="input-field col l4">
          				<select name="semana">
      						@foreach($semanas as $semana)
      							<option value="{{$semana->semana}}">{{$semana->semana}}</option>
      						@endforeach
    					</select>
    					<label>Semana</label>
        			</div>
        			<div class="input-field col l6">
          				<button class="btn green">
          					Generar Reporte
          				</button>
        			</div>
      			</div>
      		</form>
		</div>

		<div class="row">
			@foreach($gerencias as $gerencia)

				<div class="col l4">
					<div class="row">
        				<div class="col l12">
          					<div class="card darken-1">
            					<div class="card-content" style="height: 100px;">
              						<h5>{{$gerencia->nombre}}</h5>
            					</div>
            					<div class="card-action">
              						<a href="#">POA</a>
              						<a href="{{url('/planificacionSemanal/administrador/actividades/').'/'.$gerencia->id}}">Actividades</a>
            					</div>
          					</div>
        				</div>
      				</div>
				</div>
			
			@endforeach
		</div>

	</div>

	<script type="text/javascript">
		$(document).ready(function() {
    		$('select').material_select();
  		});
	</script>

@endsection