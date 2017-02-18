<div class="modal-dialog modal-lg extra" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="">
        <i class="fa fa-user"></i>
        Detalhes
      </h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-md-12" style="margin-bottom:15px;">
          <span class="h1" >
            <span class="label label-info">ID: {{$contato->id}}</span>
            @if(is_null($contato->active))
              <i class="fa fa-user level1"></i>
            @else
              <i class="fa fa-user level{{$contato->active}}"></i>
            @endif
            <i class="fa fa-signal level{{$contato->sociabilidade}}"></i>
            @if ($contato->funcionario)
              Funcionario de:
              <span class="label label-success">
                <i class="fa fa-user"></i> {{$contato->user->trabalho->nome}}
              </span>
            @endif
          </span>
        </div>
      </div>
      <div class="row">
        @if ($contato->tipo=="0")
        <div class="col-md-6">
          <strong>Nome Fantasia</strong><br>
          <span style="font-size:30px">{{$contato->sobrenome}}</span>
        </div>
        @else
          <div class="col-md-8">
            <strong>Nome: </strong><br>
            <span style="font-size: 30px">{{$contato->nome}}&nbsp{{$contato->sobrenome}}</span>
          </div>
        @endif
      </div>
      @if ($contato->funcionario)
        <div class="row">
          <div class="col-md-4">
            Data adm.: <span class="label label-info">{{$contato->funcionario->data_adm}}</span>
            Data dem.: <span class="label label-danger">{{$contato->funcionario->data_dem}}</span>
          </div>
        </div>
      @endif
      <hr>
      <div class="row">
        <div class="col-md-6">
          @if ($contato->tipo=="0")
            <div class="row">
              <div class="col-md-3">
                <strong>Razão Social:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">{{$contato->nome}}</span>
              </div>
            </div>
          @endif
          <div class="row">
            <div class="col-md-3">
              <strong>{{{$contato->tipo=="0" ? "CNPJ" : "CPF"}}}:</strong>
            </div>
            <div class="col-md-5">
              <span class="label label-info">{{$contato->cpf}}</span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <strong>{{{$contato->tipo=="0" ? "I.E." : "RG"}}}:</strong>
            </div>
            <div class="col-md-5">
              <span class="label label-info">{{$contato->rg}}</span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <strong>Ins. Pref.:</strong>
            </div>
            <div class="col-md-5">
              <span class="label label-info">{{$contato->cod_prefeitura}}</span>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <strong>Endereço</strong><br>
          {{$contato->endereco}} {{$contato->numero}} {{$contato->complemento}}<br>
          {{$contato->bairro}} - {{$contato->cidade}}, {{$contato->uf}}<br>
          {{$contato->cep}}
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-6">
          <strong>Telefone e E-Mails</strong><br>
          @foreach($contato->telefones as $key => $telefone)
            <a href="{{ url('lista/contatos') }}/{{$contato->id}}/telefones/{{ $telefone->id }}/delete" class="btn btn-danger btn-xs"><i class="fa fa-ban"></i></a>
            <span class="label label-info">{{ $telefone->tipo or "" }}</span> {{ $telefone->numero or "" }} <br>
          @endforeach
        </div>
        <div class="col-md-6">
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
      @if ($contato->funcionario)
        <hr>
        <strong> Do funcionario</strong>
        <div class="row">
          <div class="col-md-3">
            <div class="row">
              <div class="col-md-7">
                <strong>Cargo:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">{{$contato->funcionario->cargo}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>N. CNH:</strong>
              </div>
              <div class="col-md-5">
              <span class="label label-info">{{$contato->funcionario->cnh}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>Cat. CNH:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">{{$contato->funcionario->cnh_cat}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>Venc. CNH:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-danger">{{$contato->funcionario->cnh_venc}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>Cart. Trab.:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">{{$contato->funcionario->cart_trab_num}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>Cart. Trab. Serie:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">{{$contato->funcionario->cart_trab_serie}}</span>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="row">
              <div class="col-md-7">
                <strong>N. Eleitor:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">{{$contato->funcionario->eleitor}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>Sessão de Eleitor:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-danger">{{$contato->funcionario->eleitor_sessao}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>Zona de Eleitor:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">{{$contato->funcionario->eleitor_zona}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>Data de Exp. de Eleitor:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">{{$contato->funcionario->eleitor_exp}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>N. do RG:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">{{$contato->funcionario->rg}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>Nome do Pai (no RG):</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">{{$contato->funcionario->rg_pai}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>Nome da Mãe (no RG):</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">{{$contato->funcionario->rg_mae}}</span>
              </div>
            </div>

          </div>
          <div class="col-md-4">
            <div class="row">
              <div class="col-md-7">
                <strong>N. do PIS:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">{{$contato->funcionario->pis}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>Banco do PIS:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">{{$contato->funcionario->pis_banco}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>N. do INSS:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">{{$contato->funcionario->inss}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>N. de reservista:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">{{$contato->funcionario->reservista}}</span>
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
                <span class="label label-info">R$ {{$contato->funcionario->sal}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>Salario real:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">R$ {{$contato->funcionario->sal_real}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>V. Transp.:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">R$ {{$contato->funcionario->vt}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>Percentual do VT:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">{{$contato->funcionario->vt_percentual}} %</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>V. Alim.:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">R$ {{$contato->funcionario->va}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>V. Refei.:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">R$ {{$contato->funcionario->vr}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>INSS:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">R$ {{$contato->funcionario->inss}}</span>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="row">
              <div class="col-md-7">
                <strong>Usuario:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">{{$contato->user->email}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>Senha:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-warning">***</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <strong>Estado:</strong>
              </div>
              <div class="col-md-5">
                <span class="label label-info">{{{$contato->user->ativo=="1" ? "Ativo" : "Inativo"}}}</span>
              </div>
            </div>
          </div>
        </div>
      @endif
      <hr>
      <div class="row">
        <div class="col-md-11 pull-right">
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
      <hr>
      <div class="row">
        <div class="col-md-12">
          {!! $contato->obs !!}
        </div>
      </div>
    </div>
    <div class="modal-footer">
      @botaoFecharModal
      @botaoEditarExtenso(novo/contatos*$contato->id)
    </div>
  </div>
</div>
