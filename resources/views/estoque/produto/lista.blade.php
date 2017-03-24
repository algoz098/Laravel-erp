<div class="row">
  <div class="col-md-1">
    <strong>ID</strong>
  </div>
  <div class="col-md-1">
    <strong>Codigo</strong>
  </div>
  <div class="col-md-3">
    <strong>Grupo/Sub-grupo</strong>
  </div>
  <div class="col-md-2">
    <strong>Local</strong>
  </div>
  <div class="col-md-5">
    <strong>Aplicação</strong>
  </div>
</div>
@foreach ($produtos as $key => $produto)
  <div class="row list-contacts" onclick="selectRow({{$produto->id}}), retornarEsta({{$produto->id}}, '{{$produto->nome}}', '{{$produto->tipos->nome}}', '{{$produto->barras}}', '{{$produto->ncm}}')">
    <div class="col-md-1">
      <span class="label label-info">
        ID: {{$produto->id}}
      </span>
    </div>
    <div class="col-md-1">
      {{$produto->nome}}
    </div>
    <div class="col-md-3">
      {{$produto->tipos->nome}}/{{$produto->tipos->grupo->nome}}
    </div>
    <div class="col-md-2">
      @foreach ($produto->armazenagens as $key => $armazenagem)
        @if($armazenagem->id==Auth::user()->trabalho_id)
          {{$armazenagem->pivot->local}}
        @endif
      @endforeach
    </div>
    <div class="col-md-5 limitar-string">
      {{$produto->aplicacao}}
    </div>
  </div>
@endforeach
