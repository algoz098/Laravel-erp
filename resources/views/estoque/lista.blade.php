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
  <div class="col-md-1">
    Qtd.
  </div>
  <div class="col-md-1">
    Min/Max
  </div>
  <div class="col-md-1">
    Codigo
  </div>
  <div class="col-md-2">
    Fabricante
  </div>
  <div class="col-md-2">
    Esta em
  </div>
</div>
@if ($estoques!==0)
  @foreach($estoques as $key => $estoque)
    <div class="row list-contacts" onclick="selectRow({{$estoque->id}})">
      <div class="col-md-1">
        <span class="label label-info">ID: {{$estoque->id}} </span>
      </div>
      <div class="col-md-2 limitar-string">
        {{$estoque->produto->nome}}
      </div>
      <div class="col-md-1">
        R$ {{ $estoque->produto->venda }}
      </div>
      <div class="col-md-1">
        {{$estoque->quantidade}} {{$estoque->produto->unidade}}
      </div>
      <div class="col-md-1">
        {{$estoque->produto->qtd_minima}}/{{$estoque->produto->qtd_maxima}}
      </div>
      <div class="col-md-1">
        {{$estoque->produto->barras}}
      </div>
      <div class="col-md-2 limitar-string">
        @mostraContato($estoque->produto->fabricante->id*$estoque->produto->fabricante->nome)
      </div>
      <div class="col-md-2 limitar-string" >
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
