@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-shopping-cart fa-1x"></i> Lista de Vendas
        </div>
        <div class="panel-body">
          <div class="col-md-5 pull-right text-right">
            <a href="{{ url('/lista/vendas') }}" class="btn btn-warning"><i class="fa fa-shopping-cart"></i> Voltar a listagem</a>
            <a href="{{ url('/novo/vendas') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Reselecionar cliente</a>
          </div>
          <div class="row">
            <div class="col-md-8">
              <form method="POST" action="{{ url('/lista/caixa') }}/">
                <div class="form-group form-inline text-center">
                  {{ csrf_field() }}
                  <input type="text" class="form-control datepicker" size="8" name="data" placeholder="Data" id="data">
                  <button type="submit" class="btn btn-success">Buscar</button>
                </div>
              </form>
              <form method="POST" action="{{ url('/novo/vendas') }}/{{{$contato!="0" ? $contato->id : "0"}}}">
                @foreach($estoques as $key => $estoque)
                  <div class="row list-contacts " id="row{{$estoque->id}}" onclick="mark({{$estoque->id}})"  data-toggle="collapse" data-target="#qtd{{$estoque->id}}" aria-expanded="">
                    <div class="col-md-6 h4">
                      <input type="checkbox" value="{{$estoque->id}}" id="checkbox{{$estoque->id}}" onclick="highlight({{$estoque->id}})" name="estoque[{{ $key }}]">
                      <span class="label label-info">{{$estoque->id}}</span>
                      <span class="label label-primary">{{$estoque->nome}}</span>
                      <span class="label label-info">R$ <span id="valorCusto{{$estoque->id}}">{{$estoque->valor_custo}}</span></span>&nbsp
                      <span class="label label-info">Qtd: {{$estoque->quantidade}}</span>
                      <a href="{{url('novo/contatos/')}}/{{$estoque->contato->id}}">
                        <span class="label label-info">
                          <i class="fa fa-user"></i> {{$estoque->contato->nome}}
                        </span>
                      </a>
                    </div>
                  </div>
                  <div class="sub-menu collapse " aria-expanded="" id="qtd{{$estoque->id}}" style="padding-left: 100px; padding-top: 15px; padding-bottom: 30px;">
                    <div class="row">
                      <div class="col-md-3">
                        Quantidade: <input type="number" class="form-control" size="3" value="1" id="quantidade{{$estoque->id}}" name="quantidade[{{$key}}]" onchange="qtdChange({{$estoque->id}})">
                      </div>
                      <div class="col-md-3">
                        Valor: <input type="number" class="form-control" size="3" value="{{$estoque->valor_custo}}" id="valorTotal{{$estoque->id}}" disabled>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            <div class="col-md-4">
                {{ csrf_field() }}
                <div class="form-group">
                  <label>Venda para</label>
                  <input type="text" class="form-control" name="contato" id="contato" value="{{{$contato!="0" ? $contato->nome : "Avulso"}}}" disabled>
                </div>
                <div class="form-group">
                  <label>Funcionario vendendo:</label>
                  <input type="text" class="form-control" name="contato" id="contato" value="{{Auth::user()->contato->nome}}" disabled>
                </div>
                <button type="submit" class="btn btn-success"><i class="fa fa-arrow-right"></i> Confirmar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script language="javascript">
  function highlight(id) {
    if ($('#row'+id).hasClass('highlight')){
      $('#row'+id).removeClass('highlight');
    } else {
      $('#row'+id).addClass('highlight');
    }
  }
  function mark(id) {
    var precoDeste = parseFloat($('#valorCusto'+id).text());
    var qtd = parseFloat($('#quantidade'+id).val());
    var valorAtual = precoDeste*qtd;
    var valorVelho = parseFloat($('#valor').val());
    if ($('#checkbox'+id).is(':checked')){
      $('#checkbox'+id).prop( "checked", false );
      $('#valor').val(valorVelho - valorAtual);
    } else {
      $('#checkbox'+id).prop( "checked", true );
      $('#valor').val(valorAtual + valorVelho);
    }
    highlight(id);
  }
  function qtdChange(id){
    var precoDeste = parseFloat($('#valorCusto'+id).text());
    var qtd = parseFloat($('#quantidade'+id).val());
    var valorAtual = precoDeste*qtd;
    $('#valorTotal'+id).val(valorAtual);
  }
  </script>
@endsection
