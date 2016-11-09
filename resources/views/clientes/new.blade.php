@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-11">
      <form method="POST" action="/erp/public/index.php/clientes/novo/{{ $cliente->id or "" }}">

        <div class="form-group">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{$cliente->id or "" }}">
        <div class="panel panel-default">
          <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Adicionar fornecedor/cliente</div>
          <div class="panel-body">
            <div class="row text-right">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-success">Salvar</button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="text">CNPJ</label>
                  <input type="text" class="form-control" value="{{ $cliente->cnpj or "" }}" name="cnpj" id="cnpj" placeholder="CNPJ">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="cnpj">Inscrição Estadual</label>
                  <input type="text" class="form-control" value="{{ $cliente->ie or "" }}" name="ie" id="ie" placeholder="I.E.">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="cnpj">Razão Social</label>
                  <input type="text" class="form-control" value="{{ $cliente->razao_social or "" }}" name="razao_social" id="razao_social" placeholder="Razão Social">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="cnpj">Nome Fantasia</label>
                  <input type="text" class="form-control" value="{{ $cliente->nomefantasia or "" }}" name="nome_fantasia" id="nome_fantasia" placeholder="Nome Fantasia">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="cnpj">Endereço</label>
                  <input type="text" class="form-control" value="{{ $cliente->endereco or "" }}"  name="endereco" id="endereco" placeholder="Endereço">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="cnpj">Numero</label>
                  <input type="text" class="form-control" value="{{ $cliente->numero or "" }}"  name="numero" id="numero" placeholder="Numero">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="cnpj">Andar</label>
                  <input type="text" class="form-control" value="{{ $cliente->andar or "" }}" name="andar" id="andar" placeholder="Andar">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="cnpj">Sala</label>
                  <input type="text" class="form-control" value="{{ $cliente->sala or "" }}" name="sala" id="Sala" placeholder="Sala">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="cnpj">Bairro</label>
                  <input type="text" class="form-control" value="{{ $cliente->bairro or "" }}" name="bairro" id="bairro" placeholder="Bairro">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="cnpj">CEP</label>
                  <input type="text" class="form-control" value="{{ $cliente->cep or "" }}" name="cep" id="cep" placeholder="CEP">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="cnpj">Cidade</label>
                  <input type="text" class="form-control" value="{{ $cliente->cidade or "" }}" name="cidade" id="cidade" placeholder="Cidade">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="cnpj">UF</label>
                  <input type="text" class="form-control" value="{{ $cliente->uf or "" }}" name="uf" id="uf" placeholder="UF">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="cnpj">Contato 1</label>
                  <input type="text" class="form-control" value="{{ $cliente->contato1 or "" }}" name="contato1" id="contato1" placeholder="Contato 1">
                </div>
                <div class="form-group">
                  <label for="cnpj">Departamento 1</label>
                  <input type="text" class="form-control" value="{{ $cliente->departamento1 or "" }}" name="departamento1" id="departamento1" placeholder="Departamento 1">
                </div>
                <div class="form-group">
                  <label for="cnpj">Telefone 1</label>
                  <input type="text" class="form-control" value="{{ $cliente->telefone1 or "" }}" name="telefone1" id="telefone1" placeholder="Telefone 1">
                </div>
                <div class="form-group">
                  <label for="cnpj">Ramal 1</label>
                  <input type="text" class="form-control" value="{{ $cliente->ramal1 or "" }}" name="ramal1" id="ramal1" placeholder="Ramal 1">
                </div>
                <div class="form-group">
                  <label for="cnpj">Celular 1</label>
                  <input type="text" class="form-control" value="{{ $cliente->celular1 or "" }}"  name="celular1" id="celular1" placeholder="Celular 1">
                </div>
                <div class="form-group">
                  <label for="cnpj">E-Mail 1</label>
                  <input type="email" class="form-control" value="{{ $cliente->email1 or "" }}" name="email1" id="email1" placeholder="E-Mail 1">
                </div>
                <div class="form-group">
                  <label for="cnpj">Observação 1</label>
                  <textarea class="form-control" rows="5" value="{{ $cliente->obs1 or "" }}" name="obs1" id="obs1"></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="cnpj">Contato 2</label>
                  <input type="text" class="form-control" value="{{ $cliente->contato2 or "" }}" name="contato2" id="contato2" placeholder="Contato 2">
                </div>
                <div class="form-group">
                  <label for="cnpj">Departamento 2</label>
                  <input type="text" class="form-control" value="{{ $cliente->departamento2 or "" }}" name="departamento2" id="departamento2" placeholder="Departamento 2">
                </div>
                <div class="form-group">
                  <label for="cnpj">Telefone 2</label>
                  <input type="text" class="form-control" value="{{ $cliente->telefone2 or "" }}" name="telefone2" id="telefone2" placeholder="Telefone 2">
                </div>
                <div class="form-group">
                  <label for="cnpj">Ramal 2</label>
                  <input type="text" class="form-control" value="{{ $cliente->ramal2 or "" }}" name="ramal2" id="ramal2" placeholder="Ramal 2">
                </div>
                <div class="form-group">
                  <label for="cnpj">Celular 2</label>
                  <input type="text" class="form-control" value="{{ $cliente->celular2 or "" }}" name="celular2" id="celular2" placeholder="Celular 2">
                </div>
                <div class="form-group">
                  <label for="cnpj">E-Mail 2</label>
                  <input type="email" class="form-control" value="{{ $cliente->email2 or "" }}" name="email2" id="email2" placeholder="E-Mail 2">
                </div>
                <div class="form-group">
                  <label for="cnpj">Observação 2</label>
                  <textarea class="form-control" rows="5" value="{{ $cliente->obs2 or "" }}" name="obs2" id="obs2"></textarea>
                </div>
              </div>
            </div>
            <div class="row text-right">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-success">Salvar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
