<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<style type="text/css">
	.image { 
	   position: relative; 
	   display: inline;
	}

	h2 { 
	   position: absolute; 
	   top: 12px; 
	   left: 70px; 
	   z-index: 99999;
	}
</style>
	<?php $count = count($etiquetas); $num = 0;?>

	@foreach($etiquetas as $etiqueta)


		<div class="image">
		      <img style="width: 155px; height: 56; margin-bottom: 13px;"  src="{!! public_path().'/img/bienes.png' !!}">
		      <h2 style="font-size: 12px; margin-top: 16px; margin-left: -40px;">{{$etiqueta->codigo_general}}</h2>
		</div>

		@if($num % 4 == 0)
			<br>
		@endif

		<?php $num++; ?>

	@endforeach
	
</body>
</html>