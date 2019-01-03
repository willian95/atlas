@extends('layouts.usuario')

@section('content')
	
	<h3 class="center-align">Ordenes de comrpa</h3>

	<div class="container">
		<ul class="collapsible" data-collapsible="accordion">
			
			@foreach($ordenes as $orden)
				<li>

					<?php 
						$correlativo = (int)$orden->correlativo;
						$numero = '';

						if($correlativo < 10)
						{
							$numero = '000'.$correlativo;
						}
						else if($correlativo < 100 && $correlativo >= 10)
						{
							$numero = '00'.$correlativo;
						}
						else if($correlativo < 1000 && $correlativo >= 100)
						{
							$numero = '0'.$correlativo;
						}
						else if($correlativo < 10000 && $correlativo >= 1000)
						{
							$numero = $correlativo;
						}
					?>

	      			<div class="collapsible-header"><i class="material-icons">send</i><strong>Correlativo: </strong>{{$numero}}&nbsp;&nbsp;<strong>Fecha compra: </strong>&nbsp;{{$orden->fecha_orden_compra}}&nbsp;<strong>Requisicion:</strong> {{$orden->codigo}}</div>
	      			<div class="collapsible-body">
						<?php $articulos = DB::table('articulos_compra')
												->join('articulos_requisiciones', 'articulos_compra.articulos_requisiciones_id', '=', 'articulos_requisiciones.id')
												->where('articulos_compra.orden_compra_id', $orden->id)
												->select('articulos_requisiciones.descripcion', 'articulos_compra.cantidad', 'articulos_compra.precio_unitario')
												->get(); ?>
						
						<table>
							<thead>
								<tr>
									<th>Descripcion</th>
									<th>Cantidad comprada</th>
									<th>Precio unitario</th>
								</tr>
							</thead>
							<tbody>
								@foreach($articulos as $articulo)
									<tr>
										<td>{{$articulo->descripcion}}</td>
										<td>{{$articulo->cantidad}}</td>
										<td>{{$articulo->precio_unitario}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>

						<center>
							<a href="{{url('/orden_compra/pdf/').'/'.$orden->id}}" class="waves-effect waves-light btn"><i class="material-icons right">assignment</i>revisar</a>
						</center>

	      			</div>
	    		</li>
			@endforeach
		</ul>
	</div>

@endsection