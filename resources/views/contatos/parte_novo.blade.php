<ul class="nav nav-tabs" role="tablist" id="thirdNavbar">
  <li role="presentation" class="active"><a href="#documentos" aria-controls="documentos" role="tab" data-toggle="tab">Nome e documentos</a></li>
  <li role="presentation"><a href="#endereco" aria-controls="endereco" role="tab" data-toggle="tab">Endereço</a></li>
  <li role="presentation"><a href="#telefones" aria-controls="telefones" role="tab" data-toggle="tab">Formas de contato</a></li>
  @if (isset($is_funcionario))
    <li role="presentation"><a href="#funcionario" aria-controls="funcionario" role="tab" data-toggle="tab">Funcionario</a></li>
  @endif
  <li role="presentation"><a href="#obs" aria-controls="obs" role="tab" data-toggle="tab">Observações</a></li>
  <li role="presentation"><a href="#anexos" aria-controls="obs" role="anexos" data-toggle="tab">Anexos</a></li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
  <div role="tabpanel" class="tab-pane fade in active" id="documentos"><br>
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
            <input type="radio" name="sociabilidade" id="sociabilidade" value="1" @if (!empty($contato->sociabilidade)){{{$contato->sociabilidade==1 ? "checked" : ""}}}@endif > <i class="fa fa-signal level1"></i>
            <input type="radio" name="sociabilidade" id="sociabilidade" value="2" @if (!empty($contato->sociabilidade)){{{$contato->sociabilidade==2 ? "checked" : ""}}}@endif><i class="fa fa-signal level2"></i>
            <input type="radio" name="sociabilidade" id="sociabilidade" value="3" @if (!empty($contato->sociabilidade)){{{$contato->sociabilidade==3 ? "checked" : ""}}}@endif><i class="fa fa-signal level3"></i>
            <input type="radio" name="sociabilidade" id="sociabilidade" value="4" @if (!empty($contato->sociabilidade)){{{$contato->sociabilidade==4 ? "checked" : ""}}}@endif><i class="fa fa-signal level4"></i>
            <input type="radio" name="sociabilidade" id="sociabilidade" value="5" @if (!empty($contato->sociabilidade)){{{$contato->sociabilidade==5 ? "checked" : ""}}}@endif><i class="fa fa-signal level5"></i>
          </div>
          <div class="form-group">
            <label for="actived">Ativo</label><br>
            <input type="checkbox" name="active" id="active" value="1" checked>Dados Validos
          </div>
          <div class="form-group" id="tipo_filialFormGroup" style="display:none;">
            <label for="sociabilidade">é Filial?</label>
            <select class="form-control" id="tipo_filial" name="tipo_filial">
              @if (isset($contato))
                @if ($is_filial!=FALSE)
                  <option value="1" selected>Sim</option>
                  <option>Não</option>
                @else
                  <option value="1">Sim</option>
                  <option selected>Não</option>
                @endif
              @else
                <option value="" selected>Não</option>
                <option value="1" >Sim</option>
              @endif
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
  @if (isset($is_funcionario))
    <div role="tabpanel" class="tab-pane fade" id="funcionario"><br>
        @include('contatos.funcionarios.new')
    </div>
  @endif
  <div role="tabpanel" class="tab-pane fade" id="endereco"><br>
    <div class="panel panel-default">
      <div class="panel-heading">Endereços</div>
      <div class="panel-body">
        <div class="col-md-1 pull-right text-right">
          <div data-spy="affix" data-offset-top="60" data-offset-bottom="200"  style="width: 100px;">
            <a class="btn btn-danger" onclick="removeEndereco()">
              <i class="fa fa-minus"></i>
            </a>
            <a class="btn btn-success" onclick="addEndereco()">
              <i class="fa fa-plus"></i>
            </a>
          </div>
        </div>
        <div class="col-md-11">
          <span id="mais_endereco">
            @if(isset($contato))
              @foreach ($contato->enderecos as $key => $endereco)
                <div class="panel panel-default" id="endereco{{$endereco->id}}">
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-md-1">
                        <label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                        <a onclick="deleteEndereco({{$endereco->id}})" class="btn btn-danger btn-sm">
                          <i class="fa fa-ban"></i>
                        </a>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="endereco_tipo">Tipo</label>
                          <select name="endereco_tipo_edit[{{$key}}]" id="endereco_tipo_edit" class="form-control">
                            <option value="{{$endereco->tipo}}" selected>{{$endereco->tipo}} (atual)</option>
                            <option value="Correspondencia">Correspondencia</option>
                            <option value="Cobrança">Cobrança</option>
                            <option value="Entrega">Entrega</option>
                            <option value="Comercial">Comercial</option>
                            <option value="Residencia">Residencia</option>
                            <option value="Outro">Outro</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="cep">CEP</label>
                          <input type="hidden" class="form-control" name="endereco_id[{{$key}}]" value="{{ $endereco->id or "" }}">

                          <input type="text" class="form-control" value="{{ $endereco->cep or "" }}" name="cep_edit[{{$key}}]" id="cep_edit{{$key}}" onchange="selectCep_edit({{$key}})">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-7">
                        <div class="form-group">
                          <label for="endereco">Endereço</label>
                          <input type="text" class="form-control" value="{{ $endereco->endereco or "" }}"  name="endereco_edit[{{$key}}]" id="endereco_edit{{$key}}">
                        </div>
                      </div><div class="col-md-2">
                        <div class="form-group">
                          <label for="endereco">Numero</label>
                          <input type="text" class="form-control" value="{{ $endereco->numero or "" }}"  name="numero_edit[{{$key}}]" id="numero_edit{{$key}}">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="sala">Complemento</label>
                          <input type="text" class="form-control" value="{{ $endereco->complemento or "" }}" name="complemento_edit[{{$key}}]" id="complemento_edit{{$key}}">
                        </div>
                      </div>

                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="bairro">Bairro</label>
                          <input type="text" class="form-control" value="{{ $endereco->bairro or "" }}" name="bairro_edit[{{$key}}]" id="bairro_edit{{$key}}">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="cidade">Cidade</label>
                          <input type="text" class="form-control" value="{{ $endereco->cidade or "" }}" name="cidade_edit[{{$key}}]" id="cidade_edit{{$key}}">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="uf">UF</label>
                          <input type="text" class="form-control" value="{{ $endereco->uf or "" }}" name="uf_edit[{{$key}}]" id="uf_edit{{$key}}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            @endif
          </span>
        </div>
      </div>
    </div>
  </div>
  <div role="tabpanel" class="tab-pane fade" id="telefones"><br>
    <div class="panel panel-default">
      <div class="panel-heading">Telefones</div>
      <div class="panel-body">
          <div class="col-md-1 pull-right text-right">
            <div data-spy="affix" data-offset-top="60" data-offset-bottom="200"  style="width: 100px;">
              <a class="btn btn-danger" onclick="remove()">
                <i class="fa fa-minus"></i>
              </a>
              <a class="btn btn-success" onclick="add()">
                <i class="fa fa-plus"></i>
              </a>

            </div>
          </div>
          @if (isset($contato) and $contato->telefones!="[]")
            @foreach($contato->telefones as $key => $telefone)
              <div class="col-md-11" id="telDiv{{$telefone->id}}">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="col-md-1">
                      <div class="form-group">
                        <label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                        <button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Deletar" onclick="telDelete({{$telefone->id}})">
                          <i class="fa fa-ban"></i>
                        </button>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <input type="hidden" class="form-control" value="{{$telefone->id}}" name="id_tel[{{$key}}]" id="id_tel[{{$key}}]" placeholder="">
                        <label for="text">Tipo</label>
                        <select class="form-control" id="tipo_id{{$key}}" name="tipo_id[{{$key}}]" onchange="selMask({{$key}}, 1)">
                          <option value="{{$telefone->tipo}}" selected>{{$telefone->tipo}}</option>
                          @foreach($comboboxes_telefones as $a => $combobox)
                            <option value="{{$combobox->text}}">{{$combobox->text}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="text" id="numeroText_id{{$key}}">
                          @foreach($comboboxes_telefones as $a => $combobox)
                            @if ($combobox->text==$telefone->tipo)
                              {{$combobox->value}}
                            @endif
                          @endforeach
                        </label>
                        <input type="text" class="form-control" value="{{$telefone->numero}}" name="numero_id[{{$key}}]" id="numero_id{{$key}}" placeholder="">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="text">Contato</label>
                        <input type="text" class="form-control" value="{{$telefone->contato}}" name="contato_id[{{$key}}]" id="contato_id{{$key}}" placeholder="">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="text">Depto/Setor</label>
                        <input type="text" class="form-control" value="{{$telefone->setor}}" name="setor_id[{{$key}}]" id="setor_id{{$key}}" placeholder="">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="text">Ramal</label>
                        <input type="text" class="form-control" value="{{$telefone->ramal}}" name="ramal_id[{{$key}}]" id="numero_id{{$key}}" placeholder="">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          @endif

          <span id="mais"></span>
      </div>
    </div>
  </div>
  <div role="tabpanel" class="tab-pane fade" id="obs"><br>
    <div class="row">
      <div class="col-md-12">
        <label>Observação</label>
        <textarea name="obs">@if (isset($contato)) {!!$contato->obs!!} @endif</textarea>
      </div>
    </div>
  </div>
  <div role="tabpanel" class="tab-pane fade" id="anexos"><br>
    <div class="col-md-3 pull-right">
      <div class="panel panel-danger">
        <div class="panel-heading">
          <h3 class="panel-title">Atenção!</h3>
        </div>
        <div class="panel-body">
            Anexos colocados aqui seram ADICIONADOS e <strong>NÃO</strong> editados!
        </div>
      </div>
    </div>
    <div class="col-md-9">

    </div>
  </div>
</div>


            @if(Request::url()=== 'url("novo/contatos")')
              <div class="row">
                <div class="form-group">
                  <label for="obs">Obs:</label>
                  <textarea  name="obs">
                    {!! $contato->obs or "" !!}
                  </textarea>
                </div>
              </div>
            @endif

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
      $("#tipo_filialFormGroup").hide();
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
      $("#tipo_filialFormGroup").show();
    }
   }

   @if (isset($contato))
     function telDelete(id){
        var a = "{{url('/lista/contatos')}}/{{$contato->id}}/telefones/"+id+"/delete"
        $.get( a, function( data ) {
          $( "#telDiv"+id ).remove();
        });
     };
     function deleteEndereco(id){
        var a = "{{url('/lista/contatos')}}/{{$contato->id}}/enderecos/"+id+"/delete"
        $.get( a, function( data ) {
          $( "#endereco"+id ).remove();
        });
     };
   @endif

   $(document).ready(tipoChange());
