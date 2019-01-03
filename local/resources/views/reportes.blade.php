@extends('layouts.usuario')

@section('content')

	<div class="container">

		<h3 class="center-align">Etiquetas por unidad</h3>
		
		<div class="row">
			<form method="POST" action="{{ url('/reporte_unidad') }}" id="form_unidad">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="col l6">
					<div class="input-field col s12">
		    			<select id="gerencias_unidades" name="gerencia" onchange="mostrar_unidades()">
		      				<option value="0" disabled selected>Gerencias</option>
		      				@foreach($gerencias as $gerencia)
		      					<option value="{{$gerencia->id}}">{{$gerencia->nombre}}</option>
		      				@endforeach
		    			</select>
		    			<label>Gerencia perteneciente</label>
			 		</div>
				</div>
				<div class="col l6">
					<div class="input-field col s12">
		    			<select id="unidades" name="unidad">
		      				
		    			</select>
		    			<label>Gerencia perteneciente</label>
			 		</div>
				</div>
			</form>
			<div class="row">
				<p class="center-align">
					<a class="waves-effect waves-light btn" onclick="verificar_form_unidad()"><i class="material-icons right">send</i>Reporte</a>
				</p>
			</div>
		</div>

		<h3 class="center-align">Etiquetas por gerencia</h3>
		
		<div class="row">
			<form method="POST" action="{{ url('/reporte_gerencia') }}" id="form_gerencia">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="col l6">
					<div class="input-field col s12">
		    			<select id="gerencias_gerencias" name="gerencia" onchange="mostrar_unidades()">
		      				<option value="0" disabled selected>Gerencias</option>
		      				@foreach($gerencias as $gerencia)
		      					<option value="{{$gerencia->id}}">{{$gerencia->nombre}}</option>
		      				@endforeach
		    			</select>
		    			<label>Gerencia perteneciente</label>
			 		</div>
				</div>
				<div class="col l3">
					<p class="center-align">
						<a class="waves-effect waves-light btn" onclick="verificar_form_gerencia()"><i class="material-icons right">send</i>Reporte</a>
					</p>
				</div>
			</form>
		</div>

	</div>

	<script type="text/javascript">
		
		$(document).ready(function() {
    		$('select').material_select();
  		});

  		function borrar_unidades(){
    		$('#unidades').empty();
    	}

		function mostrar_unidades(){

    		var id = document.getElementById('gerencias_unidades').value;
    		$.ajax({
	            type: "GET",
	            url: "{{url('/bienes_unidades')}}/"+id,
	            success: function(unidades) {

	            	borrar_unidades();
	                for(i = 0; i < unidades.length; i++){

	                	$('#unidades').append("<option value='"+unidades[i].id+"'>"+unidades[i].nombre+"</option>")
	                }
	                $('#unidades').material_select();
	            }
	        });
    	}

    	function verificar_form_unidad(){
    		var gerencia = document.getElementById('gerencias_unidades').value;
    		var unidades = document.getElementById('unidades').value;

    		if(!gerencia || !unidades){
    			Materialize.toast('Unidad no seleccionada').value
    		}
    		else{
    			document.getElementById('form_unidad').submit();
    		}
    	
    	}

    	function verificar_form_gerencia(){
    		var gerencia = document.getElementById('gerencias_gerencias').value;

    		if(!gerencia){
    			Materialize.toast('Gerencia no seleccionada').value
    		}
    		else{
    			document.getElementById('form_gerencia').submit();
    		}
    	
    	}

	</script>

@endsection