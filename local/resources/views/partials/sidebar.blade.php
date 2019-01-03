<ul id="slide-out" class="side-nav fixed" style="background-color: #7cb342;">

  <?php
    $gerencia_id = DB::table('unidades')->where('id', \Auth::user()->unidad_id)->pluck('gerencia_id');
  ?>

  <li>
    <div class="user-view">
      <div class="background">
        <img src="{{url('local/public/img/material.jpg')}}">
      </div>
      <a href="#!user"><img class="circle" src="{{url('local/public/img/user.ico')}}"></a>
      <a href="#!name"><span class="white-text name">{{\Auth::user()->nombre}}</span></a>
      <a href="#!email"><span class="white-text email">{{\Auth::user()->email}}</span></a>
    </div>
  </li>
  @if(\Auth::user()->role_id == 280 || \Auth::user()->role_id == 145)
  <li>
    <a class="white-text" href="{{url('/traslados_gerente')}}">Traslados</a>
  </li>
  <li>
    <a class="white-text" href="{{url('/notificaciones')}}">Notificaciones<span data-badge-caption="" class="new badge red">
    <?php 
      $unidad_id = \Auth::user()->unidad_id;
      $gerencia_id = DB::table('unidades')->where('id', $unidad_id)->pluck('gerencia_id');
    ?>
    @if(DB::table('traslados')->where('gerencia_id', $gerencia_id)->where('visto_inicio', 0)->count() > 0)
      {{DB::table('traslados')->where('gerencia_id', $gerencia_id)->count()}}
    @elseif(DB::table('traslados')->where('gerencia_fin', $gerencia_id)->where('visto_fin', 0)->count() > 0)
      {{DB::table('traslados')->where('gerencia_id', $gerencia_id)->count()}}
    @else
      0
    @endif
    </span></a>
    
  </li>
  @endif
	@if(\Auth::user()->role_id == 280)
		<li>
    		<a class="white-text" href="{{url('/planificacionSemanal')}}">Planificación semanal</a>
  		</li>
	@endif

  @if(\Auth::user()->role_id == 145)
    <li>
      <a class="white-text" href="{{url('/planificacionSemanal/administrador')}}">Planificación semanal</a>
    </li>
  @endif
  @if(\Auth::user()->role_id == 1)
  <li>
    <a class="white-text" href="{{url('/traslados/notificaciones')}}"><span data-badge-caption="" class="new badge red">{{DB::table('traslados')->where('status', 'En espera')->count()}}</span>Traslados</a>
  </li>
  @endif
  @if(\Auth::user()->role_id == 245)
    <li>
      <a class="white-text" href="{{url('/notificaciones')}}">Notificaciones<span data-badge-caption="" class="new badge red">{{DB::table('requisiciones')->where('visto', 0)->count()}}</span></a>
    </li>
  @endif
  <li>
    <a class="white-text" href="{{url('/bienes')}}">Bienes</a>
  </li>
  @if(\Auth::user()->role_id == 300)
  <li>
    <a class="white-text" href="{{url('/requisiciones_administrador')}}">Requisiciones <span class="new badge" data-badge-caption="nuevos" id="contadorRequisiciones">0</span></a>

    <script type="text/javascript">
      
      banderaPrimeraVez = 0;

      setInterval(function() {
        verificarContador();
      }, 5000);

      function verificarContador(){
        $.ajax({
              method: 'GET',
              url: "{{url('/requisiones/contarRequisiciones')}}"
            }).done(function(data){
              
              if(banderaPrimeraVez == 0 && data > 0){
                alerta();
                banderaPrimeraVez = 1;
              }

              if(data > 0){
                limpiar();
                $('#contadorRequisiciones').html(data);
              }

            })
      }

      function limpiar(){
        $('#contadorRequisiciones').empty();
      }

      function alerta(){
        Materialize.toast('Tienes requisiciones pendientes!', 4000);
      }

    </script>

  </li>
  <li>
    <a class="white-text" href="{{url('/ordenes_compra_administrador')}}">Ordenes de Compra</a>
  </li>
  @else
  <li>
    <a class="white-text" href="{{url('/requisiciones')}}">Requisiciones</a>
  </li>
  @endif
  @if(\Auth::user()->role_id == 280 || \Auth::user()->role_id == 145)
  <li>
    <a class="white-text" href="{{url('/historial')}}">Movimientos internos</a>
  </li>
  @endif
  @if(\Auth::user()->role_id == 145)

  @endif
  @if(\Auth::user()->role_id == 1)
  <li>
    <a class="white-text" href="{{url('/historial/administrador')}}">Movimientos internos</a>
  </li>
  @endif
  @if(\Auth::user()->role_id == 1)
  <li>
    <a class="white-text" href="{{url('/gerencias')}}">Gerencias</a>
  </li>
  <li>
    <a class="white-text" href="{{url('/reportes')}}">Etiquetas</a>
  </li>
  <li>
    <a class="white-text" href="{{url('/reportes_pdf')}}">Reportes</a>
  </li>
  <li>
    <a class="white-text" href="{{url('/unidades')}}">Unidades</a>
  </li>
  <li>
    <a class="white-text" href="{{url('/usuarios')}}">Usuarios</a>
  </li>
  @endif
  <li>
    <a class="white-text" href="{{url('/')}}">Cerrar Sesión</a>
  </li>
</ul>

<script type="text/javascript">
  
  $(document).ready(function(){
    
  })


</script>