@extends('layouts.usuario')

@section('content')
	
	@include('partials.alert')

	<p class="center-align">
		<a class="btn waves-effect modal-trigger" data-target="modalGerencia">Nueva unidad<i class="material-icons right">add</i></a>
	</p>

	<!-- Modal -->
	<div id="modalGerencia" class="modal modal-fixed-footer" style="height: 500px;">
    	<div class="modal-content">
      		<h5>Agregar Unidad</h5>
      		<form method="POST" action="{!! url('/crear_unidad') !!}" id="form_unidad">
      			<input type="hidden" name="_token" value="{{ csrf_token() }}">
      			<div class="input-field col s12">
	                <input id="nombre" name="nombre" type="text" class="validate">
	                <label for="nombre">Nombre de la unidad</label>
	            </div>
	            <div class="input-field col s12">
	    			<select id="gerencia" name="gerencia">
	      				<option value="0" disabled selected>Gerencias</option>
	      				@foreach($gerencias as $gerencia)
	      					<option value="{{$gerencia->id}}">{{$gerencia->nombre}}</option>
	      				@endforeach
	    			</select>
	    			<label>Gerencia perteneciente</label>
 	 			</div>
		  		<p class="center-align">
                	<a class="waves-effect waves-light btn" onclick="verificar()"><i class="material-icons right">send</i>Registrar</a>
	            </p>
      		</form>
    	</div>
    	<div class="modal-footer">
      		<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cerrar</a>
    	</div>
  	</div>
	<!-- fin modal -->

	<div class="row">
		
		@if(count($unidades) <=0)
			<ul class="collection">
		     	<li class="collection-item teal darken-3"><h5 class="center-align" style="color: white;">No hay unidades registradas</h5></li>
		    </ul>
		@endif

		@foreach($unidades as $unidad)

			<div class="col l3">
            	<div class="card horizontal">
              		<div class="card-stacked">
                		<div class="card-content">
                			<form method="post" action="{{url('/editar_unidad/'.$unidad->id)}}" id="editar{{$unidad->id}}">
                				<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    			<div class="row">
				                    <div class="input-field col s12">
				                      <input id="nombre{{$unidad->id}}" name="nombre" type="text" class="validate" value="{{$unidad->nombre}}" style="font-size: 18px;">
				                    </div>
				                </div>
			                </form>
                		</div>
                		<div class="card-action">
                  			<div class="row">
                  				<a onclick="eliminar({{$unidad->id}})" class="btn red"><i class="material-icons">delete</i></a>
                      			<a onclick="editar({{$unidad->id}})" class="btn"><i class="material-icons">edit</i></a>
                  			</div>
                		</div>
                  		<form method="post" action="{{url('/eliminar_unidad/'.$unidad->id)}}" id="eliminar{{$unidad->id}}" style="display: none;">
                      		<input type="hidden" name="_token" value="{{ csrf_token() }}">
                  		</form>
              		</div>
            	</div>
          	</div>

		@endforeach

	</div>

	<script type="text/javascript">

		$(document).ready(function() {
			$('.modal').modal();
    		$('select').material_select();
  		});

  		function verificar(){
  			var nombre = document.getElementById('nombre').value;
  			var gerencia = document.getElementById('gerencia').value;

  			if(!nombre || !gerencia){
  				Materialize.toast('Todos los campos son requeridos', 4000);
  			}

  			else{
  				document.getElementById('form_unidad').submit();
  			}

  		}

  		function eliminar(id){
    		swal({
		          title: "¿Estás seguro?",
		          text: "¡Eliminarás esta unidad!",
		          type: "warning",
		          showCancelButton: true,
		          cancelButtonText: "No", 
		          confirmButtonColor: "#DD6B55",
		          confirmButtonText: "Si!",
		          closeOnConfirm: false
		        },
		        function(){
		          document.getElementById('eliminar'+id).submit();
		        });

    	}

    	function editar(id){
    		var nombre = document.getElementById('nombre'+id).value;
    		if(!nombre){
    			Materialize.toast('Nombre requerido', 4000);
    		}
    		else{
    			swal({
		          title: "¿Estás seguro?",
		          text: "¡Editarás esta unidad!",
		          type: "warning",
		          showCancelButton: true,
		          cancelButtonText: "No", 
		          confirmButtonColor: "#DD6B55",
		          confirmButtonText: "Si!",
		          closeOnConfirm: false
		        },
		        function(){
		          document.getElementById('editar'+id).submit();
		        });
    		}

    	}
		
	</script>

@endsection