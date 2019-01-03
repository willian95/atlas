@extends('layouts.usuario')

@section('content')
	
	@include('partials.alert')
	
	<h3 class="center-align">Traslados</h3>

	<div class="row">
		<div class="input-field col s3 offset-s1">

      		<div class="input-field col s12">
    			<select id="tipo">
      				<option value="1">Serial</option>
      				<option value="2">Descripción</option>
      				<option value="3">Modelo</option>
      				<option value="4">Marca</option>
      				<option value="5">Código</option>
    			</select>
    			<label>Tipo de búsqueda</label>
	 		</div>

    	</div>

    	<div class="input-field col s6" style="margin-top: 30px;">
      		<input type="text" class="validate" id="buscarBienes">
      		<label for="buscar">Búsqueda</label>
    	</div>

    	<div class="col s2">
    		<p>
    			<a class="waves-effect waves-light btn" onclick="asinc()" style="margin-top: 30px;"><i class="material-icons">search</i></a>
    		</p>
    	</div>

  	</div>

  	<div class="row">

  		<h5 class="center-align">Unidad fin: </h5>

  		<div class="input-field col s3 offset-s1">

      		<div class="input-field col s12">
    			<select id="gerencias" onchange="unidades()">
    				<option value="0" disabled selected>Gerencias</option>
      				@foreach($gerencias as $gerencia)
	      				<option value="{{$gerencia->id}}">{{$gerencia->nombre}}</option>
	      			@endforeach
    			</select>
    			<label>Gerencias</label>
	 		</div>

    	</div>

 		<div class="input-field col s6" style="margin-top: 30px;">
			<select id="unidades" >

			</select>
			<label>Unidades</label>
 		</div>
    		
  	</div>

  	<div class="row">
    	<div class="col s11">
    		<div class="input-field col s10 offset-s1">
        	<textarea id="motivo" class="materialize-textarea"></textarea>
        	<label for="textarea1">Motivo</label>
        </div>
    	</div>
    </div>

  	<p class="center-align">
  		<a class="waves-effect waves-light btn" onclick="trasladar()"><i class="material-icons right">send</i>Trasladar</a>
  	</p>

  	<table class="bordered" id="tablaBienes" style="width: 100%;">
  		<thead>
  			<tr>
  				<th>Código</th>
  				<th>Descripción</th>
  				<th>Modelo</th>
  				<th>Marca</th>
  				<th>Serial</th>
  				<th>Observación</th>
  				<th>Acción</th>
  			</tr>
  		</thead>
  		<tbody id="mostrarBienes">
  			
  		</tbody>
  	</table>


  	<h5 class="center-align">Articulos a trasladar</h5>
	
	<form method="POST" id="trasladar">
		<table class="bordered" style="width: 100%;">
			<thead>
				<tr>
					<th>Código</th>
					<th>Descripcion</th>
					<th>Modelo</th>
					<th>Marca</th>
					<th>Serial</th>
					<th>Observación</th>
					<th>Acciones</th>
				</tr>
			</thead>
				<tbody id="bienesTraslado">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
				</tbody>
		</table>
		<input type="text" style="display: none;" name="motivo" id="motivo_copia">
	</form>

	<script type="text/javascript">

		$(document).ready(function() {
    		$('select').material_select();
  		});

		function limpiar(){
			$('#mostrarBienes').empty();
		}

		function asinc(){
			var texto = document.getElementById('buscarBienes').value;
			var tipo = document.getElementById('tipo').value;
			if(texto != ''){
				$.ajax({
		            type: "GET",
		            url: "{{url('/traslados_buscar')}}/"+texto+"/"+tipo,
		            success: function(bienes) {
		     			
		     			limpiar();
	            		for(i =0; i< bienes.length; i++){

		            		var bien = "<tr>"+
		            						"<td>"+bienes[i].codigo_general+"</td>"+
		            						"<td>"+bienes[i].descripcion+"</td>"+
		            						"<td>"+bienes[i].modelo+"</td>"+
		            						"<td>"+bienes[i].marca+"</td>"+
		            						"<td>"+bienes[i].serial+"</td>"+
		            						"<td>"+bienes[i].observacion+"</td>"+
		            						"<td>"+"<a class='waves-effect btn' onclick='agregar("+bienes[i].id+")'><i class='material-icons'>send</i></a>"+"</td>"+
		            					"</tr>"

		            		$('#mostrarBienes').append(bien)
		            	}
		            }
		        });
			}
		}

		function agregar(codigo){
			$.ajax({
	            type: "GET",
	            url: "{{url('/buscar_bien_traslado')}}/"+codigo,
	            success: function(bienes) {
	     			
	     			limpiar();
            		for(i =0; i< bienes.length; i++){

            			var id_bienes = bienes[i].id;
	            		var bien = "<tr id='trasladar"+id_bienes+"'>"+
	            						"<td style='display: none;'>"+"<input type='text' name='id[]' value='"+id_bienes+"'>"+"</td>"+
	            						"<td>"+bienes[i].codigo_general+"</td>"+
	            						"<td>"+bienes[i].descripcion+"</td>"+
	            						"<td>"+bienes[i].modelo+"</td>"+
	            						"<td>"+bienes[i].marca+"</td>"+
	            						"<td>"+bienes[i].serial+"</td>"+
	            						"<td>"+bienes[i].observacion+"</td>"+
	            						"<td>"+"<a class='waves-effect btn red' onclick='eliminar("+id_bienes+")'><i class='material-icons'>delete</i></a>"+"</td>"+
	            					"</tr>"

	            		$('#bienesTraslado').append(bien)
	            	}

	            }
	        });
		}

		function eliminar(id){
			$( "#trasladar"+id).empty();
		}

		function borrar_unidades(){
    		$('#unidades').empty();
    	}

    	function unidades(){
    		var id = document.getElementById('gerencias').value;
    		$('#trasladar').removeAttr('action');
    		$('#trasladar').attr('action', "{{url('/trasladar')}}/"+id);
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

    	function trasladar(){
    		var unidad_fin = document.getElementById('unidades').value;
    		var motivo = document.getElementById('motivo').value;
    		document.getElementById('motivo_copia').value = motivo;

    		$("#trasladar").attr('action', "{{url('/trasladar')}}/"+unidad_fin)

    		document.getElementById('trasladar').submit()
    	}

	</script>

@endsection