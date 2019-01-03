<!DOCTYPE html>
<html>
<head>
	<title>Actividades semanales</title>
</head>
<body>

	<img src="{!! public_path().'/img/cintillo.jpg' !!}" style="width: 100%;">

	<h2 style="text-align: center;">Actividades Semanales</h2>
	<h3 style="text-align: center;">Semana {{$semana}}</h3>

	<table style="border: 1px solid; border-collapse: collapse; width: 100%; font-size: 13px;">
		<thead style="border: 1px solid; text-align: center;">
			<tr style="border: 1px solid;">
				<th style="border: 1px solid;">
					Fecha
				</th>
				<th style="border: 1px solid;">
					Descripción
				</th>
			</tr>
		</thead>
		<tbody style="border: 1px solid; text-align: center;">
			@foreach($gerencias as $gerencia)
				<tr>
					<td colspan="2" style="border: 1px solid; background-color: ">
						{{$gerencia->nombre}}
					</td>
				</tr>

				<?php 
					$actividades = DB::table('actividades_semanales')->where('gerencia_id', $gerencia->id)->where('semana', $semana)->get();
				?>

				@foreach($actividades as $actividad)
					<tr style="border: 1px solid;">
						<td width="30%" style="border: 1px solid;">
							{{$actividad->fecha}}
						</td>
						<td width="70%" style="border: 1px solid;">
							{{$actividad->descripcion}}
						</td>
					</tr>
				@endforeach

			@endforeach

		</tbody>
	</table>
</body>
</html>