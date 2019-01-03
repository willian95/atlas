@extends('layouts.usuario')

@section('content')
	
	<center>
		<a class="btn red" href="{{url('/planificacionSemanal/administrador')}}" style="margin-top: 40px;"><i class="material-icons left">reply</i>atras</a>
	</center>

	@foreach($semanas as $semana)
		<div class="row">
			<?php
				$annio = date("Y");
				$cantidad = DB::table('actividades_semanales')->where('semana', $semana->semana)->where('annio', $annio)->where('gerencia_id', $gerencia_id)->count();
				$actividades = DB::table('actividades_semanales')->where('semana', $semana->semana)->where('annio', $annio)->where('gerencia_id', $gerencia_id)->get();
			?>

			@if($cantidad >= 0)
				<h3 class="center-align">Semana {{$semana->semana}}</h3>
			
				@foreach($actividades as $actividad)
					<div class="col l4">
						<ul class="collapsible" data-collapsible="accordion">
							<li>
								<div class="collapsible-header"><i class="material-icons">send</i>{{$actividad->descripcion}} </div>
							</li>
						</ul>
					</div>
				@endforeach
				
			@endif
		</div>
	@endforeach

@endsection