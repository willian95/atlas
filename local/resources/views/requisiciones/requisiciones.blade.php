@extends('layouts.usuario')

@section('content')
	
	@include('partials.alert')

	<p class="center-align">
		<a class="btn" href="{{url('/requisiciones_historial')}}"><i class="material-icons right">list</i>Historial</a>
	</p>

	<h3 class="center-align">Requisiciones</h3>

	<div style="padding-left: 20px; padding-right: 20px;">
		<form action="{{url('/crear_requisicion')}}" method="post" id="form">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="row">
				<div class="col l4">
					<p>
				      <input type="checkbox" id="bienes" name="bienes" />
				      <label for="bienes">Bienes</label>
				    </p>
				</div>
				<div class="col l4">
					<p>
				      <input type="checkbox" id="servicios" name="servicios"/>
				      <label for="servicios">Servicios</label>
				    </p>
				</div>
				<div class="col l4">
					<p>
				      <input type="checkbox" id="otros" name="otros"/>
				      <label for="otros">Otros</label>
				    </p>
				</div>
			</div>
			<div class="row">
				<div class="col l3">
					<div class="input-field col s12">
				    	<select id="partida">
				      		<option value="" disabled selected>seleccionar</option>
							@foreach($partidas_raiz as $partida_raiz)
					      		<optgroup label="{{$partida_raiz->descripcion}}">
							        <?php 
										$partidas = DB::table('partidas')->where('partida_raiz_id', $partida_raiz->id)->get();
							        ?>
							        @foreach($partidas as $partida)
										<option value="{{$partida->numero}}">{{$partida->descripcion}}</option>
							        @endforeach
	      						</optgroup>
							@endforeach
				    	</select>
				    	<label>Partida presupuestaria</label>
				  	</div>
				</div>
				<div class="col l3">
					<div class="input-field col s12">
			        	<input id="descripcion" type="text" class="validate">
			        	<label for="descripcion">Descripción</label>
			        </div>
				</div>
				<div class="col l3">
					<div class="input-field col s12">
			        	<input id="unidad" type="text" class="validate">
			        	<label for="unidad">Unidad de medida</label>
			        </div>
				</div>
				<div class="col l3">
					<div class="input-field col s12">
			        	<input id="cantidad" type="text" class="validate">
			        	<label for="cantidad">Cantidad</label>
			        </div>
				</div>
			</div>

			<div class="row">
				<p class="center-align">
					<a class="btn-floating btn-large waves-effect waves-light" onclick="agregar()"><i class="material-icons">add</i></a>
				</p>
			</div>
			<table>
				<thead>
					<tr>
						<th>Partida</th>
						<th>Descripción</th>
						<th>Unidad</th>
						<th>Cantidad</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody id="articulos">
					
				</tbody>
			</table>

			<div class="row">
				<div class="input-field col s12">
          			<textarea id="observacion" class="materialize-textarea" name="observacion"></textarea>
          			<label for="observacion">Observacion</label>
        		</div>
			</div>
		
			<div class="row">
				<p class="center-align">
					<a class="waves-effect waves-light btn" onclick="crear()"><i class="material-icons right">list</i>Crear</a>
				</p>
			</div>
		</form>

	</div>

	<script type="text/javascript">
		
		var contador = 0;

		$(document).ready(function() {
    		$('select').material_select();
  		});

		function agregar(){

			var partida = document.getElementById('partida').value;
			var descripcion = document.getElementById('descripcion').value;
			var unidad = document.getElementById('unidad').value;
			var cantidad = document.getElementById('cantidad').value;

			if(!descripcion || !unidad || !cantidad){
				Materialize.toast('Todos los campos son obligatorios', 4000);
			}
			else{
				var row = 	"<tr id='contador"+contador+"'>"+
								"<td>"+
									partida+
									"<input style='display: none;' type='text' name='partida[]' value='"+partida+"'>"+
								"</td>"+
								"<td>"+
									descripcion+
									"<input style='display: none;' type='text' name='descripcion[]' value='"+descripcion+"'>"+
								"</td>"+
								"<td>"+
									unidad+
									"<input style='display: none;' type='text' name='unidad[]' value='"+unidad+"'>"+
								"</td>"+
								"<td>"+
									cantidad+
									"<input style='display: none;' type='text' name='cantidad[]' value='"+cantidad+"'>"+
								"</td>"+
								"<td>"+
									"<button class='btn red' onclick='eliminar("+contador+")'><i class='material-icons'>delete</i></button>"
								"</td>"+
							"</tr>"

			$("#articulos").append(row);
			contador++;
			}
		}

		function eliminar(contador){
			$('#contador'+contador).empty();
		}

		function crear(){
			document.getElementById('form').submit();
		}


	</script>

@endsection