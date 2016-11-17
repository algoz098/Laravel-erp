@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-11">
      <form method="POST" action="/erp/public/index.php/contatos/novo/{{ $contato->id or "" }}">

        <div class="form-group">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{$contato->id or "" }}">
        <div class="panel panel-default">
          <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Adicionar fornecedor/contato</div>
          <div class="panel-body">
            <div class="row text-right">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-success">Salvar</button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="text">CNPJ ou CPF</label>
                  <input type="text" class="form-control" value="{{ $contato->cpf or "" }}" name="cpf" id="cpf" placeholder="CNPJ\CPF">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="cnpj">Inscrição Estadual ou RG</label>
                  <input type="text" class="form-control" value="{{ $contato->rg or "" }}" name="rg" id="rg" placeholder="I.E.\RG">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="sociabilidade">Sociabilidade</label><br>
                  <input type="radio" name="sociabilidade" id="sociabilidade" value="1" @if (!empty($contato->sociabilidade)){{{$contato->sociabilidade==1 ? "checked" : ""}}}@endif><i class="fa fa-signal level1"></i>
                  <input type="radio" name="sociabilidade" id="sociabilidade" value="2" @if (!empty($contato->sociabilidade)){{{$contato->sociabilidade==2 ? "checked" : ""}}}@endif><i class="fa fa-signal level2"></i>
                  <input type="radio" name="sociabilidade" id="sociabilidade" value="3" @if (!empty($contato->sociabilidade)){{{$contato->sociabilidade==3 ? "checked" : ""}}}@endif><i class="fa fa-signal level3"></i>
                  <input type="radio" name="sociabilidade" id="sociabilidade" value="4" @if (!empty($contato->sociabilidade)){{{$contato->sociabilidade==4 ? "checked" : ""}}}@endif><i class="fa fa-signal level4"></i>
                  <input type="radio" name="sociabilidade" id="sociabilidade" value="5" @if (!empty($contato->sociabilidade)){{{$contato->sociabilidade==5 ? "checked" : ""}}}@endif><i class="fa fa-signal level5"></i>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="actived">Ativo</label><br>
                  <input type="checkbox" name="active" id="active" value="1" checked>Dados Validos
                </div>
              </div>
              <div class="col-md-7">
                <div class="form-group">
                  <label for="cnpj">Nome ou Razão Social</label>
                  <input type="text" class="form-control" value="{{ $contato->nome or "" }}" name="nome" id="nome" placeholder="Razão Social/Nome">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="cnpj">Nome Fantasia/Sobrenome</label>
                  <input type="text" class="form-control" value="{{ $contato->sobrenome or "" }}" name="sobrenome" id="sobrenome" placeholder="Nome Fantasia/Sobrenome">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="cnpj">Endereço</label>
                  <input type="text" class="form-control" value="{{ $contato->endereco or "" }}"  name="endereco" id="endereco" placeholder="Endereço">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="cnpj">Andar</label>
                  <input type="text" class="form-control" value="{{ $contato->andar or "" }}" name="andar" id="andar" placeholder="Andar">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="cnpj">Sala</label>
                  <input type="text" class="form-control" value="{{ $contato->sala or "" }}" name="sala" id="Sala" placeholder="Sala">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="cnpj">Bairro</label>
                  <input type="text" class="form-control" value="{{ $contato->bairro or "" }}" name="bairro" id="bairro" placeholder="Bairro">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="cnpj">CEP</label>
                  <input type="text" class="form-control" value="{{ $contato->cep or "" }}" name="cep" id="cep" placeholder="CEP">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="cnpj">Cidade</label>
                  <input type="text" class="form-control" value="{{ $contato->cidade or "" }}" name="cidade" id="cidade" placeholder="Cidade">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="cnpj">UF</label>
                  <input type="text" class="form-control" value="{{ $contato->uf or "" }}" name="uf" id="uf" placeholder="UF">
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
