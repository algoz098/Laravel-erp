@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-shopping-cart fa-1x"></i> Lista de Vendas
        </div>
        <div class="panel-body">
          <div class="col-md-12 pull-right text-right">
            <a href="{{ url('/lista/vendas') }}" class="btn btn-warning"><i class="fa fa-shopping-cart"></i> Voltar a listagem</a>
            <a href="{{ url('/novo/vendas') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Reselecionar cliente</a>
            <a href="{{ URL::previous() }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Reselecionar produtos</a>
          </div>
          <div class="row">
            <div class="col-md-8">
              <form method="POST" action="{{ url('/novo/vendas') }}/{{{$contato!="0" ? $contato->id : "0"}}}/salvar">
                <div class="row list-contacts">
                  <div class="col-md-7 pull-right text-right">
                    {{ csrf_field() }}
                    <span class="label label-warning">Funcionario: {{Auth::user()->contato->nome}}</span>
                    <span class="label label-warning">Para: {{{$contato!="0" ? $contato->nome : "Avulso"}}}</span>
                    <span class="label label-danger">Total: R$ {{$total}}</span>
                  </div>
                </div>

                @foreach($produtos as $key => $produto)
                  <div class="row list-contacts ">
                    <div class="col-md-6 h4">
                      <span class="label label-info">{{$produto->id}}</span>
                      <span class="label label-primary">{{$produto->nome}}</span>
                      <span class="label label-info">R$ {{$produto->valor_custo}}</span>&nbsp
                      <span class="label label-info">Qtd: {{$produto->quantidade}}</span>
                      <a href="{{url('novo/contatos/')}}/{{$produto->contato->id}}">
                        <span class="label label-info">
                          <i class="fa fa-user"></i> {{$produto->contato->nome}}
                        </span>
                      </a>
                      <input type="hidden" name="id[{{$key}}]" value="{{$produto->id}}">
                      <input type="hidden" name="quantidade[{{$key}}]" value="{{$produto->quantidade}}">
                    </div>
                  </div>
                @endforeach
              </div>
            <div class="col-md-4" style="padding-top: 15px;">
              <div class="panel panel-default">
                <div class="panel-heading">
                  Detalhe de pagamento
                </div>
                <div class="panel-body">
                  <div class="form-group">
                    <label for="forma">Forma de pagamento:</label>
                    <select class="form-control" id="forma" name="forma">
                      <option value="0" selected>Dinheiro</option>
                      <option value="1">Debito</option>
                      <option value="2">Credito</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="forma">Parcelamento:</label>
                    <select class="form-control" id="forma" name="parcelamento">
                      <option value="0" selected>A vista</option>
                      <option value="1">1+1</option>
                      <option value="2">1+2</option>
                    </select>
                  </div>

                  <button type="submit" class="btn btn-success"><i class="fa fa-arrow-right"></i> Confirmar</button>
                </div>
              </div>
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
