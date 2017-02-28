@foreach ($produtos as $key => $produto)
  <div class="row list-contacts" onclick="retornarEsta({{$produto->id}}, '{{$produto->nome}}')">
    <div class="col-md-1">
      <span class="label label-info">
        ID: {{$produto->id}}
      </span>
    </div>
    <div class="col-md-3">
      {{$produto->nome}}
    </div>
    <div class="col-md-3">
      <span class="label label-info">
        {{$produto->barras}}
      </span>
    </div>
    <div class="col-md-2">
      <span class="label label-info">
        {{$produto->unidade}}
      </span>
    </div>
  </div>
@endforeach
