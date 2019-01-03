@extends('layouts.usuario')

@section('content')
	
	@include('partials.alert')

	<p class="center-align">
		<a class="btn waves-effect modal-trigger" data-target="modalGerencia">Nueva Gerencia<i class="material-icons right">add</i></a>
	</p>

	<!-- Modal -->
	<div id="modalGerencia" class="modal modal-fixed-footer" style="height: 400px;">
    	<div class="modal-content">
      		<h5>Agregar Gerencia</h5>
      		<form method="POST" action="{!! url('/crear_gerencia') !!}" id="form_gerencia">
      			<input type="hidden" name="_token" value="{{ csrf_token() }}">
      			<div class="input-field col s12">
	                <input id="nombre" name="nombre" type="text" class="validate">
	                <label for="nombre">Nombre de la gerencia</label>
	            </div>
	            <div class="input-field col s12">
	                <input id="prefijo" name="prefijo" type="text" class="validate">
	                <label for="prefijo">Prefijo</label>
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

		@if(count($gerencias) <=0)
			<ul class="collection">
		     	<li class="collection-item teal darken-3"><h5 class="center-align" style="color: white;">No hay gerencias registradas</h5></li>
		    </ul>
		@endif
		
		@foreach($gerencias as $gerencia)

			<div class="col l3">
            	<div class="card horizontal">
              		<div class="card-stacked">
                		<div class="card-content">
                			<form method="post" action="{{url('/editar_gerencia/'.$gerencia->id)}}" id="editar{{$gerencia->id}}">
                				<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    			<div class="row">
				                    <div class="input-field col s12">
				                      <input id="nombre{{$gerencia->id}}" name="nombre" type="text" class="validate" value="{{$gerencia->nombre}}" style="font-size: 18px;">
				                    </div>
				                </div>
				                <div class="row">
				                    <div class="input-field col s12">
				                      <input id="prefijo{{$gerencia->id}}" name="prefijo" type="text" class="validate" value="{{$gerencia->prefijo}}" style="font-size: 18px;">
				                    </div>
				                </div>
			                </form>
                		</div>
                		<div class="card-action">
                  			<div class="row">
                  				<a onclick="eliminar({{$gerencia->id}})" class="btn red"><i class="material-icons">delete</i></a>
                      			<a onclick="editar({{$gerencia->id}})" class="btn"><i class="material-icons">edit</i></a>
                  			</div>
                		</div>
                  		<form method="post" action="{{url('/eliminar_gerencia/'.$gerencia->id)}}" id="eliminar{{$gerencia->id}}" style="display: none;">
                      		<input type="hidden" name="_token" value="{{ csrf_token() }}">
                  		</form>
              		</div>
            	</div>
          	</div>

		@endforeach

	</div>

	<script type="text/javascript">
		
		$(document).ready(function(){
			$('.modal').modal();
		});

		function verificar(){

			var nombre = document.getElementById('nombre').value;
			var prefijo = document.getElementById('prefijo').value;
			
			if(!nombre || !prefijo){
				Materialize.toast('Todos los campos son requeridos');
			}

			else{
				document.getElementById('form_gerencia').submit();
			}

		}

		function eliminar(id){
    		swal({
		          title: "¿Estás seguro?",
		          text: "¡Eliminarás esta gerencia!",
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
    		var prefijo = document.getElementById('prefijo'+id).value;
    		if(!nombre || !prefijo){
    			Materialize.toast('Nombre requerido', 4000);
    		}
    		else{
    			swal({
		          title: "¿Estás seguro?",
		          text: "¡Editarás esta gerencia!",
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