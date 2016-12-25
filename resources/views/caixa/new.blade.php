@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-money fa-1x"></i> Nova movimentação
        </div>
        <form method="POST" action="{{ url('/novo/caixa') }}">
          <div class="panel-body">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ Auth::user()->trabalho->id }}">
            <div class="row text-right">
              <div class="col-sm-offset-2 col-sm-10">
                <a class="btn btn-warning" href="{{ url('lista/caixa')}}" ><i class="fa fa-money"></i> Voltar a Lista</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
              </div>
            </div>
            @if ( $errors->count() > 0 )
              <div class="row">
                <div class="col-md-6">
                  <p>Erros:</p>
                  <ul>
                    @foreach( $errors->all() as $message )
                      <li>{{ $message }}</li>
                    @endforeach
                  </ul>
                </div>
              </div>
            @endif
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="contato">Movimentação da Filial:</label>
                  <input type="text" class="form-control" value="{{ Auth::user()->trabalho->nome }}" id="id" disabled>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="tipo">Tipo de movimentação:</label>
                  <select class="form-control" id="tipo" name="tipo">
                    <option value="" selected> - Escolha uma opção - </option>
                    <option value="2" >Movimentação</option>
                    <option value="0" >Abertura de caixa</option>
                    <option value="1" >Fechamento de caixa</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="valor">Valor:</label>
                  <input type="text" class="form-control" value="" id="valor" name="valor" >
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="tipo_valor">Tipo de valor:</label>
                  <select class="form-control" id="tipo_valor" name="forma">
                    <option value="0" selected> Positivo + </option>
                    <option value="1" >Negativo - </option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
