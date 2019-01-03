<img src="{!! public_path().'/img/cintillo.jpg' !!}" style="width: 100%;">
<h4 style="text-align: center;">
	{{$gerencia}}
</h4>
<h5 style="text-align: center;">
	{{$unidad}}
</h5>

<table style="border: 1px solid; border-collapse: collapse; width: 100%; font-size: 13px;">
	<thead style="border: 1px solid;">
		<tr style="border: 1px solid; text-align: center; background-color: #4db6ac;">
			<th style="border: 1px solid; text-align: center;">Código</th>
			<th style="border: 1px solid; text-align: center;">Descripción</th>
			<th style="border: 1px solid; text-align: center;">Modelo</th>
			<th style="border: 1px solid; text-align: center;">Marca</th>
			<th style="border: 1px solid; text-align: center;">Serial</th>
			<th style="border: 1px solid; text-align: center;">Observación</th>
		</tr>
	</thead>
	<tbody style="border: 1px solid; text-align: center;">
		@foreach($bienes as $bien)
			<tr style="border: 1px solid; text-align: center;">
				<td style="border: 1px solid; text-align: center; font-size: 10px;">{{$bien->codigo_general}}</td>
				<td style="border: 1px solid; text-align: center; font-size: 8px;">{{$bien->descripcion}}</td>
				<td style="border: 1px solid; text-align: center; font-size: 8px;">{{$bien->modelo}}</td>
				<td style="border: 1px solid; text-align: center; font-size: 8px;">{{$bien->marca}}</td>
				<td style="border: 1px solid; text-align: center; font-size: 8px;">{{$bien->serial}}</td>
				<td style="border: 1px solid; text-align: center; font-size: 8px;">{{$bien->observacion}}</td>
			</tr>
		@endforeach
	</tbody>
</table>