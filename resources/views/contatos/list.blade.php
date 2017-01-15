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
                <div class="col-md-3 text-left ajuda-popover"
                      title="Opções"
                      data-content="Deletar, editar/detalhes, telefones/emails, relacionamentos e anexos do contato"
                      data-placement="top" >
                  <div class=" form-inline col-md-10 text-right">
                    <a id="buttonDelete" href="{{ url('lista/contatos') }}/delete/" class="btn btn-danger btn_xs " data-toggle="tooltip" title="Deletar">
                      <i class="fa fa-ban" ></i>
                    </a>
                    <a id="buttonEdit" href="{{ url('novo/contatos') }}/" class="btn btn-primary btn_xs" data-toggle="tooltip" title="Detalhes">
                      <i class="fa fa-pencil"></i>
                    </a>
                    <a id="buttonDetalhes" class="btn btn-primary btn_xs"   data-toggle="modal" data-target="#detalhes">
                      </i><i class="fa fa-file-text"></i>
                    </a>
                    <span id="buttonRelate" class="btn btn-primary btn_xs" title="Relacionamentos"  data-toggle="collapse" data-target="#relacionamentos" aria-expanded="">
                      <i class="fa fa-users"></i>
                    </span>
                    <span id="buttonAttach" class="btn btn-warning btn_xs" title="Anexos"  data-toggle="collapse" data-target="#attachs" aria-expanded="">
                      <i class="fa fa-paperclip"></i>
                    </span>
                  </div>
                  <div class=" form-inline col-md-2 text-left">
                    <input type="text" class="form-control" size="4" name="ids" id="ids" placeholder="Detalhes" disabled>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group form-inline text-center ajuda-popover"
                        title="Busca"
                        data-content="Digite para buscar um contato"
                        data-placement="top"
                  >
                    {{ csrf_field() }}
                    <input type="text" class="form-control" name="busca" id="busca" placeholder="Busca">
                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Buscar</button>
                    <a class="btn btn-info"  title="Busca Avançada" data-toggle="collapse" data-target="#buscaAvançada" aria-expanded="" onclick="listaTop()">
                      <i class="fa fa-search-plus"></i>
                    </a>
                  </div>
                </div>
                  <div class="col-md-1 pull-right text-right ajuda-popover"
                        title="Novo"
                        data-content="Adicione um novo contato"
                        data-placement="left">
                    <a href="{{ url('/novo/contatos') }}" class="btn btn-success"><i class="fa fa-plus fa-1x">
                        </i> Novo</a>
                  </div>
              </div>
              <div id="buscaAvançada" class="row collapse " aria-expanded="" style="background-color: #fff; z-index:1030;">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="data_de">Busca por data <span class="label label-info">de</span></label>
                    <input type="text" class="form-control datepicker" name="data_de" id="data_de" placeholder="">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="data_ate">Busca por data <span class="label label-info">ate</span></label>
                    <input type="text" class="form-control datepicker" name="data_ate" id="data_ate" placeholder="">
                  </div>
                </div>
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
              <div class="sub-menu collapse " aria-expanded="" id="attachs{{$contato->id}}" style="padding-left: 100px; padding-top: 15px; padding-bottom: 30px;">
                <a class="btn btn-success" title="Anexos"  data-toggle="modal" data-target="#upload{{$contato->id}}">
                  Adicionar anexo
                </a><br>
                @foreach($contato->attachsToo as $key => $attach)
                  <div class="row list-contacts">
                    {{$attach->name}}
                    <span class="label label-info" data-toggle="modal" data-target="#attach{{$attach->id}}" onClick="loadImage({{$attach->id}})"  >Ver</span>
                    <a href="{{ url('/attach') }}/{{$attach->id}}/get"><span class="label label-info" >Salvar</span></a>
                    <a href="{{ url('/attach') }}/{{$attach->id}}/delete"><span class="label label-danger" >Apagar</span></a>
                  </div>
                  <div class="modal fade" id="attach{{$attach->id}}" tabindex="0" role="dialog" aria-labelledby="upload">
                    <div class="modal-dialog modal-lg extra" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="">Visualizar anexo</h4>
                        </div>
                        <div class="modal-body" id="modalBodyImage" >
                          <div class="row text-center" >
                            <div class="col-md-12 text-center" onClick="fullImage({{$attach->id}})" id="object-holder">
                              <object data="{{ url('attach/')}}/{{$attach->id}}" id="object{{$attach->id}}" width="100%" height="50" >
                              </object>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <div class="col-md-2 pull-right">
                            <div class="input-group">
                              <input type="text" class="form-control" value="" id="widthChanger{{$attach->id}}" placeholder="mudar a">
                              <span class="input-group-btn">
                                <button class="btn btn-warning" type="button" onclick="changeWidth({{$attach->id}})">Largura</button>
                              </span>
                            </div>
                          </div>
                          <button type="submit" class="btn btn-info" onclick="fullImage({{$attach->id}})"><i class="fa fa-search"></i> Alterar tamanho</button>
                          <button type="submit" class="btn btn-primary" onclick="rotateUnclock({{$attach->id}})"><i class="fa fa-arrow-left"></i> Rotacionar</button>
                          <button type="submit" class="btn btn-primary" onclick="rotateClock({{$attach->id}})"><i class="fa fa-arrow-right"></i> Rotacionar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            <!-- Modal detalhes -->
            <div class="modal fade" id="detalhes{{$contato->id}}" tabindex="-1" role="dialog" aria-labelledby="upload">
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
                        </span>
                      </div>
                    </div>
                    <div class="row">
                      @if ($contato->tipo=="0")
                      <div class="col-md-6">
                        Razão Social: {{$contato->nome}}
                      </div>
                      <div class="col-md-6">
                        Nome Fantasia: {{$contato->sobrenome}}
                      </div>
                      @else
                        <div class="col-md-8">
                          Nome: {{$contato->nome}}&nbsp{{$contato->sobrenome}}
                        </div>
                      @endif
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-6">
                        {{{$contato->tipo=="0" ? "CNPJ" : "CPF"}}}: {{$contato->cpf}}<br>
                        {{{$contato->tipo=="0" ? "I.E." : "RG"}}}: {{$contato->cnpj}}<br>
                        Cod. Pref.:{{$contato->cod_prefeitura}}
                      </div>
                      <div class="col-md-6">
                        {{$contato->endereco}}{{{$contato->andar!=""?", $contato->andar":""}}}{{{$contato->sala!=""?", $contato->sala":""}}}<br>
                        {{$contato->bairro}} - {{$contato->cidade}}, {{$contato->uf}}<br>
                        {{$contato->cep}}
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-6">
                        @foreach($contato->telefones as $key => $telefone)
                          <a href="{{ url('lista/contatos') }}/{{$contato->id}}/telefones/{{ $telefone->id }}/delete" class="btn btn-danger btn-xs"><i class="fa fa-ban"></i></a>
                          <span class="label label-info">{{ $telefone->tipo or "" }}</span> {{ $telefone->numero or "" }} <br>
                        @endforeach
                      </div>
                      <div class="col-md-6">
                        @foreach($contato->attachsToo as $key => $attach)
                          <div class="row">
                            {{$attach->name}}
                            <a href="{{ url('/attach') }}/{{$attach->id}}/get"><span class="label label-info" >Download</span></a>
                            <a href="{{ url('/attach') }}/{{$attach->id}}/delete"><span class="label label-danger" >Apagar</span></a>
                          </div>
                        @endforeach
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-11 pull-right">
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <a href="{{url('/novo/contatos/')}}/{{$contato->id}}" class="btn btn-primary"><i class="fa fa-pencil"></i> Editar</a>
                  </div>
                </div>
              </div>
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
                    <div class="form-group">
                      <label class="control-label">Escolha o arquivo</label>
                      <input type="file" name="file" id="fileToUpload" class="file">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Nome</label>
                      <input type="text" name="name" id="nome" class="form-control">
                    </div>
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
  @if (isset($contato->attachs))
    <script language="javascript">
    var imageStatus = false;
    var height = $(window).height()-200;
    function loadImage(id) {
      $('#object' + id).attr("data", "{{ url('/attach') }}/"+id+"/size/"+height);
      $('#object' + id).attr("height", height);
      var imageStatus = true;
    };
    function fullImage(id) {
      if (imageStatus=true) {
        $('#object' + id).attr("data", "{{ url('/attach') }}/"+id);
        imageStatus=false;
      } else {
        loadImage(id);
        imageStatus=true;
      }
    };
      function rotateClock(id) {
        $.get( "{{ url('/attach') }}/"+id+"/rotate/clock", function( data ) {
          $( ".result" ).html( data );
          $('#object' + id).attr("data", "{{ url('/attach') }}/"+id);
        });
      };
      function rotateUnclock(id) {
        $.get( "{{ url('/attach') }}/"+id+"/rotate/unclock", function( data ) {
          $( ".result" ).html( data );
          $('#object' + id).attr("data", "{{ url('/attach') }}/"+id);
        });
      };
      function changeWidth(id) {
        var width = $('#widthChanger' + id).val();
        $.get( "{{ url('/attach') }}/"+id+"/resize/"+width, function( data ) {
          $( ".result" ).html( data );
          $('#object' + id).attr("data", "{{ url('/attach') }}/"+id);
        });
      };
      function selectRow(id){
        $("#ids").val(id);
        $("#buttonDelete").attr('href', '{{ url('lista/contatos') }}/delete/'+id);
        $("#buttonEdit").attr('href', '{{ url('novo/contatos') }}/'+id);
        $("#buttonTel").attr('data-target', '#addTelefones'+id);
        $("#buttonRelate").attr('data-target', '#relacionamentos'+id);
        $("#buttonAttach").attr('data-target', '#attachs'+id);
        $("#buttonDetalhes").attr('data-target', '#detalhes'+id);
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
  @endif
@endsection
