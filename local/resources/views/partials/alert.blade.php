 @if(session('alert'))
    <ul class="collection">
      <li class="collection-item teal darken-3"><h5 class="center-align" style="color: white;">{{session('alert')}}</h5></li>
    </ul>
@endif