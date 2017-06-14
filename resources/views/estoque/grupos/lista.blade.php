<div class="row" id="lista">
  <div class="col-md-1">
    Util
  </div>
  <div class="col-md-1">
    ID
  </div>
  <div class="col-md-3">
    Grupo
  </div>
  <div class="col-md-2">
    Sub-grupo
  </div>
</div>
@foreach($grupos as $key => $grupo)
  <div class="row list-contacts" >
    <div class="col-md-1">
      <a data-toggle="tooltip" title="Selecionar" class="btn btn-info btn-xs" onclick="selectRow({{$grupo->id}}) , produtoTipoBusca({{$grupo->id}})">
        <i data-toggle="tooltip" title="Selecionar" class="fa fa-sign-out"></i>
      </a>
      <a  data-toggle="tooltip" title="Editar" class="btn btn-info btn-xs" onclick="editarGrupo({{$grupo->id}})">
        <i data-toggle="tooltip" title="Editar" class="fa fa-pencil"></i>
      </a>
    </div>
    <div class="col-md-1" >
      <span class="label label-info">
        ID: {{$grupo->id}}
      </span>
    </div>
    <div class="col-md-3 ">
      {{$grupo->nome}}
    </div>
    <div class="col-md-2 text-center">
      {{count($grupo->tipos)}}
    </div>
  </div>
@endforeach
