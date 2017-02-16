@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-car fa-1x"></i> Frotas
        </div>
        <div class="panel-body">
          <form method="POST" action="{{ url('/lista/contas') }}/">
            <div id="secondNavbar" class="row">
              <div class="row">
                <div class="col-md-2 text-left" >
                  <div class=" form-inline col-md-3 text-right">
                    <a class="btn btn-info"  id="buttonEdit" title="Detalhes"  >
                      <i class="fa fa-gear"></i>
                    </a>

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
                    </a>
                  </div>
                </div>
                <div class="col-md-3 pull-right text-right">
                  <a href="{{url('lista/frotas')}}" class="btn btn-warning">
                    <i class="fa fa-car"></i>
                    Voltar a lista
                  </a>
                </div>
              </div>
            </div>
          </form>

          @foreach($contatos as $key => $contato)
            <div class="row list-contacts" onclick="selectRow({{$contato->id}})">
              <div class="col-md-1" >
                <span class="label label-info">
                  ID: {{$contato->id}}
                </span>
              </div>
              <div class="col-md-1" >
                <a class="label label-primary" class="label label-info" onclick="openModal('{{url('lista/contatos/')}}/{{$contato->id}}')">
                  <i class="fa fa-user"></i>
                  {{$contato->nome}}
                </a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>
<script>
  function selectRow(id){
    $("#ids").val(id);
    $("#buttonEdit").attr('href', '{{ url('novo/frotas') }}/'+id);
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
