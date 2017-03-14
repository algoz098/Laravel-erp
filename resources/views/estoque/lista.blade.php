<div class="row">
  <div class="col-md-1">
    ID:
  </div>
  <div class="col-md-2">
    Descricao
  </div>
  <div class="col-md-1">
    Valor
  </div>
  <div class="col-md-2">
    Qtd.
  </div>
  <div class="col-md-4">
    Esta em:
  </div>
</div>
@if ($estoques!==0)
  @foreach($estoques as $key => $estoque)
    <div class="row list-contacts" onclick="selectRow({{$estoque->id}})">
      <div class="col-md-1">
        <span class="label label-info">ID: {{$estoque->id}} </span>
      </div>
      <div class="col-md-2">
        {{$estoque->produto->nome}}
      </div>
      <div class="col-md-1">
        <span class="label label-warning">R$ {{ number_format($estoque->valor_custo, 2) }}</span>
      </div>
      <div class="col-md-2">
        <span class="label label-info">{{$estoque->quantidade}} {{$estoque->unidade}}</span>
      </div>
      <div class="col-md-6" >
        @mostraContato($estoque->contato->id*str_limit($estoque->contato->nome, 55))
      </div>
    </div>
  @endforeach
  <hr>
  <div class="row">
    <div class="col-md-10 text-center">
      <span class="label label-primary">
        Total de produtos: {{ $total }}
      </span>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      {{ $estoques->links() }}
    </div>
  </div>
@endif
