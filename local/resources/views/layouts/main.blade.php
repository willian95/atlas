<!DOCTYPE html>
<html>
<head>
	
	<title>Inventario</title>

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{url('css/materialize.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('css/sweetalert.css')}}">

	<script type="text/javascript" src="{{url('js/jquery.min.js')}}"></script>
	<script type="text/javascript" src="{{url('js/materialize.js')}}"></script>
	<script type="text/javascript" src="{{url('js/sweetalert.min.js')}}"></script>

	<style type="text/css">
		header, main, footer {
      		padding-left: 300px;
    	}

    	@media only screen and (max-width : 992px) {
      		header, main, footer {
        		padding-left: 0;
      		}
    	}
	</style>

</head>
<body>

	@yield('content')

</body>
</html>