<div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-body">
        @if (isset($grupo))
          <input type="hidden" name="grupos_id" id="grupos_id" value="{{$grupo->id}}">
          @campoTexto(Nome do grupo*produto_grupo_nome*$grupo->nome)
        @else
          @campoTexto(Nome do grupo*produto_grupo_nome*)
        @endif
      </div>
    </div>
  </div>
</div>
