@extends('main')
@section('content')
    <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-users fa-1x"></i> Lista de contatos
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-2 pull-right text-right">
              <a href="{{ url('/novo/contatos') }}" class="btn btn-success"><i class="fa fa-plus fa-1x"></i> Novo</a>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12  ">
              <form method="POST" action="{{ url('lista/contatos') }}/">
                <div class="form-group form-inline text-center">
                  {{ csrf_field() }}
                  <input type="text" class="form-control" name="busca" id="busca" placeholder="Busca">
                  <button type="submit" class="btn btn-success">Buscar</button>
                </div>
              </form>
            </div>
          </div>
          @foreach($contatos as $key => $contato)
              <div class="row list-contacts">
                <div class="col-md-3">
                  @if ($contato->id=='1')
                    <a class="btn btn-danger btn_xs disabled" data-toggle="tooltip" title="Matriz, Nao apague">
                  @else
                    <a href="{{ url('lista/contatos') }}/delete/{{$contato->id}}" class="btn btn-danger btn_xs " data-toggle="tooltip" title="Deletar">
                  @endif
                    <i class="fa fa-ban" ></i>
                  </a>
                  <a href="{{ url('novo/contatos') }}/{{$contato->id}}" class="btn btn-primary btn_xs" data-toggle="tooltip" title="Detalhes">
                    <i class="fa fa-file-text"></i>
                  </a>
                  <a class="btn btn-primary btn_xs" title="Adicionar Telefone"  data-toggle="modal" data-target="#addTelefones{{$contato->id}}">
                    <i class="fa fa-phone"></i>
                  </a>
                  <span class="btn btn-primary btn_xs" title="Relacionamentos"  data-toggle="collapse" data-target="#relacionamentos{{$contato->id}}" aria-expanded="">
                    <i class="fa fa-users"></i>
                  </span>
                  <span class="btn btn-warning btn_xs" title="Anexos"  data-toggle="collapse" data-target="#attachs{{$contato->id}}" aria-expanded="">
                    <i class="fa fa-paperclip"></i>
                  </span>
                  {{$contato->id}}
                </div>
                <div class="col-md-3">
                  @if(is_null($contato->active))
                    <i class="fa fa-user level1"></i>
                  @else
                    <i class="fa fa-user level{{$contato->active}}"></i>
                  @endif
                  <i class="fa fa-signal level{{$contato->sociabilidade}}"></i>
                  {{ str_limit($contato->nome, 10) }} {{ str_limit($contato->sobrenome, 3) }}
                </div>
                <div class="col-md-6">
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
                @foreach($contato->attachs as $key => $attach)
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
            <div class="modal fade" id="addTelefones{{$contato->id}}" tabindex="-1" role="dialog" aria-labelledby="addTelefonesLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addTelefonesLabel">Adicionar Telefone</h4>
                  </div>
                  <div class="modal-body">
                      @foreach($contato->telefones as $key => $telefone)
                          <a href="{{ url('lista/contatos') }}/{{$contato->id}}/telefones/{{ $telefone->id }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                          <a href="{{ url('lista/contatos') }}/{{$contato->id}}/telefones/{{ $telefone->id }}/delete" class="btn btn-danger btn-xs"><i class="fa fa-ban"></i></a>
                          {{ $telefone->tipo or "" }} {{ $telefone->numero or "" }} <br>
                      @endforeach
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a href="{{ url('lista/contatos') }}/{{$contato->id}}/telefones"><button type="submit" class="btn btn-primary">Novo</button></a>
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
  </script>
  @endif
@endsection
