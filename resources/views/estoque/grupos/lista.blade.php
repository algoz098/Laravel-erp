<div class="row" id="lista">
  <div class="col-md-1">
    ID
  </div>
  <div class="col-md-3">
    Grupo
  </div>
  <div class="col-md-1">
    Tipos
  </div>
</div>
@foreach($grupos as $key => $grupo)
  <div class="row list-contacts" onclick="selectRow({{$grupo->id}}) , produtoTipoBusca({{$grupo->id}})">
    <div class="col-md-1" >
      <span class="label label-info">
        ID: {{$grupo->id}}
      </span>
    </div>
    <div class="col-md-3 ">
      {{$grupo->nome}}
    </div>
    <div class="col-md-1 text-center">
      {{count($grupo->tipos)}}
    </div>
  </div>
@endforeach
