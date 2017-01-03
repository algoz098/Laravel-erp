@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-list fa-1x"></i> Atendimentos
        </div>
        <div class="panel-body">
          <div class="row pull-right text-right">
            <div class="col-md-1 ajuda-popover"
                  title="Novo"
                  data-content="Adicione um novo atendimento"
                  data-placement="left">
              <a href="{{ url('/novo/atendimentos') }}" class="btn btn-success"><i class="fa fa-plus"></i> Novo</a>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12  ">
              <form method="POST" action="{{ url('lista/atendimentos') }}/">
                <div class="form-group form-inline text-center ajuda-popover"
                      title="Busca"
                      data-content="Digite para buscar um contato"
                      data-placement="top"
                >
                  {{ csrf_field() }}
                  <input type="text" class="form-control datepicker" name="data" id="data" placeholder="por Data">
                  <input type="text" class="form-control" name="busca" id="busca" placeholder="Busca">
                  <select class="form-control" id="contatos_id" name="contatos_id">
                    @if (!empty($atendimentos))
                      <option value="0" selected> - Contatos - </option>
                      @foreach($atendimentos as $key => $atendimento)
                        <option value="{{$atendimento->contatos->id}}">{{$atendimento->contatos->nome}}</option>
                      @endforeach
                    @endif
                  </select>
                  <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Buscar</button>
                </div>
              </form>
            </div>
          </div>
          @if (!empty($atendimentos))
            @foreach($atendimentos as $key => $atendimento)
                <div class="row list-contacts">
                  <div class="col-md-2 text-left ajuda-popover"
                    @if ($key==0)
                        title="Opções"
                        data-content="Deletar, detalhes e anexos."
                        data-placement="top"
                      @endif
                  >
                    <a href="{{ url('lista/atendimentos') }}/{{$atendimento->id}}/delete" class="btn btn-danger btn_xs">
                      <i class="fa fa-ban"></i>
                    </a>
                    <a href="#" class="btn btn-primary btn_xs" title="Detalhes"  data-toggle="modal" data-target="#detalhes{{$atendimento->id}}">
                      <i class="fa fa-file-text-o"></i>
                    </a>
                    <span class="btn btn-warning btn_xs" title="Anexos"  data-toggle="collapse" data-target="#attachs{{$atendimento->id}}" aria-expanded="">
                      <i class="fa fa-paperclip"></i>
                    </span>
                  </div>
                  <div class="col-md-2 text-left ajuda-popover"
                      @if ($key==0)
                        title="Criação e contato"
                        data-content="Data do atendimento, e contato atendido."
                        data-placement="bottom"
                      @endif
                  >
                    <span class="label label-info">
                      {{date('d/m/Y', strtotime($atendimento->created_at))}}
                    </span>&nbsp
                    <a href="{{ url('novo/contatos') }}/{{$atendimento->contatos->id}}" class="label label-primary"><i class="fa fa-user"></i> {{$atendimento->contatos->nome}}</a>
                  </div>
                  <div class="col-md-8 ajuda-popover"
                      @if ($key==0)
                        title="Detalhes"
                        data-content="Assunto e descrição."
                        data-placement="bottom"
                      @endif
                  >
                    {{$atendimento->assunto}} -
                    {{ str_limit(strip_tags($atendimento->texto, 35))}}
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
                  {{ csrf_field() }}
                <div class="modal fade" id="upload{{$atendimento->id}}" tabindex="-1" role="dialog" aria-labelledby="upload">
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
                {{ $atendimentos->links() }}
              </div>
            </div>
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
    </script>
    <script language="javascript">
      $( function() {
        $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
      } );
    </script>
  @endif
@endsection
