@extends('layouts.usuario')

@section('content')

	<h3 class="center-align">Ordenes de comrpa</h3>

	<div class="container">
	
		@foreach($requisiciones as $requisicion)

			<h5 class="center-align"><strong>Unidad: </strong>&nbsp;{{$requisicion->nombre}}&nbsp; <strong>Control: </strong>&nbsp;{{$requisicion->codigo}}</h5>
			<form method="post" action="{{url('/orden_compra/registrar/'.$requisicion->id)}}" id="form_compra">
			<table>
					<thead>
						<tr>
							<th>Descripción</th>
							<th>Unidad</th>
							<th>Cantidad solicitada</th>
							<th>Cantidad a comprar</th>
							<th>Precio unitario</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
	  						@foreach($articulos as $articulo)
								<tr>
									<td>
										{{$articulo->descripcion}}
									</td>
									<td class="center-align">
										{{$articulo->unidad}}
									</td>
									<td class="center-align">
										{{$articulo->cantidad_solicitada - $articulo->cantidad_adquirida}}
									</td>
									<td>
										<p class="range-field">
											<input name="cantidad[]" type="range" id="range{{$articulo->id}}" value="0" min="0" max="{{$articulo->cantidad_solicitada - $articulo->cantidad_adquirida}}" />
											<input type="text" name="id[]" style="display: none;" value="{{$articulo->id}}">
										</p>
									</td>
									<td>
										<p>
											<div class="row">
												<div class="input-field col s12">
													<input type="text" class="validate" name="precio_unitario[]" @if($articulo->cantidad_solicitada - $articulo->cantidad_adquirida == 0) disabled @endif>
												</div>
											</div>
										</p>
									</td>
									<td>
										@if($articulo->comprado != $articulo->cantidad_solicitada)
											<p>
												Articulo no comprado aún
											</p>
										@else
											Articulo comprado
										@endif
									</td>
								</tr>
	  						@endforeach
  					</tbody>
  				</table>
  				<div class="row">
  					<hr style="font-size: 3px;">
  					<h5 class="center-align"><strong>Datos proveedor</strong></h5>
					
					<div class="input-field">
    					<select name="proveedor_id" id="proveedor_id" onchange="selectProveedor()">
      						<option value="0" selected>Elija una opción</option>
     	 					@foreach($proveedores as $proveedor)
								<option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
     	 					@endforeach
    					</select>
    					<label>Proveedores</label>
  					</div>
					
					<div class="row">
						<div class="col l6">
							<div class="input-field col s12">
          						<input  id="nombre" type="text" class="validate" name="proveedor">
          						<label for="nombre">Nombre proveedor</label>
        					</div>
						</div>
						<div class="col l6">
							<div class="input-field col s12">
          						<input  id="rif" type="text" class="validate" name="rif">
          						<label for="rif">R.I.F</label>
        					</div>
						</div>
					</div>

					<div class="row">
						<div class="col l6">
							<div class="input-field col s12">
          						<input  id="direccion" type="text" class="validate" name="direccion">
          						<label for="direccion">Direccion</label>
        					</div>
						</div>
						<div class="col l6">
							<div class="input-field col s12">
          						<input  id="telefono" type="text" class="validate" name="telefono">
          						<label for="telefono">Telefono</label>
        					</div>
						</div>
					</div>

					<div class="row">
						<p class="center-align">
							<button type="button" class="btn" onclick="comprar()">Registrar Compra</button>
						</p>
					</div>

  				</div>
			</form>
		@endforeach

	</div>

	<script type="text/javascript">
		
		$(document).ready(function() {
    		$('select').material_select();
  		});

  		function selectProveedor(){
  			//limpiar();
			var id = document.getElementById('proveedor_id').value;
			if(id != '0'){
				$.ajax({
		            type: "GET",
		            url: "{{url('/get/proveedores')}}/"+id,
		            success: function(proveedores) {
					
					var proveedor = proveedores[0].nombre;
					var rif = proveedores[0].rif;
					var direccion = proveedores[0].direccion;
					var telefono = proveedores[0].telefono;

					$('#nombre').attr('value', proveedor);
					$('#rif').attr('value', rif);
					$('#direccion').attr('value', direccion);
					$('#telefono').attr('value', telefono);
					Materialize.updateTextFields();
		            }
		        });
			}
			else{
				$('#nombre').attr('value', '');
				$('#rif').attr('value', '');
				$('#direccion').attr('value', '');
				$('#telefono').attr('value', '');
				Materialize.updateTextFields();
			}
  		}

  		function comprar(){
  			document.getElementById('form_compra').submit();
  		}
	</script>

@endsection