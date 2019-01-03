@extends('layouts.usuario')

@section('content')
	
	@include('partials.alert')
	
	<p class="center-align">
		<a class="btn" href="{{url('/historial/registro')}}">Historial</a>
	</p>

	<h3 class="center-align">Historiales</h3>

	<div class="container">
      		<p class="center-align">Insertar el movimiento de algún bien dentro de la gerencia</p>
      		<form>
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
  				<h3 class="center-align">Busqueda de bienes</h3>
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
      		</form>
			
			
      		<form method="POST" id="trasladar" action="{{url('historial/registrar')}}">
      			<h3 class="center-align">Bienes a mover</h3>
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
				<div class="row">
        			<div class="input-field col s12">
          				<textarea id="motivo" name="motivo" class="materialize-textarea"></textarea>
          				<label for="motivo">Motivo</label>
        			</div>
      			</div>
      			<div class="row">
      				<p class="center-align">
      					<button class="btn">Registrar</button>
      				</p>
      			</div>
			</form>
	</div>
	
	
	<script type="text/javascript">
		
		$(document).ready(function(){
    		$('.modal').modal();
    		$('select').material_select();
  		});

  		function limpiar(){
			$('#mostrarBienes').empty();
		}

		function eliminar(id){
			$( "#trasladar"+id).empty();
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
	</script>

@endsection