</script>
<script language="javascript">
window.i = -1;
window.i_endereco = -1;

function add() {
  i = i + 1;
  console.log("valor de i: "+i);
  var $clone = $($('#ToClone').html());
  $('#tipo', $clone).attr('name', 'tipo_tel['+i+']');
  $('#tipo', $clone).attr('onchange', 'selMask('+i+', 0)');
  $('#tipo', $clone).attr('id', 'tipo'+i);
  $('#numero', $clone).attr('name', 'numero_tel['+i+']');
  $('#numero', $clone).attr('id', 'numero'+i);
  $('#numeroText', $clone).attr('id', 'numeroText'+i);
  $('#contato', $clone).attr('name', 'contato_tel['+i+']');
  $('#setor', $clone).attr('name', 'setor_tel['+i+']');
  $('#ramal', $clone).attr('name', 'ramal_tel['+i+']');
  $('.3397', $clone).attr('id', 'linha'+i);
  $clone.appendTo('#mais');
}
function addEndereco() {
  var $clone = $($('#ToCloneEndereco').html());
  i_endereco = i_endereco + 1;
  $('#cep', $clone).attr('name', 'cep['+i_endereco+']');
  $('#cep', $clone).mask('99999-999');
  $('#cep', $clone).attr('onchange', 'selectCep('+i_endereco+')');
  $('#endereco', $clone).attr('name', 'endereco['+i_endereco+']');
  $('#numero', $clone).attr('name', 'numero['+i_endereco+']');
  $('#complemento', $clone).attr('name', 'complemento['+i_endereco+']');
  $('#bairro', $clone).attr('name', 'bairro['+i_endereco+']');
  $('#cidade', $clone).attr('name', 'cidade['+i_endereco+']');
  $('#uf', $clone).attr('name', 'uf['+i_endereco+']');
  $('#endereco_tipo', $clone).attr('name', 'endereco_tipo['+i_endereco+']');
  $('#cep', $clone).attr('id', 'cep'+i_endereco);
  $('#endereco', $clone).attr('id', 'endereco'+i_endereco);
  $('#numero', $clone).attr('id', 'numero'+i_endereco);
  $('#complemento', $clone).attr('id', 'complemento'+i_endereco);
  $('#bairro', $clone).attr('id', 'bairro'+i_endereco);
  $('#cidade', $clone).attr('id', 'cidade'+i_endereco);
  $('#uf', $clone).attr('id', 'uf'+i_endereco);
  $('#endereco_tipo', $clone).attr('id', 'endereco_tipo'+i_endereco);
  $('.3397', $clone).attr('id', 'linha_endereco'+i_endereco);
  $clone.appendTo('#mais_endereco');
}
function remove() {
  if (i<0){}else {
    $('#linha'+i).remove();
    if(i>0){
      i = i - 1;
    }
  }
}
function removeEndereco() {
  console.log(i_endereco)
  if (i_endereco<0){}else {
    $('#linha_endereco'+i_endereco).remove();
    if(i_endereco>0){
      i_endereco = i_endereco - 1;
    }
  }
}
function selMask(a, b){
  if (b==1){
    @foreach($comboboxes_telefones as $asas => $combobox)
      if (($("#tipo_id"+a).val()=="{{$combobox->text}}")){
        var x = "{{$combobox->value}}";
        $("#numero_id"+a).mask("{{$combobox->field}}");
        if ("{{$combobox->field}}"==""){
          $("#numero_id"+a).unmask();
        }
        $("#numeroText_id"+a).text(x);
      }
    @endforeach
  } else {
    @foreach($comboboxes_telefones as $asas => $combobox)
    if (($("#tipo"+a).val()=="{{$combobox->text}}")){
      var x = "{{$combobox->value}}";
      $("#numero"+a).mask("{{$combobox->field}}");
      console.log("valor de mask: {{$combobox->field}}");

      console.log("valor de x: "+x);
      console.log("id= numero"+a);
      if ("{{$combobox->field}}"==""){
        $("#numero"+a).unmask();
        console.log("demask este");
      }
      $("#numeroText"+a).text(x);
    }
    @endforeach
  }
}

