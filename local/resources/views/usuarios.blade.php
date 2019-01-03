@extends('layouts.usuario')

@section('content')
	
	@include('partials.alert')

	<p class="center-align">
		<a class="btn waves-effect modal-trigger" data-target="modalUsuario">Nuevo Usuario<i class="material-icons right">add</i></a>
	</p>

	<!-- Modal -->

	<div id="modalUsuario" class="modal modal-fixed-footer" style="height: 800px;">
    	<div class="modal-content">
      		<h5>Agregar Usuario</h5>
      		<form method="POST" action="{!! url('/crear_usuario') !!}" id="form_usuario">
      			<input type="hidden" name="_token" value="{{ csrf_token() }}">
      			<div class="input-field col s12">
	                <input id="nombre" name="nombre" type="text" class="validate">
	                <label for="nombre">Nombre</label>
	            </div>
	            <div class="input-field col s12">
	                <input id="email" name="email" type="text" class="validate">
	                <label for="email">Email</label>
	            </div>
	           	<div class="input-field col s12">
	    			<select id="rol" name="rol" onchange="mostrarGerencia()">
	      				<option value="0" disabled selected>Roles</option>
	      				@foreach($roles as $rol)
	      					<option value="{{$rol->id}}">{{$rol->descripcion}}</option>
	      				@endforeach
	    			</select>
	    			<label>Rol del usuario</label>
 	 			</div>
 	 			<div class="input-field col s12" style="display: none;" id="gerencia_select">
	    			<select id="gerencia" name="gerencia" onchange="unidades()">
	      				<option value="0" disabled selected>Gerencias</option>
	      				@foreach($gerencias as $gerencia)
	      					<option value="{{$gerencia->id}}">{{$gerencia->nombre}}</option>
	      				@endforeach
	    			</select>
	    			<label>Gerencia perteneciente</label>
 	 			</div>
 	 			<div class="input-field col s12" style="display: none;" id="unidad_select">
	    			<select id="responsable_archivos" name="unidad">
	    			</select>
	    			<label>Unidad resposable</label>
 	 			</div>
	            <div class="input-field col s12">
	                <input id="clave" name="clave" type="text" class="validate">
	                <label for="clave">Clave</label>
	            </div>
	            <div class="input-field col s12">
	                <input id="clave2" name="clave2" type="text" class="validate">
	                <label for="clave2">Repetir Clave</label>
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

	<!-- Fin Modal -->

	<div class="container">
		<ul class="collapsible" data-collapsible="accordion">
			@foreach($usuarios as $usuario)
				<li>
	      			<div class="collapsible-header"><i class="material-icons">send</i>{{$usuario->nombre}}</div>
	      			<div class="collapsible-body">
	      				<div class="row">
	      					<span>Correo: </span><strong>{{$usuario->email}}</strong>
	      				</div>
	      				<div class="row">
	      					<span>Rol: </span><strong>{{$usuario->descripcion}}</strong>
	      				</div>
	      				<div class="row">
	      					<p class="right-align">
	      						<a class="waves-effect waves-light btn modal-trigger" data-target="modalEditar{{$usuario->id}}"><i class="material-icons">edit</i></a>
	      						<a class="waves-effect waves-light btn red" onclick="eliminar({{$usuario->id}})"><i class="material-icons">delete</i></a>
	      						<form action="{{url('/eliminar_usuario/'.$usuario->id)}}" id="form_eliminar{{$usuario->id}}" method="post">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
								</form>
	      					</p>
		      			</div>
	      			</div>
	    		</li>

	    		<!-- Modal -->

				<div id="modalEditar{{$usuario->id}}" class="modal modal-fixed-footer" style="height: 800px;">
			    	<div class="modal-content">
			      		<h5>Editar Usuario</h5>
			      		<form method="POST" action="{!! url('/editar_usuario/'.$usuario->id) !!}" id="form_editar{{$usuario->id}}">
			      			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			      			<div class="input-field col s12">
				                <input id="nombre_editar{{$usuario->id}}" value="{{$usuario->nombre}}" name="nombre" type="text" class="validate">
				                <label for="nombre_editar{{$usuario->id}}">Nombre</label>
				            </div>
				            <div class="input-field col s12">
				                <input id="email_editar{{$usuario->id}}" value="{{$usuario->email}}" name="email" type="text" class="validate">
				                <label for="email_editar{{$usuario->id}}">Email</label>
				            </div>
				           	<div class="input-field col s12">
				    			<select id="rol_editar{{$usuario->id}}" name="rol">
				      				<option value="0" disabled selected>Roles</option>
				      				@foreach($roles as $rol)
				      					<option value="{{$rol->id}}" @if($rol->id == $usuario->role_id) {{'selected'}} @endif  >{{$rol->descripcion}}</option>
				      				@endforeach
				    			</select>
				    			<label>Rol del usuario</label>
			 	 			</div>
				            
				            <p class="center-align">
				               	<a class="waves-effect waves-light btn" onclick="editar({{$usuario->id}})"><i class="material-icons right">send</i>Editar</a>
				            </p>
			      		</form>
			    	</div>
			    	<div class="modal-footer">
			      		<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cerrar</a>
			    	</div>
			  	</div>

				<!-- Fin Modal -->

			@endforeach
		</ul>
	</div>

	<script type="text/javascript">
		
		$(document).ready(function() {
			$('.modal').modal();
    		$('select').material_select();
  		});

		function verificar(){

			var nombre = document.getElementById('nombre').value;
			var email = document.getElementById('email').value;
			var rol = document.getElementById('rol').value;
			var clave = document.getElementById('clave').value;
			var clave2 = document.getElementById('clave2').value;

			if(!nombre || !email || !rol || !clave || !clave2){
				Materialize.toast('Todos los campos son requeridos', 4000);
			}
			else{
				if(clave != clave2){
					Materialize.toast('Claves no coinciden', 4000);
				}
				else{
					document.getElementById('form_usuario').submit();
				}
			}

		}

		function mostrarGerencia(){
			var rol = document.getElementById('rol').value;
			if(rol > 1 && rol < 300){
				$('#gerencia_select').css('display', 'block');
				$('#unidad_select').css('display', 'block');
			}
			else{
				$('#gerencia_select').css('display', 'none');
				$('#unidad_select').css('display', 'none');
			}
		}

		function borrar_unidades(){
    		$('#responsable_archivos').empty();
    	}

		function unidades(){
    		var id = document.getElementById('gerencia').value;
    		$.ajax({
	            type: "GET",
	            url: "{{url('/bienes_unidades')}}/"+id,
	            success: function(unidades) {

	            	borrar_unidades();
	                for(i = 0; i < unidades.length; i++){
	                	$('#responsable_archivos').append("<option value='"+unidades[i].id+"'>"+unidades[i].nombre+"</option>")
	                }
	                $('#responsable_archivos').material_select();
	            }
	        });
    	}

		function editar(id){
			var nombre = document.getElementById('nombre_editar'+id).value;
			var email = document.getElementById('email_editar'+id).value;
			var rol = document.getElementById('rol_editar'+id).value;

			if(!nombre || !email || !rol){
				Materialize.toast('Todos los campos son requeridos', 4000);
			}
			else{

				document.getElementById('form_editar'+id).submit();

			}
		}

		function eliminar(id){
			swal({
		          title: "¿Estás seguro?",
		          text: "¡Eliminarás este usuario!",
		          type: "warning",
		          showCancelButton: true,
		          cancelButtonText: "No", 
		          confirmButtonColor: "#DD6B55",
		          confirmButtonText: "Si!",
		          closeOnConfirm: false
		        },
		        function(){
		        	document.getElementById('form_eliminar'+id).submit();
		        });
		}

	</script>

@endsection