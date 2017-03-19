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
  <div class="col-md-3">
    Sub-grupos
  </div>
</div>
@foreach($tipos as $key => $tipo)
  <div class="row list-contacts">
    <div class="col-md-1">
      <a data-toggle="tooltip" title="Selecionar" class="btn btn-info btn-xs" onclick="selectRow({{$tipo->id}}) , retornarEsta({{$tipo->id}}, '{{$tipo->nome}}')">
        <i data-toggle="tooltip" title="Selecionar" class="fa fa-sign-out"></i>
      </a>
      <a  data-toggle="tooltip" title="Editar" class="btn btn-info btn-xs" onclick="editarTipo({{$tipo->id}})">
        <i data-toggle="tooltip" title="Editar" class="fa fa-pencil"></i>
      </a>
    </div>
    <div class="col-md-1" >
      <span class="label label-info">
        ID: {{$tipo->id}}
      </span>
    </div>
    <div class="col-md-3">
      {{$tipo->grupo->nome}}
    </div>
    <div class="col-md-3 ">
      {{$tipo->nome}}
    </div>
  </div>
@endforeach

<script>
$(document).ready(function(){
  @if (isset($erro))
    $.toaster({ message : "{{$erro}}", title : "Atenção", priority : 'warning' , settings : {'timeout' : 3000,}});
  @endif
})
</script>
