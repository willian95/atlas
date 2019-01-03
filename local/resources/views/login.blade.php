@extends('layouts.main')

@section('content')

	@include('partials.alert')

	<div class="row" style="margin-top: 90px;">
		<div class="col l6 s12 offset-l3">           
	        <div class="col l12 s12">
	        	<div class="card-panel z-depth-5 v-align animated slideInUp">
					<h4 class="center-align">Acceder</h4>
	      			<form method="post" action="{!! url('/login') !!}">
	      				<input type="hidden" name="_token" value="{{ csrf_token() }}">
	      				<div class="row">
	    					<div class="input-field col s12">
	      						<input id="email" type="email" class="validate" name="email">
	      						<label for="email">Correo</label>
	    					</div>
	  					</div>
	      				<div class="row">
	    					<div class="input-field col s12">
	      						<input id="password" type="password" class="validate" name="password">
	      						<label for="password">Clave</label>
	    					</div>
	  					</div>
	      				<p class="center-align">
	      					<button class="waves-effect waves-light btn" type="submit">
	      						<i class="material-icons right">send</i>Iniciar
	      					</button>
	      				</p>
	      			</form>
	        	</div>
	      </div>  
	    </div>
	</div>

@endsection