function selectCep(a){
  var cep = "{{url('busca/cep')}}/"+$('#cep'+a).val();
  $('#endereco'+a).prop('disabled', true);
  $('#bairro'+a).prop('disabled', true);
  $('#cidade'+a).prop('disabled', true);
  $('#uf'+a).prop('disabled', true);
  $.ajax({
    type: 'GET',
    url: cep,
    data: { get_param: 'value' },
    dataType: 'json',
    success: function( data ) {
      $("#endereco"+a).val(data.tp_logradouro+" "+data.logradouro);
      $("#bairro"+a).val(data.bairro);
      $("#cidade"+a).val(data.cidade);
      $("#uf"+a).val(data.uf);

    },
    complete: function () {
      $('#endereco'+a).prop('disabled', false);
      $('#bairro'+a).prop('disabled', false);
      $('#cidade'+a).prop('disabled', false);
      $('#uf'+a).prop('disabled', false);
    }
  });
}
function selectCep_edit(a){
  var cep = "{{url('busca/cep')}}/"+$('#cep_edit'+a).val();
  $('#endereco_edit'+a).prop('disabled', true);
  $('#bairro_edit'+a).prop('disabled', true);
  $('#cidade_edit'+a).prop('disabled', true);
  $('#uf_edit'+a).prop('disabled', true);
  $.ajax({
    type: 'GET',
    url: cep,
    data: { get_param: 'value' },
    dataType: 'json',
    success: function( data ) {
      $("#endereco_edit"+a).val(data.tp_logradouro+" "+data.logradouro);
      $("#bairro_edit"+a).val(data.bairro);
      $("#cidade_edit"+a).val(data.cidade);
      $("#uf_edit"+a).val(data.uf);

    },
    complete: function () {
      $('#endereco_edit'+a).prop('disabled', false);
      $('#bairro_edit'+a).prop('disabled', false);
      $('#cidade_edit'+a).prop('disabled', false);
      $('#uf_edit'+a).prop('disabled', false);
    }
  });
}

