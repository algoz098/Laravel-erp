<div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-body">
        @if (isset($tipo))
          <input id="grupo_selecionado_id" name="grupos_id" type="hidden" value="{{$tipo->grupo->id}}">
          <input id="tipos_id" name="tipos_id" type="hidden" value="{{$tipo->id}}">
          <div class="form-group">
            <label for="">Grupo de produtos:</label>
            <input type="text" class="form-control" disabled value="{{$tipo->grupo->nome}}">
          </div>
          @campoTexto(Nome do tipo*produto_tipo_nome*$tipo->nome)
        @else
          <input id="grupo_selecionado_id" name="grupos_id" type="hidden" value="{{$grupo->id}}">
          <div class="form-group">
            <label for="">Grupo de produtos:</label>
            <input type="text" class="form-control" disabled value="{{$grupo->nome}}">
          </div>
          @campoTexto(Nome do tipo*produto_tipo_nome*)
        @endif
      </div>
    </div>
  </div>
</div>
