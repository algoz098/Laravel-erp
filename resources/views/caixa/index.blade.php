<?php
use Carbon\Carbon;
?>
@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-money fa-1x"></i> Movimentações e Caixa
        </div>
        <div class="panel-body">
          <form method="POST" action="{{ url('/lista/caixa') }}/">
            <div id="secondNavbar" class="row">
              <div class="row">
                <div class="col-md-3 text-left ajuda-popover"
                      title="Opções"
                      data-content="Deletar, editar/detalhes, telefones/emails, relacionamentos e anexos do contato"
                      data-placement="top" >
                  <div class=" form-inline col-md-6 text-right">
                    <a disabled id="buttonDelete" href="" class="btn btn-danger btn_xs " data-toggle="tooltip" title="Deletar">
                      <i class="fa fa-ban" ></i>
                    </a>
                    <a href="" id="buttonClose" class="btn btn-info">
                      <i class="fa fa-check"></i>
                    </a>
                    <a href="" id="buttonAdd" class="btn btn-success">
                      <i class="fa fa-plus"></i>
                    </a>
                  </div>
                  <div class=" form-inline col-md-4 text-left">
                    <input type="text" class="form-control" size="4" name="ids" id="ids" placeholder="Detalhes" disabled>
                  </div>
                </div>
                <div class="col-md-3">
                  @if($caixa_atual)
                    <span class="label label-primary">Filial: {{$caixa_atual->filial->nome}}</span>&nbsp
                    <span class="label label-primary">Caixa: {{$caixa_atual->id}}</span>&nbsp
                    <span class="label label-primary">
                      Hoje:
                      @if ($caixa_atual->estado=="0") Aberto
                      @elseif ($caixa_atual->estado=="1") Fechado
                      @endif
                    </span>&nbsp
                    <span class="label label-primary">Atualmente: R$&nbsp{{ number_format($atual, 2) }}</span>&nbsp
                  @else
                    <span class="label label-danger">Abra seu caixa para começar</span>
                  @endif
                </div>
                <div class="col-md-3">
                  <div class="form-group form-inline text-center ajuda-popover"
                        title="Busca"
                        data-content="Digite para buscar um contato"
                        data-placement="top"
                  >
                    {{ csrf_field() }}
                    <select class="form-control" id="filial" name="filial">
                      <option value="" selected>- Caixa da filial -</option>
                      <option value="1">Matriz</option>
                      @foreach($filiais as $key => $filial)
                        <option value="{{$filial->id}}">{{$filial->nome}}</option>
                      @endforeach
                    </select>
                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Buscar</button>
                    <a class="btn btn-info"  title="Busca Avançada" data-toggle="collapse" data-target="#buscaAvançada" aria-expanded="" onclick="listaTop()">
                      <i class="fa fa-search-plus"></i>
                    </a>
                  </div>
                </div>
                  <div class="col-md-1 pull-right ajuda-popover"
                        title="Novo"
                        data-content="Adicione um novo contato"
                        data-placement="left">
                        <a href="{{url('/novo/caixa')}}" id="buttonNovo" class="btn btn-success ajuda-popover" >
                          <i class="fa fa-plus"></i> Abrir
                        </a>
                  </div>
              </div>
              <div id="buscaAvançada" class="row collapse " aria-expanded="" style="background-color: #fff; z-index:1030;">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="data_de">Caixa da data: </label>
                    <input type="text" class="form-control datepicker" name="data" id="data" value="{{Carbon::today()}}">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="data_ate">Descrição</label>
                    <select class="form-control" id="descricao" name="descricao">
                      <option value="" selected>- Escolha -</option>
                      @foreach($comboboxes as $key => $combo)
                        <option value="{{$combo->text}}">{{$combo->text}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="data_ate">Estado</label>
                    <select class="form-control" id="estado" name="estado">
                      <option value="" selected>- Escolha -</option>
                      <option value="0">Caixas aberto</option>
                      <option value="1" selected>Caixas fechados</option>
                    </select>
                  </div>
                </div>
                @if (isset(Auth::user()->perms["admin"]) and Auth::user()->perms["admin"]==1)
                  <div class="col-md-2 pull-right">
                    <input type="checkbox"name="deletados" id="deletados"   >
                    <span id="deletadosText">buscar com deletados</span>
                  </div>
                @endif
              </div>
            </div>
          </form>
          <div class="row list-contacts" id="lista">
            <div class="col-md-1">
              IDs
            </div>
            <div class="col-md-1">
              Social
            </div>
            <div class="col-md-4">
              Razão Social
            </div>
            <div class="col-md-3">
              Nome Fantasia
            </div>
            <div class="col-md-2">
              Relação
            </div>
            <div class="col-md-1 pull-right">
              Detalhes
            </div>
          </div>


          @foreach($caixas as $key => $caixa)
            <div class="row list-contacts"onclick="selectRowConta({{$caixa->id}})">
              <div class="col-md-1">
                <span class="label label-info">
                  {{$caixa->id}}
                </span>
              </div>
              <div class="col-md-1 ajuda-popover">
                <span class="label label-success">Abertura</span>
              </div>
              <div class="col-md-2 ajuda-popover" >
                <span class="label label-warning">R$ {{ number_format($caixa->valor, 2) }}</span>
              </div>
              <div class="col-md-1">
                @if ($caixa->estado==0)
                  <span class="label label-danger">
                    Aberto
                  </span>
                @else
                  <span class="label label-success">
                    Fechado
                  </span>
                @endif
              </div>
              <div class="col-md-2">
              </div>

              <div class="col-md-3 ajuda-popover">
                <a href="{{ url('/contatos') }}/{{$caixa->filial->id}}" class="label label-success">
                  <i class="fa fa-user"></i> {{$caixa->filial->nome}}
                </a>
              </div>
              <div class="col-md-2 pull-right text-right ">
                <span class="label label-primary">{{$caixa->created_at}}</span>
              </div>

            </div>
            @foreach($caixa->movs as $key => $mov)
              <div class="row list-contacts" onclick="selectRowMov({{$caixa->id}}, {{$mov->id}})">
                <div class="col-md-1">
                  <span class="label label-info">
                    {{$caixa->id}}.{{$mov->id}}
                  </span>
                </div>
                <div class="col-md-1">
                  <span class="label label-info">Movimentação</span>
                </div>
                <div class="col-md-1">
                  <span class="label label-warning">R$ {{ number_format($mov->valor, 2) }}</span>
                </div>
                <div class="col-md-1">
                  @if ($mov->tipo=="1")
                    <span class="label label-danger">Saida</span>
                  @elseif ($mov->tipo=="0")
                    <span class="label label-success">Entrada</span>
                  @endif
                </div>
                <div class="col-md-1">
                  @if ($mov->estado=="1")
                    <span class="label label-success">ok</span>
                  @elseif ($mov->estado=="0")
                    <span class="label label-danger">Pendente</span>
                  @endif
                </div>
                <div class="col-md-2">
                  <span class="label label-warning">
                    {{$mov->nome}}
                  </span>
                </div>
                <div class="col-md-3">
                  <a href="{{ url('/contatos') }}/{{$caixa->filial->id}}" class="label label-success">
                    <i class="fa fa-user"></i> {{$caixa->filial->nome}}
                  </a>
                </div>
                <div class="col-md-2 pull-right text-right ">
                  <span class="label label-primary">{{$mov->created_at}}</span>
                </div>

              </div>
            @endforeach
          @endforeach
          @if ($caixa_atual)

          @endif
          @if($deletados!==0)
            <h3>Deletados</h3>
            @foreach($deletados as $key => $caixa_atual)
              <div class="row list-contacts">
                <div class="col-md-1">
                  <a href="{{ url('lista/caixa') }}/{{$caixa_atual->id}}/delete"  title="Restaurar" class="btn btn-success">
                    <i class="fa fa-check"></i>
                  </a>
                </div>
                <div class="col-md-3">
                  @if ($caixa_atual->tipo==0)
                    <span class="label label-info">Abertura</span>
                  @elseif ($caixa_atual->tipo==1)
                    <span class="label label-info">Fechamento</span>
                  @elseif ($caixa_atual->tipo==2)
                    <span class="label label-primary">Movimentação</span>
                  @endif
                  </span>
                  <span class="label label-warning">R$ {{ number_format($caixa_atual->valor, 2) }}</span>

                  @if ($caixa_atual->forma=="0")
                    <span class="label label-success">Credito</span>
                  @elseif ($caixa_atual->forma=="1")
                    <span class="label label-danger">Debito</span>
                  @endif
                  </span>
                </div>
                <div class="col-md-6">
                  <a href="{{ url('/contatos') }}/{{$caixa_atual->contato->id}}" class="label label-success">
                    <i class="fa fa-user"></i> {{$caixa_atual->contato->nome}}
                  </a>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>
  <script>
    $( function() {
      $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
    } );

    function selectRowConta(id){
      $("#ids").val(id);
      $("#buttonDelete").attr('href', '{{ url('lista/caixa') }}/'+id+'/delete');
      $("#buttonDelete").removeAttr("disabled");
      $("#buttonClose").attr('href', '{{ url('/lista/caixa/') }}/fechar/'+id);
      $("#buttonAdd").attr('href', '{{ url('/novo/caixa/') }}/'+id+'');
    }
    function selectRowMov(id, mov_id){
      $("#ids").val(id+'.'+mov_id);
      $("#buttonDelete").attr('href', '{{ url('lista/caixa/mov') }}/'+id+'/delete');
      $("#buttonDelete").removeAttr("disabled");
      $("#buttonClose").attr('href', '{{ url('/lista/caixa/') }}/fechar/'+id);
      $("#buttonAdd").attr('href', '{{ url('/novo/caixa/') }}/'+id+'/');
    }

    function listaTop(){
      var css = $('#lista').css('margin-top');
      if(css == "75px"){
        $('#lista').css('margin-top', '0px');
      } else {
        $('#lista').css('margin-top', '75px');
      }
    }
  </script>
@endsection
