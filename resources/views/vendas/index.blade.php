@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-shopping-cart fa-1x"></i> Lista de Vendas
        </div>
        <div class="panel-body">
          <div class="col-md-1 pull-right text-right ajuda-popover"
                title="Novo"
                data-content="Adicione uma nova conta"
                data-placement="top">
            @ifPerms(vendas*adicao)
              <a href="{{ url('/novo/vendas') }}" class="btn btn-success"><i class="fa fa-plus"></i> Novo</a>
            @endPerms
          </div>
          <div class="row">
            <div class="col-md-12  ">
              <form method="POST" action="{{ url('/lista/caixa') }}/">
                <div class="form-group form-inline text-center">
                  {{ csrf_field() }}
                  @if (isset(Auth::user()->perms["admin"]) and Auth::user()->perms["admin"]==1)
                    <label><input type="checkbox" name="deletados">Mostrar deletados</label>
                  @endif
                  <input type="text" class="form-control datepicker ajuda-popover"
                        title="Busca"
                        data-content="Preencha os campos necessarios."
                        data-placement="top" size="8" name="data" placeholder="Data" id="data">
                  <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Buscar</button>
                </div>
              </form>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              @foreach($vendas as $key => $venda)
                <div class="row list-contacts">
                  <div class="col-md-1 ajuda-popover"
                      @if ($key==0)
                        title="Opções"
                        data-content="Descrição dos produtos vinculados na venda."
                        data-placement="top"
                      @endif
                    data-toggle="collapse" data-target="#produtos{{$venda->id}}" aria-expanded="">
                    <span class="btn btn-info">
                      <i class="fa fa-list"></i>
                    </span>
                  </div>
                  <div class="col-md-3 ajuda-popover"
                      @if ($key==0)
                        title="Informações"
                        data-content="Numero da venda, filial que realizou a venda, valor da venda e quantidade de produtos vinculados."
                        data-placement="bottom"
                      @endif
                      >
                    <span class="label label-info">nº {{$venda->id}}</span>
                    <a href="{{url('/novo/contatos')}}/{{$venda->funcionario->id}}">
                      <span class="label label-info"><i class="fa fa-user"></i> {{$venda->funcionario->nome}}</span>
                    </a>
                    <span class="label label-primary">R$ {{$venda->valor}}</span>
                    <span class="label label-info">Movs: {{count($venda->movs)}}</span>
                  </div>
                  <div class="col-md-2 ajuda-popover"
                      @if ($key==0)
                        title="Detalhes"
                        data-content="Data da vendas, e outras informações."
                        data-placement="right"
                      @endif
                    <span class="label label-warning">{{$venda->created_at}}</span>
                  </div>
                </div>
                <div class="sub-menu sub-list-contacts collapse " aria-expanded="" id="produtos{{$venda->id}}" style="margin-left: 100px; pading-top: 15px; margin-bottom: 30px;">
                  @foreach($venda->movs as $key => $mov)
                    <div class="row sub-list-item">
                      <div class="col-md-6">
                        <span class="label label-primary">Produto: {{$mov->estoque->nome}}</span>
                        <span class="label label-info">Qtd: {{$mov->quantidade}}</span>
                        <span class="label label-info">Valor: R$ {{$mov->estoque->valor_custo}}</span>
                        <a href="{{url('/novo/contatos')}}/{{$mov->estoque->contato->id}}">
                          <span class="label label-info"><i class="fa fa-user"></i> {{$mov->estoque->contato->nome}}</span>
                        </a>
                      </div>
                    </div>
                  @endforeach
                </div>
              @endforeach
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 text-center">
              {{ $vendas->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
