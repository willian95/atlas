@extends('layouts.usuario')

@section('content')
		
	@include('partials.alert')
	@if(\Auth::user()->role_id == 1)
		<div class="row">
			<div class="col l6">
				<p class="center-align">
					<a class="btn waves-effect modal-trigger" data-target="modalAgregarBien">Ingresar bien<i class="material-icons right">add</i></a>
				</p>
			</div>
			<div class="col l6">
				<p class="center-align">
					<a class="btn waves-effect modal-trigger" data-target="modalSubirArchivo">Subir archivo<i class="material-icons right">assignment</i></a>
				</p>
			</div>
		</div>
	@endif
	<h4 class="center-align">Búsqueda por Bien</h4>
	<div class="row">

		<form method="POST" action="{{ url('/buscar_bienes') }}" id="form_buscar_unidades">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="input-field col s3 offset-s1">

	      		<div class="input-field col s12">
	    			<select id="tipo" name="tipo_busqueda">
	      				<option value="1">Serial</option>
	      				<option value="2">Descripción</option>
	      				<option value="3">Modelo</option>
	      				<option value="4">Marca</option>
	      				<option value="5">Codigo</option>
	    			</select>
	    			<label>Tipo de búsqueda</label>
		 		</div>

			</div>

	    	<div class="input-field col s6" style="margin-top: 30px;">
	      		<input type="text" class="validate" id="buscarBienes" name="buscarBienes">
	      		<label for="buscar">Búsqueda</label>
	    	</div>

	    	<div class="col s2">
	    		<p>
	    			<button type="button" onclick="buscar_bien()" class="waves-effect waves-light btn" style="margin-top: 30px;"><i class="material-icons">search</i></button>
	    		</p>
	    	</div>

    	</form>

  	</div>

	@if(\Auth::user()->role_id == 1)
	<h4 class="center-align">Búsqueda por Unidad</h4>

	<div class="row">
		<form method="POST" action="{{ url('/buscar_bien') }}" id="form_buscar">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="col l3 offset-l1">
				<div class="input-field col s12">
	    			<select id="gerencias_filtro" name="gerencia" onchange="mostrar_unidades_filtro()">
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
	    			<select id="unidades_filtro" name="unidad">
	      				
	    			</select>
	    			<label>Gerencia perteneciente</label>
		 		</div>
			</div>
			<div class="col l1">
				<p class="center-align">
					<a class="waves-effect waves-light btn" onclick="buscar()"><i class="material-icons">search</i></a>
				</p>
			</div>
		</form>
	</div>
	@endif
	
	@if(\Auth::user()->role_id == 280)
		<div class="row">
			<form id="form_buscar_gerente" method="post" action="{{url('/buscar_bien_gerente/'.\Auth::user()->unidad_id)}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="col l4 offset-l2">
					<div class="input-field col s12">
					    <select id="unidad_gerente" name="unidad">
					    	@foreach($unidades_gerencia as $unidad_gerencia)
					    		<option value="{{$unidad_gerencia->id}}">{{$unidad_gerencia->nombre}}</option>
					    	@endforeach
					    </select>
					    <label>Unidad</label>
					</div>
				</div>
				<div class="col l4">
					<div class="input-field col s12">
						<p class="center-align">
							<a class="waves-effect waves-light btn" onclick="buscar_gerente()"><i class="material-icons left">search</i>Buscar</a>
						</p>
					</div>
				</div>
			</form>
		</div>
	@endif

	<!-- Modal agergar bien-->

	<div id="modalSubirArchivo" class="modal modal-fixed-footer" style="height: 800px;">
    	<div class="modal-content">
      		<h5>Agregar bien</h5>
      		<form method="POST" action="{{url('/importar_archivo') }}" id="form_archivo" enctype="multipart/form-data">
      			<input type="hidden" name="_token" value="{{ csrf_token() }}">
      			<div class="input-field col s12">
	    			<select id="gerencia_archivos" name="gerencia" onchange="unidades_archivos()">
	      				<option value="0" disabled selected>Gerencias</option>
	      				@foreach($gerencias as $gerencia)
	      					<option value="{{$gerencia->id}}">{{$gerencia->nombre}}</option>
	      				@endforeach
	    			</select>
	    			<label>Gerencia perteneciente</label>
 	 			</div>
 	 			<div class="input-field col s12">
	    			<select id="responsable_archivos" name="unidad">

	    			</select>
	    			<label>Unidad resposable</label>
 	 			</div>
      			<div class="file-field input-field">
			      	<div class="btn">
			        	<span>Archivo</span>
			        	<input type="file" id="archivo" name="archivo">
			      	</div>
			      	<div class="file-path-wrapper">
			        	<input class="file-path validate" type="text">
			      	</div>
			    </div>
 	 			<p class="center-align">
	                <a class="waves-effect waves-light btn" onclick="verificar_archivos()"><i class="material-icons right">send</i>Registrar</a>
	            </p>
      		</form>
    	</div>
    	<div class="modal-footer">
      		<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cerrar</a>
    	</div>
  	</div>

	<!-- fin modal -->

	<!-- Modal agergar bien-->

	<div id="modalAgregarBien" class="modal modal-fixed-footer" style="height: 800px;">
    	<div class="modal-content">
      		<h5>Agregar bien</h5>
      		<form method="POST" action="{!! url('/crear_bien') !!}" id="form_bienes">
      			<input type="hidden" name="_token" value="{{ csrf_token() }}">
      			<div class="input-field col s12">
	    			<select id="gerencia" name="gerencia" onchange="unidades()">
	      				<option value="0" disabled selected>Gerencias</option>
	      				@foreach($gerencias as $gerencia)
	      					<option value="{{$gerencia->id}}">{{$gerencia->nombre}}</option>
	      				@endforeach
	    			</select>
	    			<label>Gerencia perteneciente</label>
 	 			</div>
 	 			<div class="input-field col s12">
	    			<select id="responsable" name="unidad">

	    			</select>
	    			<label>Unidad resposable</label>
 	 			</div>
      			<div class="input-field col s12">
	                <input id="descripcion" name="descripcion" type="text" class="validate">
	                <label for="descripcion">Descripción</label>
	            </div>
	            <div class="input-field col s12">
	                <input id="modelo" name="modelo" type="text" class="validate">
	                <label for="modelo">Modelo</label>
	            </div>
	            <div class="input-field col s12">
	                <input id="marca" name="marca" type="text" class="validate">
	                <label for="marca">Marca</label>
	            </div>
	            <div class="input-field col s12">
	                <input id="serial" name="serial" type="text" class="validate">
	                <label for="serial">Serial</label>
	            </div>
	            <div class="input-field col s12">
	                <input id="vida_util" name="vida_util" type="text" class="validate">
	                <label for="vida_util">Vida Util (años)</label>
	            </div>
	            <div class="input-field col s12">
	                <textarea id="observacion" name="observacion" class="materialize-textarea"></textarea>
          			<label for="observacion">Observacion</label>
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
		@if(isset($bienes))
			@if(count($bienes) <=0)
				<ul class="collection">
			     	<li class="collection-item teal darken-3"><h5 class="center-align" style="color: white;">No hay bienes registrados</h5></li>
			    </ul>
			@endif
		@endif

		<table class="bordered">
			<thead>
				<tr>
					<th>
						Código General
					</th>
					<th>
						Descripción
					</th>
					<th>
						Modelo
					</th>
					<th>
						Marca
					</th>
					<th>
						Serial
					</th>
					<th>
						Observacion
					</th>
					@if(\Auth::user()->role_id == 1)
						<th>
							Acciones
						</th>
					@endif
				</tr>
			</thead>
			<tbody id="articulos">
				@if(isset($bienes))
					@foreach($bienes as $bien)

						<tr>
							<form action="{{url('/editar_bien/'.$bien->id)}}" id="form_editar{{$bien->id}}" method="post">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<td>{{$bien->codigo_general}}</td>
								<td><input id="descripcion_editar{{$bien->id}}" value="{{$bien->descripcion}}" name="descripcion" type="text" class="validate"></td>
								<td><input id="modelo_editar{{$bien->id}}" value="{{$bien->modelo}}" name="modelo" type="text" class="validate"></td>
								<td><input id="marca_editar{{$bien->id}}" value="{{$bien->marca}}" name="marca" type="text" class="validate"></td>
								<td><input id="modelo_serial{{$bien->id}}" value="{{$bien->serial}}" name="serial" type="text" class="validate"></td>
							</form>
							@if(\Auth::user()->role_id == 1)
								<td>
									<a class="waves-effect waves-light btn" onclick="editar({{$bien->id}})"><i class="material-icons">edit</i></a>
									<a class="waves-effect waves-light btn red" onclick="eliminar(({{$bien->id}}))"><i class="material-icons">delete</i></a>
									<form action="{{url('/eliminar_bien/'.$bien->id)}}" id="form_eliminar{{$bien->id}}" method="post">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
									</form>
								</td>
							@endif
							<td>
								{{$bien->observacion}}
							</td>
						</tr>

					@endforeach
				@endif
			</tbody>
		</table>

	</div>

	<script type="text/javascript">
		
		$(document).ready(function() {
			$('.modal').modal();
    		$('select').material_select();
  		});

		function verificar(){

			var gerencia = document.getElementById('gerencia').value;
			var responsable = document.getElementById('responsable').value;
			var descripcion = document.getElementById('descripcion').value;
			
			if(!gerencia || !responsable || !descripcion){
				Materialize.toast('todos los campos son requeridos');
			}

			else{
				document.getElementById('form_bienes').submit();
			}

		}

		function verificar_archivos(){

			var gerencia = document.getElementById('gerencia_archivos').value;
			var responsable = document.getElementById('responsable_archivos').value;
			var archivo = document.getElementById('archivo').value;
			
			if(!gerencia || !responsable || !archivo){
				Materialize.toast('todos los campos son requeridos');
			}

			else{
				document.getElementById('form_archivo').submit();
			}

		}

		function eliminar(id){
    		swal({
		          title: "¿Estás seguro?",
		          text: "¡Eliminarás este bien!",
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

    	function buscar(){
    		
    		var gerencia = document.getElementById('gerencias_filtro').value
    		var unidad = document.getElementById('unidades_filtro').value

    		if(!gerencia || !unidad){
    			Materialize.toast('Todos los campos son requeridos')
    		}
    		else{
    			document.getElementById('form_buscar').submit()
    		}

    	}

    	function buscar_bien(){
    		
    		var tipo = document.getElementById('tipo').value;
    		var buscarBienes = document.getElementById('buscarBienes').value;

    		if(!tipo || !buscarBienes){
    			Materialize.toast('Todos los campos son necesarios', 4000);
    		}
    		else{
    			document.getElementById('form_buscar_unidades').submit();
    		}

    	}

    	function buscar_gerente(){
    		
    		var unidad = document.getElementById('unidad_gerente').value

    		if(!unidad){
    			Materialize.toast('Todos los campos son requeridos')
    		}
    		else{
    			document.getElementById('form_buscar_gerente').submit()
    		}

    	}

    	function editar(id){

			swal({
	          title: "¿Estás seguro?",
	          text: "¡Editarás este bien!",
	          type: "warning",
	          showCancelButton: true,
	          cancelButtonText: "No", 
	          confirmButtonColor: "#DD6B55",
	          confirmButtonText: "Si!",
	          closeOnConfirm: false
	        },
	        function(){
	        	document.getElementById('form_editar'+id).submit();
	        });

    	}

    	function borrar_unidades(){
    		$('#responsable').empty();
    		$('#responsable_archivos').empty();
    		$('#unidades_filtro').empty();
    	}

    	function unidades(){
    		var id = document.getElementById('gerencia').value;
    		$.ajax({
	            type: "GET",
	            url: "{{url('/bienes_unidades')}}/"+id,
	            success: function(unidades) {

	            	borrar_unidades();
	                for(i = 0; i < unidades.length; i++){
	                	$('#responsable').append("<option value='"+unidades[i].id+"'>"+unidades[i].nombre+"</option>")
	                }
	                $('#responsable').material_select();
	            }
	        });
    	}

    	function mostrar_unidades_filtro(){

    		var id = document.getElementById('gerencias_filtro').value;
    		$.ajax({
	            type: "GET",
	            url: "{{url('/bienes_unidades')}}/"+id,
	            success: function(unidades) {

	            	borrar_unidades();
	                for(i = 0; i < unidades.length; i++){

	                	$('#unidades_filtro').append("<option value='"+unidades[i].id+"'>"+unidades[i].nombre+"</option>")
	                }
	                $('#unidades_filtro').material_select();
	            }
	        });
    	}

    	function unidades_archivos(){
    		var id = document.getElementById('gerencia_archivos').value;
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

    	function limpiar(){
			$('#articulos').empty();
		}

		function asinc(){
			limpiar();
			var texto = document.getElementById('buscarBienes').value;
			var tipo = document.getElementById('tipo').value;
			if(texto != ''){
				$.ajax({
		            type: "GET",
		            url: "{{url('/traslados_buscar')}}/"+texto+"/"+tipo,
		            success: function(bienes) {
		     			console.log(bienes);
	            		for(i =0; i< bienes.length; i++){

		            		var bien = "<tr>"+
		            						"<td>"+bienes[i].codigo_general+"</td>"+
		            						"<td>"+bienes[i].descripcion+"</td>"+
		            						"<td>"+bienes[i].modelo+"</td>"+
		            						"<td>"+bienes[i].marca+"</td>"+
		            						"<td>"+bienes[i].serial+"</td>"+
		            						"<td>"+bienes[i].observacion+"</td>"+
		            						"<td>"+bienes[i].observacion+"</td>"+

		            					"</tr>"

		            		$('#articulos').append(bien)
		            	}
		            }
		        });
			}
		}

	</script>
		
@endsection