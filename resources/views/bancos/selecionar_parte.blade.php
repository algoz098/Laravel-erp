@foreach ($bancos as $key => $banco)
  <div class="row list-contacts" onclick="retornarEsta({{$banco->id}}, '{{$banco->banco->sobrenome}}')">
    <div class="col-md-1">
      <span class="label label-info">ID: {{$banco->id}}</span>
    </div>
    <div class="col-md-3">
      {{$banco->contato->sobrenome}}
    </div>
    <div class="col-md-3">
      {{$banco->banco->sobrenome}}
    </div>
    <div class="col-md-3">
      {{$banco->valor}}
    </div>
  </div>
@endforeach
