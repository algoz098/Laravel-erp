@extends('main')
@section('content')
    <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-users fa-1x"></i> Lista de entidades
        </div>
        <div class="panel-body">
          <form method="POST" action="{{ url('lista/contatos') }}/">
            <div id="secondNavbar" class="row">
              <div class="row">
                <div class="col-md-3 text-left pull-left">
                  <div class=" form-inline col-md-9 text-right">
                    @botaoDelete
                    @botaoEditar
                    @botaoDetalhes
                    <span id="buttonRelate" class="btn btn-primary btn_xs" title="Relacionamentos"  data-toggle="collapse" data-target="#relacionamentos" aria-expanded="">
                      <i class="fa fa-users"></i>
                    </span>
                    @botaoAnexos
                  </div>
                  <div class=" form-inline col-md-2 text-left">
                    @idSelecionado
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group form-inline text-center">
                    {{ csrf_field() }}
                    @buscaSimples
                    @buscaExtraBotao
                  </div>
                </div>
                  <div class="col-md-2 pull-right ">
                    @botaoNovo(contatos*funcionarios*Nova Entidade*Novo Func.)

                  </div>
              </div>
              <div id="buscaAvançada" class="row collapse " aria-expanded="" style="background-color: #fff; z-index:1030;">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="data_de">Criado <span class="label label-info">de</span></label>
                    <input type="text" class="form-control datepicker" name="data_de" id="data_de" placeholder="">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="data_ate">Criado <span class="label label-info">ate</span></label>
                    <input type="text" class="form-control datepicker" name="data_ate" id="data_ate" placeholder="">
                  </div>
                </div>
                <!--
                Conferir esta busca, é necessario regulaziar este tipo de relacionamento. Ainda sem uso.
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="data_ate">Relação com a Matriz</label>
                    <select class="form-control" id="relacao" name="relacao">
                      <option selected> - Escolha a relação -</option>>
                      <option value="Filial">Filial</option>
                      <option value="Cliente">Cliente</option>
                      <option value="Fornecedor">Fornecedor</option>
                      @foreach($comboboxes as $key => $combo)
                        <option value="{{$combo->text}}">{{$combo->text}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                -->
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
          @foreach($contatos as $key => $contato)
              <div class="row list-contacts" onclick="selectRow({{$contato->id}})">
                <div class="col-md-1">
                  <span class="label label-primary">
                    {{{$contato->id}}}
                  </span>
                </div>
                <div class="col-md-1">
                  @if(is_null($contato->active))
                    <i class="fa fa-user level1"></i>
                  @else
                    <i class="fa fa-user level{{$contato->active}}"></i>
                  @endif
                  <i class="fa fa-signal level{{$contato->sociabilidade}}"></i>
                </div>
                <div class="col-md-4 ajuda-popover"
                    @if ($key==0)
                      title="Sociabilidade"
                      data-content="
                                    <i class='fa fa-user level1'></i> = Informações de Contato defasadas<br><i class='fa fa-user level4'></i> = Informações de Contato confiaveis<br>
                                    Facilidade de interação: <i class='fa fa-signal level1'></i> <i class='fa fa-signal level2'></i> <i class='fa fa-signal level3'></i> <i class='fa fa-signal level4'></i> <i class='fa fa-signal level5'></i> <br>
                                    E nome ou razão social do contato.
                      "
                      data-placement="bottom"
                      data-html="true"
                    @endif
                  >
                  {{ $contato->nome }}
                  @if ($contato->tipo=="1"){{ $contato->sobrenome }}@endif
                </div>
                <div class="col-md-3">
                   @if ($contato->tipo!="1"){{ $contato->sobrenome }}@endif
                </div>
                <div class="col-md-2">
                  @if ($contato->id=="1")<span class="label label-danger">Matriz</span>
                  @else
                    @foreach($contato->from as $key => $from)
                      @if ($from->id=="1")
                        <span class="label label-warning">{{$from->pivot->from_text}}</span>
                      @else
                        <span class="label label-default">N/C</span>
                      @endif
                    @endforeach
                  @endif
                  @if ($contato->from=="[]" and $contato->id!=1)
                    <span class="label label-default">N/C</span>
                  @endif
                </div>
                <div class="col-md-1 pull-right ajuda-popover"
                    @if ($key==0)
                      title="Outras informações"
                      data-content="
                                    Informações extras: relação para com a matriz, telefones, endereço, data de cadastro.
                      "
                      data-placement="bottom"
                    @endif
                  >

                  <span class="label label-primary">{{date('d/m/Y', strtotime($contato->created_at))}}</label>
                </div>
              </div>
              <div class="sub-menu collapse " aria-expanded="" id="relacionamentos{{$contato->id}}" style="padding-left: 100px; padding-top: 15px; padding-bottom: 30px;">
                <a href="{{ url('lista/contatos') }}/{{$contato->id}}/relacoes" class="btn btn-warning" title="Relacionamentos">
                  Editar relações
                </a><br>
                @foreach($contato->from as $key => $from)
                  <div class="row list-contacts">
                    {{$from->nome}} <span class="label label-info">{{$from->pivot->to_text}}</span>
                  </div>
                @endforeach
                @foreach($contato->to as $key => $to)
                  <div class="row list-contacts">
                    {{$to->nome}} <span class="label label-info">{{$to->pivot->from_text}}</span>
                  </div>
                @endforeach
              </div>
            <!-- Modal -->
            <form action="{{ url('lista/contatos') }}/{{$contato->id}}/attach" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
            <div class="modal fade" id="upload{{$contato->id}}" tabindex="-1" role="dialog" aria-labelledby="upload">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addTelefonesLabel">Adicionar Anexo</h4>
                  </div>
                  <div class="modal-body">

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Novo</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
          @endforeach
          <div class="row">
            <div class="col-md-10 text-center">
              <span class="label label-primary">
                PJ: {{$empresas}}
              </span>&nbsp
              <span class="label label-primary">
                PF: {{$pessoas}}
              </span>&nbsp
              <span class="label label-primary">
                Total: {{$total}}
              </span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10 text-center">
              {{ $contatos->links() }}
            </div>
          </div>
          @if($deletados!==0)
            <h3>Deletados</h3>
            @foreach($deletados as $key => $contato)
                <div class="row list-contacts">
                  <div class="col-md-2">
                    <a href="{{ url('lista/contatos') }}/delete/{{$contato->id}}" class="btn btn-success btn_xs" data-toggle="tooltip" title="Restaurar">
                      <i class="fa fa-check" ></i>
                    </a>
                    {{$contato->id}}
                  </div>
                  <div class="col-md-4">
                    <span class="label label-danger">DELETADO</span>
                    <i class="fa fa-signal level{{$contato->sociabilidade}}"></i>
                    {{ str_limit($contato->nome, 10) }} {{ str_limit($contato->sobrenome, 3) }}
                  </div>
                  <div class="col-md-5">
                    @foreach($contato->from as $key => $from)
                      @if ($from->pivot->to_id==1)
                        <span class="label label-warning">{{$from->pivot->from_text}}</span>
                      @endif
                    @endforeach
                    @foreach($contato->telefones as $key => $telefone)
                      <span class=""><span class="badge">{{$telefone->tipo}}</span> {{$telefone->numero}}</span>
                    @endforeach
                    {{$contato->endereco}} - {{$contato->bairro}} - {{$contato->cidade}} - {{$contato->uf}} -
                    <span class="label label-primary">{{date('d/m/Y', strtotime($contato->created_at))}}</label>
                  </div>
                </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>

  <script language="javascript">
    function selectRow(id){
      window.id_attach_form = id;
      $("#ids").val(id);
      $("#botaoDelete").attr('href', '{{ url('lista/contatos') }}/delete/'+id);
      $("#botaoEditar").attr('href', '{{ url('novo/contatos') }}/'+id);
      $("#buttonRelate").attr('data-target', '#relacionamentos'+id);
      $("#botaoAnexos").attr('onclick', "openModal('{{url('lista/contatos')}}/"+id+"/attachs')");
      $("#botaoDetalhes").attr('onclick', "openModal('{{url('lista/contatos')}}/"+id+"')");
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
