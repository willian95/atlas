@extends('layouts.usuario')

@section('content')
	
	@include('partials.alert')

	<div class="container">
		<div class="row">
			<div class="col l6">
				<center>
					<h5>Metas POA</h5>
					<a class="btn-floating btn-large waves-effect waves-light green modal-trigger" data-target="modal-poa" ><i class="material-icons">add</i></a>
				</center>
			</div>
			<div class="col l6">
				<center>
					<h5>Actividades Semanales</h5>
					<a class="btn-floating btn-large waves-effect waves-light green modal-trigger" data-target="modal-semanal" ><i class="material-icons">add</i></a>
				</center>
			</div>
		</div>

	</div>

	<h5 class="center-align">Metas del POA</h5>

	<div class="row">
		@foreach($metas as $meta)

			<div class="col l4">
				<ul class="collapsible" data-collapsible="accordion">
					<li>
						<div class="collapsible-header"><i class="material-icons">send</i>{{$meta->titulo}} </div>
						<div class="collapsible-body">
							<a class="btn modal-trigger" data-target="modal-descripcion-{{$meta->id}}"><i class="material-icons">search</i></a> <a class="btn" href="{{url('/planificacionSemanal/editarPoa').'/'.$meta->id}}"><i class="material-icons">edit</i></a> <a data-target="modal-semanal{{$meta->id}}" class="btn modal-trigger"><i class="material-icons">add</i></a>
							<p>Lorem ipsum dolor sit amet.</p>
						</div>
					</li>
				</ul>
			</div>

			<!-- Modal descripción -->

			<div id="modal-descripcion-{{$meta->id}}" class="modal">
		    	<div class="modal-content">
		      		<h5 class="center-align">Descripción</h5>

		      		<div class="row">
		      			<p>
		      				{{$meta->descripcion}}
		      			</p>
		      		</div>

		    	</div>
		    	<div class="modal-footer">
		      		<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">cerrar</a>
		    	</div>
		  	</div>

			<!-- Modal descripción -->

			<!-- Modal-meta -->
	
			<div id="modal-semanal{{$meta->id}}" class="modal">
		    	<div class="modal-content">
		      		<h5 class="center-align">Meta del Poa</h5>

		      		<div class="row">
		      			<form class="col s12">
		      				<div class="row">
		        				<div class="input-field col s12">
		          					<input type="text" class="validate" name="descripcion" id="descripcion-semanal">
		          					<label for="descripcion">Descripcion</label>
		        				</div>
		      				</div>
		      			</form>
		      		</div>

		    	</div>
		    	<div class="modal-footer">
		      		<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">cerrar</a>
		    	</div>
		  	</div>

			<!-- Modal-meta -->

		@endforeach
	</div>

	<h5 class="center-align">Actividades semanales</h5>
	
		@foreach($semanas as $semana)
			<div class="row">
				<?php
					$annio = date("Y");
					$cantidad = DB::table('actividades_semanales')->where('semana', $semana->semana)->where('annio', $annio)->where('gerencia_id', $gerencia_id)->count();
					$actividades = DB::table('actividades_semanales')->where('semana', $semana->semana)->where('annio', $annio)->where('gerencia_id', $gerencia_id)->get();
				?>

				@if($cantidad >= 0)
					<h3 class="center-align">Semana {{$semana->semana}}</h3>

				@endif

				@foreach($actividades as $actividad)
					<div class="col l4">
						<ul class="collapsible" data-collapsible="accordion">
							<li>

								<div class="collapsible-header"><i class="material-icons">send</i>{{$actividad->descripcion}} </div>
								<div class="collapsible-body">
									<a class="btn" href="{{url('/planificacionSemanal/editarPoa').'/'.$actividad->id}}"><i class="material-icons">edit</i></a>
								</div>
							</li>
						</ul>
					</div>
				@endforeach
			</div>
		@endforeach
	

	<!-- Modal-POA -->
	
	<div id="modal-poa" class="modal">
    	<div class="modal-content">
      		<h5 class="center-align">Meta del POA</h5>

      		<div class="row">
      			<form class="col s12" method="post" id="form-poa" action="{{url('/planificacionSemanal/registrar/poa')}}">
      				<input type="hidden" name="_token" value="{{ csrf_token() }}">
      				<div class="row">

        				<div class="input-field col s12">
          					<input type="text" class="validate" name="titulo" id="titulo-poa">
          					<label for="titulo-poa">Titulo</label>
        				</div>
        				<div class="input-field col s12">
          					<textarea class="materialize-textarea" name="descripcion" id="descripcion-poa"></textarea>
          					<label for="descripcion-poa">Descripcion</label>
        				</div>

        				<center>
        					<a onclick="verificarPoa()" class="btn waves-effect waves-light green">Registrar</a>
        				</center>

      				</div>
      			</form>
      		</div>

    	</div>
    	<div class="modal-footer">
      		<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">cerrar</a>
    	</div>
  	</div>

	<!-- Modal-POA -->

	<!-- Modal-semanal -->
	
	<div id="modal-semanal" class="modal">
    	<div class="modal-content">
      		<h5 class="center-align">Actividades semanales</h5>

      		<div class="row">
      			<form class="col s12" id="form-semanal" action="{{url('/planificacionSemanal/registrar/semanal')}}" method="post">
      				<input type="hidden" name="_token" value="{{ csrf_token() }}">
      				<div class="row">
        				<div class="input-field col s12">
          					<input type="text" class="validate" id="descripcion-semanal-input" name="descripcion">
          					<label for="descripcion">Descripcion</label>
          					<center>
	        					<a onclick="verificarSemanal()" class="btn waves-effect waves-light green">Registrar</a>
	        				</center>
        				</div>
      				</div>
      			</form>
      		</div>

    	</div>
    	<div class="modal-footer">
      		<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">cerrar</a>
    	</div>
  	</div>

	<!-- Modal-semanal -->


	<script type="text/javascript">
		$(document).ready(function(){
   	 		$('.modal').modal();
  		});

		function verificarPoa(){

			var tituloPoa = $('#titulo-poa').val();
			var descripcionPoa = $('#descripcion-poa').val();

			if(!tituloPoa || !descripcionPoa){
				alert('hey');
			}
			else{
				$('#form-poa').submit();
			}

		}

		function verificarSemanal(){

			var descripcionSemanal = $('#descripcion-semanal-input').val();

			alert(descripcionSemanal);

			if(!descripcionSemanal){
				alert('hey');
			}
			else{
				$('#form-semanal').submit();
			}

		}

	</script>

@endsection