</script>

<script id="ToClone" type="text/template">
<span>
  <div class="3397 col-md-11" id="a">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="col-md-2">
          <div class="form-group">
            <label for="text">Tipo</label>
            <select class="form-control" id="tipo" name="tipo_tel[0]" onchange="selMask()">
              <option value="" selected> - Escolha uma opção - </option>
              @foreach($comboboxes_telefones as $key => $combobox)
                <option value="{{$combobox->text}}">{{$combobox->text}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="text" id="numeroText">Numero</label>
            <input type="text" class="form-control" value="" name="numero_tipo" id="numero" placeholder="">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="text">Contato</label>
            <input type="text" class="form-control" value="" name="contato_tel" id="contato" placeholder="">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label for="text">Depto/Setor</label>
            <input type="text" class="form-control" value="" name="setor_tel" id="setor" placeholder="">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label for="text">Ramal</label>
            <input type="text" class="form-control" value="" name="ramal_tel" id="ramal" placeholder="">
          </div>
        </div>
      </div>
    </div>
  </div>
</span>
</script>
<script id="ToCloneEndereco" type="text/template">
  <span>
    <div class="panel panel-default 3397" id="">
  <div class="panel-body">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="endereco_tipo">Tipo</label>
          <select name="endereco_tipo" id="endereco_tipo" class="form-control">
            <option value="">- Escolha -</option>
            <option value="Correspondencia">Correspondencia</option>
            <option value="Faturamento">Faturamento</option>
            <option value="Entrega">Entrega</option>
            <option value="Comercial">Comercial</option>
            <option value="Residencia">Residencia</option>
            <option value="Outro">Outro</option>
          </select>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for="cep">CEP</label>
          <input type="text" class="form-control"  name="cep" id="cep" placeholder="CEP" onchange="selectCep()">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-7">
        <div class="form-group">
          <label for="endereco">Endereço</label>
          <input type="text" class="form-control"  name="endereco" id="endereco" placeholder="Endereço">
        </div>
      </div><div class="col-md-2">
        <div class="form-group">
          <label for="endereco">Numero</label>
          <input type="text" class="form-control"  name="numero" id="numero_endereco" placeholder="Nº">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="sala">Complemento</label>
          <input type="text" class="form-control" value="{{ $contato->complemento or "" }}" name="complemento" id="complemento" placeholder="Complemento">
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
  </span>
</script>
