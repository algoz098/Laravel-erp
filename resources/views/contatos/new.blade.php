@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      @if (isset($is_funcionario))
        <form method="POST" action="{{ url('/novo/funcionarios') }}">
      @else
        @if (!empty($contato->id))
          <form method="POST" action="{{ url('/novo/contatos') }}/{{$contato->id}}">
        @else
          <form method="POST" action="{{ url('novo/contatos') }}">
        @endif
      @endif
        <div class="form-group">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{$contato->id or "" }}">
        <div class="panel panel-default">
          <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Adicionar entidade</div>
          <div class="panel-body">
            <div class="row text-right" id="secondNavbar">
              <div class="col-sm-offset-2 col-sm-10">
                <a class="btn btn-warning" href="{{ url('lista/contatos')}}" ><i class="fa fa-users"></i> Voltar a Lista</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
              </div>
            </div>
            @if (!empty($contato->id))
              <div class="row">
                <div class="col-md-4">
                  <h1>
                    <span class="label label-info">ID: {{$contato->id}}</span>
                  </h1>
                </div>
              </div>
            @endif
            <div class="row">
              <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-heading">Sobre</div>
                  <div class="panel-body">
                    <div class="form-group">
                      <label for="text">Tipo de Entidade</label>
                      @if (!isset($is_funcionario))
                        @if (!empty($contato) and $contato->id===1)
                          <select class="form-control" id="tipo" disabled>
                            <option value="0" selected>PJ - Pessoa Juridica</option>
                          </select>
                        @elseif(!empty($contato) and $contato->tipo=="1")
                          <select class="form-control" name="tipo" id="tipo" >
                            <option value=""> - Escolha uma opção - </option>
                            <option value="0" >PJ - Pessoa Juridica</option>
                            <option value="1" selected>PF - Pessoa Fisica</option>
                          </select>
                        @elseif(!empty($contato) and $contato->tipo=="0")
                          <select class="form-control" name="tipo" id="tipo" >
                            <option value=""> - Escolha uma opção - </option>
                            <option value="0" selected>PJ - Pessoa Juridica</option>
                            <option value="1" >PF - Pessoa Fisica</option>
                          </select>
                        @else
                          <select class="form-control" id="tipo" name="tipo" onchange="tipoChange(this)">
                            <option value="" selected> - Escolha uma opção - </option>
                            <option value="0" >PJ - Pessoa Juridica</option>
                            <option value="1" >PF - Pessoa Fisica</option>
                          </select>
                        @endif
                      @else
                        <select class="form-control" id="tipo" name="tipo" onchange="tipoChange(this)" disabled>
                          <option value="1" selected>PF - Pessoa Fisica</option>
                        </select>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="nome">Nome ou Razão Social</label>
                      <input type="text" class="form-control" value="{{ $contato->nome or "" }}" name="nome" id="nome" placeholder="Razão Social/Nome">
                    </div>
                    <div class="form-group">
                      <label for="sobrenome">Nome Fantasia/Sobrenome</label>
                      <input type="text" class="form-control" value="{{ $contato->sobrenome or "" }}" name="sobrenome" id="sobrenome" placeholder="Nome Fantasia/Sobrenome">
                    </div>
                    @if ($field_codigo->value=="1")
                      <div class="form-group">
                        <label for="codigo">Codigo</label>
                        <input type="text" class="form-control" value="{{ $contato->codigo or "" }}" name="codigo" id="codigo" placeholder="Codigo">
                      </div>
                    @endif
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-heading">Documentos</div>
                  <div class="panel-body">
                    <div class="form-group">
                      <label for="cpf">CNPJ ou CPF</label>
                      <input type="text" class="form-control" value="{{ $contato->cpf or "" }}" name="cpf" id="cpf" placeholder="CNPJ\CPF">
                    </div>
                    <div class="form-group">
                      <label for="rg">Inscrição Estadual ou RG</label>
                      <input type="text" class="form-control rg" value="{{ $contato->rg or "" }}" name="rg" id="rg" placeholder="I.E.\RG">
                    </div>
                    <div class="form-group">
                      <label for="cod_prefeitura" id="cod_prefeituraHolder">Inscrição da Prefeitura</label>
                      <input type="text" class="form-control" value="{{ $contato->cod_prefeitura or "" }}" name="cod_prefeitura" id="cod_prefeitura" placeholder="Codigo da prefeitura">
                    </div>
                    <div class="form-group" id="nascimentoHolder">
                      <label for="codigo">Data de Nascimento</label>
                      <input type="text" class="form-control datepicker" value="{{ $contato->nascimento or "" }}" name="nascimento" id="nascimento" >
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 pull-right">
                <div class="panel panel-default">
                  <div class="panel-heading">Interno</div>
                  <div class="panel-body">
                    <div class="form-group">
                      <label for="sociabilidade">Sociabilidade</label><br>
                      <input type="radio" name="sociabilidade" id="sociabilidade" value="1" @if (!empty($contato->sociabilidade)){{{$contato->sociabilidade==1 ? "checked" : ""}}}@endif><i class="fa fa-signal level1"></i>
                      <input type="radio" name="sociabilidade" id="sociabilidade" value="2" @if (!empty($contato->sociabilidade)){{{$contato->sociabilidade==2 ? "checked" : ""}}}@endif><i class="fa fa-signal level2"></i>
                      <input type="radio" name="sociabilidade" id="sociabilidade" value="3" @if (!empty($contato->sociabilidade)){{{$contato->sociabilidade==3 ? "checked" : ""}}}@endif><i class="fa fa-signal level3"></i>
                      <input type="radio" name="sociabilidade" id="sociabilidade" value="4" @if (!empty($contato->sociabilidade)){{{$contato->sociabilidade==4 ? "checked" : ""}}}@endif><i class="fa fa-signal level4"></i>
                      <input type="radio" name="sociabilidade" id="sociabilidade" value="5" @if (!empty($contato->sociabilidade)){{{$contato->sociabilidade==5 ? "checked" : ""}}}@endif><i class="fa fa-signal level5"></i>
                    </div>
                    <div class="form-group">
                      <label for="actived">Ativo</label><br>
                      <input type="checkbox" name="active" id="active" value="1" checked>Dados Validos
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="panel panel-default">
                  <div class="panel-heading">Endereço</div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="cep">CEP</label>
                          <input type="text" class="form-control" value="{{ $contato->cep or "" }}" name="cep" id="cep" placeholder="CEP">
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
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="bairro">Bairro</label>
                          <input type="text" class="form-control" value="{{ $contato->bairro or "" }}" name="bairro" id="bairro" placeholder="Bairro">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="sala">Sala</label>
                          <input type="text" class="form-control" value="{{ $contato->sala or "" }}" name="sala" id="Sala" placeholder="Sala">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="andar">Andar</label>
                          <input type="text" class="form-control" value="{{ $contato->andar or "" }}" name="andar" id="andar" placeholder="Andar">
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
                  </div>
                </div>
              </div>
            </div>
            @if (isset($contato) and $contato->telefones!="[]")
              <div class="panel panel-default">
                <div class="panel-heading">Telefones</div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-3 pull-right text-right">
                      <div class="row">
                        <div class="col-md-6 pull-right text-right" id="controleTel">
                          <div class="panel panel-default">
                            <div class="panel-body">
                              <a class="btn btn-danger" onclick="remove()">
                                <i class="fa fa-minus"></i>
                              </a>
                              <a class="btn btn-success" onclick="add()">
                                <i class="fa fa-plus"></i>
                              </a>
                            </div>
                            <div class="panel-heading">Controle</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @foreach($contato->telefones as $key => $telefone)
                      <div class="col-md-3" id="primeiroTel">
                        <div class="panel panel-default">
                          <div class="panel-body">
                            <div class="form-group">
                              <input type="hidden" class="form-control" value="{{$telefone->id}}" name="id_tel[{{$key}}]" id="id_tel[{{$key}}]" placeholder="">
                              <label for="text">Tipo</label>
                              <select class="form-control" id="tipo" name="tipo_id[{{$key}}]" onchange="selMask(0)">
                                <option value="{{$telefone->tipo}}" selected>{{$telefone->tipo}}</option>
                                @foreach($comboboxes_telefones as $a => $combobox)
                                  <option value="{{$combobox->text}}">{{$combobox->text}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="text">Numero</label>
                              <input type="text" class="form-control" value="{{$telefone->numero}}" name="numero_id[{{$key}}]" id="numero{{$key}}" placeholder="">
                            </div>
                            <div class="form-group">
                              <label for="text">Contato</label>
                              <input type="text" class="form-control" value="{{$telefone->contato}}" name="contato_id[{{$key}}]" id="contato{{$key}}" placeholder="">
                            </div>
                            <div class="form-group">
                              <label for="text">Depto/Setor</label>
                              <input type="text" class="form-control" value="{{$telefone->setor}}" name="setor_id[{{$key}}]" id="setor{{$key}}" placeholder="">
                            </div>
                            <div class="form-group">
                              <label for="text">Ramal</label>
                              <input type="text" class="form-control" value="{{$telefone->ramal}}" name="ramal_id[{{$key}}]" id="numero{{$key}}" placeholder="">
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach



                    <span id="mais"></span>
                  </div>
                  <div class="row">
                    <span id="maisRow2"></span>
                  </div>
                  <div class="row">
                    <span id="maisRow3"></span>
                  </div>
                  <div class="row">
                    <span id="maisRow4"></span>
                  </div>
                </div>
              </div>
              @else
                <div class="panel panel-default">
                  <div class="panel-heading">Telefones</div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-md-2 pull-right text-right">
                        <div class="panel panel-default">
                          <div class="panel-body">
                            <a class="btn btn-danger" onclick="remove()">
                              <i class="fa fa-minus"></i>
                            </a>
                            <a class="btn btn-success" onclick="add()">
                              <i class="fa fa-plus"></i>
                            </a>
                          </div>
                          <div class="panel-heading">Controle</div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="panel panel-default">
                          <div class="panel-body">
                            <div class="form-group">
                              <label for="text">Tipo</label>
                              <select class="form-control" id="tipo0" name="tipo_tel[0]" onchange="selMask(0)">
                                <option value="" selected> - Escolha uma opção - </option>
                                @foreach($comboboxes_telefones as $key => $combobox)
                                  <option value="{{$combobox->text}}">{{$combobox->text}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="text" id="numeroText0">Numero</label>
                              <input type="text" class="form-control" value="" name="numero_tel[0]" id="numero0" placeholder="">
                            </div>
                            <div class="form-group">
                              <label for="text">Contato</label>
                              <input type="text" class="form-control" value="" name="contato_tel[0]" id="contato0" placeholder="">
                            </div>
                            <div class="form-group">
                              <label for="text">Depto/Setor</label>
                              <input type="text" class="form-control" value="" name="setor_tel[0]" id="setor0" placeholder="">
                            </div>
                            <div class="form-group">
                              <label for="text">Ramal</label>
                              <input type="text" class="form-control" value="" name="ramal_tel[0]" id="ramal0" placeholder="">
                            </div>
                          </div>
                        </div>
                      </div>
                      <span id="mais"></span>
                    </div>
                    <div class="row">
                      <span id="maisRow2"></span>
                    </div>
                    <div class="row">
                      <span id="maisRow3"></span>
                    </div>
                    <div class="row">
                      <span id="maisRow4"></span>
                    </div>
                  </div>
                </div>
              @endif
            <span id="mais"></span>
            @if (isset($is_funcionario))
              @include('contatos.funcionarios.new')
            @endif
            <div class="row">
              <div class="form-group">
                <label for="obs">Obs:</label>
                <textarea  name="obs">
                  {!! $contato->obs or "" !!}
                </textarea>
              </div>
            </div>
            <div class="row text-right">
              <div class="form-group">
                <div class="col-md-12 col-sm-offset-2 col-sm-10">
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
  function tipoChange() {
    var b = $("#tipo").val();
    if (b=="1"){
      $("label[for='rg']").text("RG");
      $("label[for='cpf']").text("CPF");
      $("label[for='nome']").text("Nome");
      $("label[for='sobrenome']").text("Sobrenome");
      $("#nascimentoHolder").show();
      $("#rg").attr("placeholder", "RG");
      $("#cpf").attr("placeholder", "CPF");
      $("#nome").attr("placeholder", "Nome");
      $("#sobrenome").attr("placeholder", "Sobrenome");
      $("#cpf").mask("999.999.999-**");
      $("#rg").mask("**.***.***-*?*");
      $("#cod_prefeituraHolder").text("Insc. de Autonomo");
      $("#cod_prefeitura").attr("placeholder", "Insc. de Autonomo");
    }
    if (b=="0"){
      $("label[for='rg']").text("Inscrição Estadual");
      $("label[for='cpf']").text("CNPJ");
      $("label[for='nome']").text("Razão Social");
      $("label[for='sobrenome']").text("Nome Fantasia");
      $("#nascimentoHolder").hide();
      $("#rg").attr("placeholder", "I.E.");
      $("#cpf").attr("placeholder", "CNPJ");
      $("#nome").attr("placeholder", "Razão Social");
      $("#sobrenome").attr("placeholder", "Nome Fantasia");
      $("#cpf").mask("99.999.999/9999-99");
      $("#rg").mask("999.999.999.999");
      $("#cod_prefeituraHolder").text("Insc. da Prefeitura");
      $("#cod_prefeitura").attr("placeholder", "Insc. da Prefeitura");
    }
   }
   function heightControleTel(){
     $('#controleTel').height($('#primeiroTel').height());
   }

   $(document).ready(tipoChange());
   $(document).ready(heightControleTel());
</script>
<script language="javascript">
window.i = 0;
function add() {
  var $clone = $($('#ToClone').html());
  i = i + 1;
  $('#tipo', $clone).attr('name', 'tipo_tel['+i+']');
  $('#tipo', $clone).attr('onchange', 'selMask('+i+')');
  $('#tipo', $clone).attr('id', 'tipo'+i);
  $('#numero', $clone).attr('name', 'numero_tel['+i+']');
  $('#numero', $clone).attr('id', 'numero'+i);
  $('#numeroText', $clone).attr('id', 'numeroText'+i);
  $('#contato', $clone).attr('name', 'contato_tel['+i+']');
  $('#setor', $clone).attr('name', 'setor_tel['+i+']');
  $('#ramal', $clone).attr('name', 'ramal_tel['+i+']');
  $('.3397', $clone).attr('id', 'linha'+i);
  if (i>=9){
    $clone.appendTo('#maisRow4');
  }
  if (i>=6){
    $clone.appendTo('#maisRow3');
  }
  if (i>=3){
    $clone.appendTo('#maisRow2');
  } else {
    $clone.appendTo('#mais');
  }
}
function remove() {
  $('#linha'+i).remove();
  i = i - 1;
}
function selMask(a){
  @foreach($comboboxes_telefones as $asas => $combobox)
    if (($("#tipo"+a).val()=="{{$combobox->text}}")){
      var x = "{{$combobox->value}}";
      $("#numero"+a).mask("{{$combobox->field}}");
      if ("{{$combobox->field}}"==""){
        $("#numero"+a).unmask();
      }
      $("#numeroText"+a).text(x);
    }
  @endforeach
}
</script>

<script id="ToClone" type="text/template">
<div>
  <div class="3397" id="a">
    <div class="col-md-3">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="form-group">
            <label for="text">Tipo</label>
            <select class="form-control" id="tipo" name="tipo_tel[0]" onchange="selMask()">
              <option value="" selected> - Escolha uma opção - </option>
              @foreach($comboboxes_telefones as $key => $combobox)
                <option value="{{$combobox->value}}">{{$combobox->text}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="text" id="numeroText">Numero</label>
            <input type="text" class="form-control" value="" name="numero_tipo[0]" id="numero" placeholder="">
          </div>
          <div class="form-group">
            <label for="text">Contato</label>
            <input type="text" class="form-control" value="" name="contato_tel[0]" id="contato" placeholder="">
          </div>
          <div class="form-group">
            <label for="text">Depto/Setor</label>
            <input type="text" class="form-control" value="" name="setor_tel[0]" id="setor" placeholder="">
          </div>
          <div class="form-group">
            <label for="text">Ramal</label>
            <input type="text" class="form-control" value="" name="ramal_tel[0]" id="ramal" placeholder="">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</script>
@endsection
