<div class="modal-dialog modal-lg extra" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="">
        <i class="fa fa-user"></i>
        Detalhes&nbsp
        <span class="">ID: {{$contato->id}}</span>
      </h4>
    </div>
    <div class="modal-body">
      <div class="row">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#detalhes" aria-controls="detalhes" role="tab" data-toggle="tab">Detalhes</a></li>
            <li role="presentation"><a href="#enderecos" aria-controls="enderecos" role="tab" data-toggle="tab">Endereços</a></li>
            <li role="presentation"><a href="#telefones" aria-controls="telefones" role="tab" data-toggle="tab">Cont/Tels/E-mails</a></li>
            @if ($contato->funcionario)
              <li role="presentation"><a href="#funcionario" aria-controls="funcionario" role="tab" data-toggle="tab">Funcionario</a></li>
            @endif
            <li role="presentation"><a href="#obs" aria-controls="obs" role="tab" data-toggle="tab">Observações</a></li>
            <li role="presentation"><a href="#anexos" aria-controls="anexos" role="tab" data-toggle="tab">Anexos</a></li>
            <li role="presentation"><a href="#relacionamentos" aria-controls="relacionamentos" role="tab" data-toggle="tab">Relacionamentos</a></li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade" id="relacionamentos"><br>
              <div class="col-md-12">
                <strong>Relações:</strong>
                @foreach($contato->from as $key => $from)
                  <div class="row">
                    {{str_limit($from->nome, 20)}} é <span class="label label-info">{{$from->pivot->to_text}}</span> de {{str_limit($contato->nome, 20)}}
                  </div>
                @endforeach
                @foreach($contato->to as $key => $to)
                  <div class="row">
                    {{str_limit($to->nome, 20)}} é <span class="label label-info">{{$to->pivot->from_text}}</span> de {{str_limit($contato->nome, 20)}}
                  </div>
                @endforeach
              </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="telefones"><br>
              <div class="col-md-12">
                <strong>Telefone e E-Mails</strong><br>
                <div class="row">
                  @foreach ($comboboxes_telefones as $key => $comboboxes)
                    <div class="col-md-6">
                      <div class="panel panel-default">
                        <div class="panel-body">
                          <strong>{{$comboboxes->text}}</strong><br>
                          @foreach($contato->telefones as $key2 => $telefone)
                            @if ($telefone->tipo==$comboboxes->text)
                              <span id="telefone{{$telefone->id}}">
                                <a onclick="deleteTelefone({{$telefone->id}})" class="btn btn-danger btn-xs"><i class="fa fa-ban"></i></a>
                                <span class="">{{$telefone->contato}}, {{$telefone->setor}}</strong></span> {{ $telefone->numero or "" }}<br>
                              </span>
                            @endif
                          @endforeach
                        </div>
                      </div>

                    </div>
                  @endforeach

                </div>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="anexos"><br>
                <div class="col-md-12">
                  <strong>Anexos</strong>
                  @foreach($contato->attachsToo as $key => $attach)
                    <div class="row">
                      {{$attach->name}}
                      <a href="{{ url('/attach') }}/{{$attach->id}}/get"><span class="label label-info" >Download</span></a>
                      <a href="{{ url('/attach') }}/{{$attach->id}}/delete"><span class="label label-danger" >Apagar</span></a>
                    </div>
                  @endforeach
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade in active" id="detalhes"><br>
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-12" style="margin-bottom:15px;">
                    <span class="h2" >
                      @if(is_null($contato->active))
                        <i class="fa fa-user level1"></i>
                      @else
                        <i class="fa fa-user level{{$contato->active}}"></i>
                      @endif
                      <i class="fa fa-signal level{{$contato->sociabilidade}}"></i>
                      @if ($contato->funcionario)
                        Funcionario:
                        <span class="label label-success">
                          <i class="fa fa-user"></i> {{$contato->user->trabalho->nome}}
                        </span>
                      @endif
                    </span>
                  </div>
                </div>
                <div class="row">
                  @if ($contato->tipo=="0")
                  <div class="col-md-12">
                    <strong>Nome Fantasia</strong><br>
                    <span style="font-size:30px">{{$contato->sobrenome}}</span>
                  </div>
                  @else
                    <div class="col-md-12">
                      <strong>Nome: </strong><br>
                      <span style="font-size: 30px">{{$contato->nome}}&nbsp{{$contato->sobrenome}}</span>
                    </div>
                  @endif
                </div>
                @if ($contato->funcionario)
                  <div class="row">
                    <div class="col-md-12">
                      <strong>Cargo:</strong> {{$contato->funcionario->cargo}}
                    </div>
                  </div>
                @endif
                @if ($contato->funcionario)
                  <div class="row">
                    <div class="col-md-12">
                      Data adm.: <span class="">{{$contato->funcionario->data_adm}}</span>
                      Data dem.: <span class="">{{$contato->funcionario->data_dem}}</span>
                    </div>
                  </div>
                @endif
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    @if ($contato->tipo=="0")
                      <div class="row">
                        <div class="col-md-2">
                          <strong>Razão Social:</strong>
                        </div>
                        <div class="col-md-10">
                          <span class="">{{$contato->nome}}</span>
                        </div>
                      </div>
                    @endif
                    <div class="row">
                      <div class="col-md-2">
                        <strong>{{{$contato->tipo=="0" ? "CNPJ" : "CPF"}}}:</strong>
                      </div>
                      <div class="col-md-5">
                        <span class="">{{$contato->cpf}}</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <strong>{{{$contato->tipo=="0" ? "I.E." : "RG"}}}:</strong>
                      </div>
                      <div class="col-md-5">
                        <span class="">{{$contato->rg}}</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <strong>Ins. Pref.:</strong>
                      </div>
                      <div class="col-md-5">
                        <span class="">{{$contato->cod_prefeitura}}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="enderecos"><br>
              <div class="col-md-12">
                <strong>Endereços</strong><br>
                <div class="row">
                  @foreach ($contato->enderecos as $key => $endereco)
                    <div class="col-md-6">
                      <div class="panel panel-default" id="endereco{{$endereco->id}}">
                        <div class="panel-body">
                          <a onclick="deleteEndereco({{$endereco->id}})" class="btn btn-danger btn-xs">
                            <i class="fa fa-ban"></i>
                          </a>
                          <strong>{{$endereco->tipo}}</strong><br>
                          {{$endereco->endereco}} {{$endereco->numero}} {{$endereco->complemento}}<br>
                          {{$endereco->bairro}}<br>
                          {{$endereco->cep}} - {{$endereco->cidade}}, {{$endereco->uf}}
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="obs"><br>
              <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                  <strong>Observações</strong>
                  <div class="panel panel-default">
                    <div class="panel-body">
                      {!! $contato->obs !!}
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @if ($contato->funcionario)
              <div role="tabpanel" class="tab-pane fade" id="funcionario"><br>
                <div class="col-md-12">
                  <h3><strong>Funcionario</strong></h3>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="row">
                        <div class="col-md-7">
                          <strong>N. CNH:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">{{$contato->funcionario->cnh}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>Cat. CNH:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">{{$contato->funcionario->cnh_cat}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>Venc. CNH:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">{{$contato->funcionario->cnh_venc}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>Cart. Trab.:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">{{$contato->funcionario->cart_trab_num}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>Cart. Trab. Serie:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">{{$contato->funcionario->cart_trab_serie}}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="row">
                        <div class="col-md-7">
                          <strong>N. Eleitor:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">{{$contato->funcionario->eleitor}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>Sessão de Eleitor:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">{{$contato->funcionario->eleitor_sessao}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>Zona de Eleitor:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">{{$contato->funcionario->eleitor_zona}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>Data de Exp. de Eleitor:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">{{$contato->funcionario->eleitor_exp}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>N. do RG:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">{{$contato->funcionario->rg}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>Nome do Pai:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">{{$contato->funcionario->rg_pai}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>Nome da Mãe:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">{{$contato->funcionario->rg_mae}}</span>
                        </div>
                      </div>

                    </div>
                    <div class="col-md-4">
                      <div class="row">
                        <div class="col-md-7">
                          <strong>N. do PIS:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">{{$contato->funcionario->pis}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>Banco do PIS:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">{{$contato->funcionario->pis_banco}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>N. do INSS:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">{{$contato->funcionario->inss}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>N. de reservista:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">{{$contato->funcionario->reservista}}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="row">
                        <div class="col-md-7">
                          <strong>Salario:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">R$ {{$contato->funcionario->sal}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>Salario real:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">R$ {{$contato->funcionario->sal_real}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>V. Transp.:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">R$ {{$contato->funcionario->vt}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>Percentual do VT:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">{{$contato->funcionario->vt_percentual}} %</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>V. Alim.:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">R$ {{$contato->funcionario->va}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>V. Refei.:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">R$ {{$contato->funcionario->vr}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>INSS:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">R$ {{$contato->funcionario->inss}}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="row">
                        <div class="col-md-7">
                          <strong>Usuario:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">{{$contato->user->email}}</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>Senha:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">***</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7">
                          <strong>Estado:</strong>
                        </div>
                        <div class="col-md-5">
                          <span class="">{{{$contato->user->ativo=="1" ? "Ativo" : "Inativo"}}}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endif
          </div>
        </div>
    </div>
    <div class="modal-footer">
      @botaoFecharModal
      @botaoEditarExtenso(novo/contatos*$contato->id)
    </div>
  </div>
</div>
<script>
function deleteEndereco(id){
   var a = "{{url('/lista/contatos')}}/{{$contato->id}}/enderecos/"+id+"/delete"
   $.get( a, function( data ) {
     $( "#endereco"+id ).remove();
   });
 };
 function deleteTelefone(id){
   var a = "{{ url('lista/contatos') }}/{{$contato->id}}/telefones/"+id+"/delete"
   $.get( a, function( data ) {
     $( "#telefone"+id ).remove();
   });
 };
</script>
