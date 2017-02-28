@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-usd fa-1x"></i> Novo conta bancario
        </div>
        <div class="panel-body">
          <form method="POST" action="{{ url('/novo/bancos') }}">
            <div class="row" id="secondNavbar">
              <div class="col-md-12 text-right pull-right">
                @botaoLista(contas*fa-usd)
                @botaoSalvar
              </div>
            </div>
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-body">
                    @selecionaFilial
                    @campoTexto(Banco*banco*)
                    <div class="form-group">
                      <label>Tipo</label>
                      <select class="form-control" id="tipo" name="tipo" >
                        <option value="Conta conrrente" selected>Conta corrente</option>
                        <option value="Poupança" >Poupança</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-body">
                    @campoTexto(Agencia*agencia*)
                    <div class="row">
                      <div class="col-md-7">
                        @campoTexto(Conta Corrente*cc*)
                      </div>
                      <div class="col-sm-5">
                        @campoTexto(Dig.*cc_dig*)
                      </div>
                    </div>
                    @campoTexto(Compensação*comp*)
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-body">
                      @campoTexto(Valor em conta*valor*)
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<script>
$('#agencia').mask('****?****-*');
$('#cc').mask('****?****');
$('#cc_dig').mask('*');
$('#comp').mask('*?**-*');


</script>
@endsection
