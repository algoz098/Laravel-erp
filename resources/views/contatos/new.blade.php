@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      @if (!empty($contato->id))
        <form method="POST" action="{{ url('/contatos') }}/{{$contato->id}}">
      @else
        <form method="POST" action="{{ url('novo/contatos') }}">
      @endif
        <div class="form-group">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{$contato->id or "" }}">
        <div class="panel panel-default">
          <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Adicionar contato</div>
          <div class="panel-body">
            <div class="row text-right">
              <div class="col-sm-offset-2 col-sm-10">
                <a class="btn btn-warning" href="{{ url('lista/contatos')}}" ><i class="fa fa-users"></i> Voltar a Lista</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="text">Tipo de Contato</label>
                  @if (!empty($contato) and $contato->id===1)
                    <select class="form-control" id="tipo" disabled>
                      <option value="0" selected>Empresa</option>
                    </select>
                  @elseif(!empty($contato) and $contato->tipo=="1")
                    <select class="form-control" name="tipo" id="tipo" >
                      <option value=""> - Escolha uma opção - </option>
                      <option value="0" >Empresa</option>
                      <option value="1" selected>Pessoa</option>
                    </select>
                  @elseif(!empty($contato) and $contato->tipo=="0")
                    <select class="form-control" name="tipo" id="tipo" >
                      <option value=""> - Escolha uma opção - </option>
                      <option value="0" selected>Empresa</option>
                      <option value="1" >Pessoa</option>
                    </select>
                  @else
                    <select class="form-control" id="tipo" name="tipo" onchange="tipoChange(this)">
                      <option value="" selected> - Escolha uma opção - </option>
                      <option value="0" >Empresa</option>
                      <option value="1" >Pessoa</option>
                    </select>
                  @endif
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="cpf">CNPJ ou CPF</label>
                  <input type="text" class="form-control" value="{{ $contato->cpf or "" }}" name="cpf" id="cpf" placeholder="CNPJ\CPF">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="rg">Inscrição Estadual ou RG</label>
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
              <div class="col-md-4 pull-right">
                <div class="form-group">
                  <label for="actived">Relação com a Matriz</label><br>
                  @if (!empty($contato) and $contato->id===1)
                    <select class="form-control" id="relacao" disabled>
                      <option value="" selected>Matriz</option>
                    </select>
                  @elseif (!empty($contato) and null!==$contato->from->find(1))
                    <select class="form-control" id="relacao" disabled>
                      <option value="" selected>{{$contato->from->find(1)->pivot->from_text}}</option>
                    </select>
                  @else
                    <select class="form-control" name="relacao" id="relacao">
                      <option selected> - Escolha uma opção - </option>
                      <option value="0" >Fornecedor</option>
                      <option value="1" >Cliente</option>
                      <option value="2" >Filial</option>
                      <option value="" >Indefinido</option>
                    </select>
                  @endif
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="nome">Nome ou Razão Social</label>
                  <input type="text" class="form-control" value="{{ $contato->nome or "" }}" name="nome" id="nome" placeholder="Razão Social/Nome">
                </div>
              </div>
              <div class="col-md-8">
                <div class="form-group">
                  <label for="sobrenome">Nome Fantasia/Sobrenome</label>
                  <input type="text" class="form-control" value="{{ $contato->sobrenome or "" }}" name="sobrenome" id="sobrenome" placeholder="Nome Fantasia/Sobrenome">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="endereco">Endereço</label>
                  <input type="text" class="form-control" value="{{ $contato->endereco or "" }}"  name="endereco" id="endereco" placeholder="Endereço">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="andar">Andar</label>
                  <input type="text" class="form-control" value="{{ $contato->andar or "" }}" name="andar" id="andar" placeholder="Andar">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="sala">Sala</label>
                  <input type="text" class="form-control" value="{{ $contato->sala or "" }}" name="sala" id="Sala" placeholder="Sala">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="bairro">Bairro</label>
                  <input type="text" class="form-control" value="{{ $contato->bairro or "" }}" name="bairro" id="bairro" placeholder="Bairro">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="cep">CEP</label>
                  <input type="text" class="form-control" value="{{ $contato->cep or "" }}" name="cep" id="cep" placeholder="CEP">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="cidade">Cidade</label>
                  <input type="text" class="form-control" value="{{ $contato->cidade or "" }}" name="cidade" id="cidade" placeholder="Cidade">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="uf">UF</label>
                  <input type="text" class="form-control" value="{{ $contato->uf or "" }}" name="uf" id="uf" placeholder="UF">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group">
                <label for="obs">Obs:</label>
                <textarea id="froala-editor" name="obs">
                  {!! $contato->obs or "" !!}
                </textarea>
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

  <script language="javascript">
  function tipoChange(selected) {
    if (selected.value=="1"){
      $("label[for='rg']").text("RG");
      $("label[for='cpf']").text("CPF");
      $("label[for='nome']").text("Nome");
      $("label[for='sobrenome']").text("Sobrenome");
      $("#rg").attr("placeholder", "RG");
      $("#cpf").attr("placeholder", "CPF");
      $("#nome").attr("placeholder", "Nome");
      $("#sobrenome").attr("placeholder", "Sobrenome");
    }
    if (selected.value=="0"){
      $("label[for='rg']").text("Inscrição Estadual");
      $("label[for='cpf']").text("CNPJ");
      $("label[for='nome']").text("Razão Social");
      $("label[for='sobrenome']").text("Nome Fantasia");
      $("#rg").attr("placeholder", "I.E.");
      $("#cpf").attr("placeholder", "CNPJ");
      $("#nome").attr("placeholder", "Razão Social");
      $("#sobrenome").attr("placeholder", "Nome Fantasia");
    }
   }
   @if (isset($contato->tipo))
    $(document).ready(tipoChange({{$contato->tipo}}));
    @elseif(!empty($contato) and $contato->id==1)
      var a = "a";
      var a = {value:"0"};
      $(document).ready(tipoChange(a));
    @endif

    $(function() {
      $('#froala-editor').froalaEditor({
        direction: 'ltr'
      })
    });
  </script>
@endsection
