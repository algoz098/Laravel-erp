<div class="row" id="lista">
  <div class="col-md-1">
    ID
  </div>
  <div class="col-md-3">
    Tipo
  </div>
  <div class="col-md-3">
    Grupo
  </div>
</div>
@foreach($tipos as $key => $tipo)
  <div class="row list-contacts" onclick="selectRow({{$tipo->id}}) , retornarEsta({{$tipo->id}}, '{{$tipo->nome}}')">
    <div class="col-md-1" >
      <span class="label label-info">
        ID: {{$tipo->id}}
      </span>
    </div>
    <div class="col-md-3 ">
      {{$tipo->nome}}
    </div>
    <div class="col-md-3">
      {{$tipo->grupo->nome}}
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
