@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-list fa-1x"></i> Lista de atendimentos realizados
        </div>
        <div class="panel-body">
          <form method="POST" action="{{ url('lista/atendimentos') }}/">
            <div id="secondNavbar" class="row">
              <div class="row">
                <div class="col-md-2 text-left ajuda-popover"
                      title="Opções"
                      data-content="Deletar, editar/detalhes, telefones/emails, relacionamentos e anexos do contato"
                      data-placement="top" >
                  <div class=" form-inline col-md-10 text-right">
                    <a href="{{ url('lista/atendimentos') }}/id/delete" id="buttonDelete" class="btn btn-danger btn_xs">
                      <i class="fa fa-ban"></i>
                    </a>
                    <a href="#" class="btn btn-primary btn_xs"  id="buttonDetalhes" title="Detalhes"  data-toggle="modal" data-target="#detalhes">
                      <i class="fa fa-file-text-o"></i>
                    </a>
                    <span class="btn btn-warning btn_xs" id="buttonAttach" title="Anexos"  data-toggle="collapse" data-target="#attachs" aria-expanded="">
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
                    <input type="text" class="form-control" name="busca" id="busca" placeholder="Busca por entidade">
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
                    <a href="{{ url('/novo/atendimentos') }}" class="btn btn-success">
                      <i class="fa fa-plus fa-1x"></i> Novo</a>
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
                    <label for="data_ate">Assunto</label>
                    <select class="form-control" id="assunto" name="assunto">
                      <option value="" selected> - Escolha a relação -</option>>
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
          <div class="row "  id="lista">
            <div class="col-md-1">
              IDs
            </div>
            <div class="col-md-2">
              Quem foi atendido
            </div>
            <div class="col-md-2">
              Assunto
            </div>
            <div class="col-md-5">
              Descrição
            </div>
            <div class="col-md-1 pull-right">
              Quando
            </div>
          </div>
          @if (!empty($atendimentos))
            @foreach($atendimentos as $key => $atendimento)
                <div class="row list-contacts" onclick="selectRow({{$atendimento->id}})">
                  <div class="col-md-1 text-left ajuda-popover" @if ($key==0) title="Criação e contato" data-content="Data do atendimento, e contato atendido." data-placement="bottom" @endif >
                    <span class="label label-info">
                      ID: {{$atendimento->id}}
                    </span>
                  </div>
                  <div class="col-md-2">
                    <a href="{{ url('novo/contatos') }}/{{$atendimento->contatos->id}}" class="label label-primary">
                      <i class="fa fa-user"></i> {{{ $atendimento->contatos->tipo!="1" ? str_limit($atendimento->contatos->nome, 15) : $atendimento->contatos->nome." ".str_limit($atendimento->contatos->sobrenome, 15) }}}
                    </a>
                  </div>
                  <div class="col-md-2 ajuda-popover" @if ($key==0) title="Detalhes" data-content="Assunto e descrição." data-placement="bottom" @endif >
                    {{$atendimento->assunto}}
                  </div>
                  <div class="col-md-5">
                    {{ str_limit(strip_tags($atendimento->texto), 60)}}
                  </div>
                  <div class="col-md-1 pull-right">
                    <span class="label label-info">
                      {{date('d/m/Y', strtotime($atendimento->created_at))}}
                    </span>
                  </div>
                </div>
                <div class="sub-menu collapse " aria-expanded="" id="attachs{{$atendimento->id}}" style="padding-left: 100px; padding-top: 15px; padding-bottom: 30px;">
                  <a class="btn btn-success" title="Anexos"  data-toggle="modal" data-target="#upload{{$atendimento->id}}">
                    Adicionar anexo
                  </a><br>
                  @foreach($atendimento->attachs as $key => $attach)
                    <div class="row list-contacts">
                      {{$attach->name}}
                      <span class="label label-info" data-toggle="modal" data-target="#attach{{$attach->id}}" onClick="loadImage({{$attach->id}})"  >Ver</span>
                      <a href="{{ url('/attach') }}/{{$attach->id}}/get"><span class="label label-info" >Salvar</span></a>
                      <a href="{{ url('/attach') }}/{{$attach->id}}/delete"><span class="label label-danger" >Apagar</span></a>
                    </div>
                    <div class="modal fade" id="attach{{$attach->id}}" tabindex="-1" role="dialog" aria-labelledby="upload">
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
                <!-- Modal -->
                <form action="{{ url('lista/atendimentos') }}/{{$atendimento->id}}/attach" method="post" enctype="multipart/form-data">

                <div class="modal fade" id="upload{{$atendimento->id}}" tabindex="-1" role="dialog" aria-labelledby="upload">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="addTelefonesLabel">Adicionar Anexo</h4>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                          {{ csrf_field() }}
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
                <!-- Modal detalhes-->
                <div class="modal fade" id="detalhes{{$atendimento->id}}" tabindex="-1" role="dialog" aria-labelledby="detalhesLabel">
                  <div class="modal-dialog  modal-lg extra" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="addTelefonesLabel">Detalhes atendimento: {{$atendimento->id}}</h4>
                      </div>
                      <div class="modal-body">
                        <div class="row text-center">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="assunto">Assunto</label>
                              <div>{{$atendimento->assunto}}</div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="contato">Contato</label>
                              <div>{{$atendimento->contatos->nome}}</div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="data">Data do atendimento</label>
                              <div>{{date('H:i d/m/Y', strtotime($atendimento->created_at))}}</div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="data">Descrição do atendimento</label>
                              <div>{!!$atendimento->texto!!}</div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <a href="{{ url('novo/atendimentos') }}/{{$atendimento->id}}"><button type="submit" class="btn btn-primary">Editar</button></a>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="detalhes{{$atendimento->id}}" tabindex="-1" role="dialog" aria-labelledby="detalhesLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="addTelefonesLabel">Detalhes atendimento: {{$atendimento->id}}</h4>
                      </div>
                      <div class="modal-body">
                        <div class="row text-center">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="assunto">Assunto</label>
                              <div>{{$atendimento->assunto}}</div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="contato">Contato</label>
                              <div>{{$atendimento->contatos->nome}} {{$atendimento->contatos->sobrenome}}</div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="data">Data do atendimento</label>
                              <div>{{date('H:i d/m/Y', strtotime($atendimento->created_at))}}</div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="data">Descrição do atendimento</label>
                              <div>{{$atendimento->texto}}</div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <a href="{{ url('novo/atendimentos') }}/{{$atendimento->id}}"><button type="submit" class="btn btn-primary">Editar</button></a>
                      </div>
                    </div>
                  </div>
                </div>
            @endforeach
            <div class="row">
              <div class="col-md-10 text-center">
                <span class="label label-primary">
                  Total de atendimentos: {{ $total }}
                </span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-10 text-center">
                {{ $atendimentos->links() }}
              </div>
            </div>
            <hr>
            @if ($deletados!='0')
              <h1> Deletados</h1>
              @foreach($deletados as $key => $atendimento)
                <div class="row list-contacts" onclick="selectRow({{$atendimento->id}})">
                  <div class="col-md-1 text-left ajuda-popover" @if ($key==0) title="Criação e contato" data-content="Data do atendimento, e contato atendido." data-placement="bottom" @endif >
                    <span class="label label-info">
                      ID: {{$atendimento->id}}
                    </span>
                  </div>
                  <div class="col-md-3">
                    <a href="{{ url('novo/contatos') }}/{{$atendimento->contatos->id}}" class="label label-primary">
                      <i class="fa fa-user"></i> {{ str_limit($atendimento->contatos->nome, 30)}}
                    </a>
                  </div>
                  <div class="col-md-2 ajuda-popover" @if ($key==0) title="Detalhes" data-content="Assunto e descrição." data-placement="bottom" @endif >
                    {{$atendimento->assunto}}
                  </div>
                  <div class="col-md-4">
                    {{ str_limit(strip_tags($atendimento->texto, 25))}}
                  </div>
                  <div class="col-md-1 pull-right">
                    <span class="label label-info">
                      {{date('d/m/Y', strtotime($atendimento->created_at))}}
                    </span>
                  </div>
                </div>
              @endforeach
            @endif
          </div>
        </div>
      </div>
    </div>

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
        $("#buttonDelete").attr('href', '{{ url('lista/atendimentos') }}/'+id+'/delete/');
        $("#buttonEdit").attr('href', '{{ url('novo/atendimentos') }}/'+id);
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
    <script language="javascript">
      $( function() {
        $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
      } );
    </script>
  @endif
@endsection
