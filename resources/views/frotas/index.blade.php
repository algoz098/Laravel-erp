@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-car fa-1x"></i> Frotas
        </div>
        <div class="panel-body">
          <div id="secondNavbar" class="row">
              <div class="row">
                <div class="col-md-3 text-left" >
                  <div class=" form-inline col-md-10 text-right">
                    @ifPerms(frotas*edicao)
                      <a href="{{ url('lista/contas') }}/id/delete"  id="buttonDelete" title="Apagar" class="btn btn-danger">
                        <i class="fa fa-ban"></i>
                      </a>
                      <a class="btn btn-info"  id="buttonEdit" title="Editar" >
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a class="btn btn-info"  id="buttonAbastecer" title="Abastecer" href="">
                        <i class="fa fa-tint"></i>
                      </a>
                    @endPerms
                    <a class="btn btn-info"  id="buttonDetalhes" title="Detalhes">
                      <i class="fa fa-file-text-o"></i>
                    </a>
                  </div>
                  <div class=" form-inline col-md-2 text-left">
                    <input type="text" class="form-control" size="4" name="ids" id="ids" placeholder="Detalhes" disabled>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group form-inline text-center ajuda-popover"
                        title="Busca"
                        data-content="Digite para buscar um contato"
                        data-placement="top"
                  >
                    {{ csrf_field() }}
                    @buscaSimples(lista/frotas)
                    @buscaExtraBotao
                  </div>
                </div>
                  <div class="col-md-1 pull-right text-right ajuda-popover">
                    @ifPerms(frotas*adicao)
                      <a href="{{ url('/novo/frotas') }}" class="btn btn-success">
                        <i class="fa fa-plus fa-1x"></i>
                        Novo
                      </a>
                    @endPerms
                  </div>
              </div>
              <div id="buscaAvançada" class="row collapse " aria-expanded="" style="background-color: #fff; z-index:1030;">
                {placeholder}
              </div>
            </div>
          <div id="listaHolder"></div>
          @if($deletados!==0)
            <hr>
            <h3>Deletados</h3>
            @foreach($deletados as $key => $conta)
                <div class="row list-contacts">
                  <div class="col-md-2">
                    <a href="{{ url('lista/contas') }}/{{$conta->id}}/delete"  title="Restaurar" class="btn btn-danger">
                      <i class="fa fa-ban"></i>
                    </a>
                    <a href="{{ url('/contatos') }}/{{$conta->contatos->id}}"  title="Detalhes do contato" class="btn btn-info">
                      <i class="fa fa-user"></i>
                    </a>
                  </div>
                  <div class="col-md-3">
                    {{$conta->nome}}
                    <span class="label label-warning">R$ {{ number_format($conta->valor, 2) }}</label>
                  </div>
                  <div class="col-md-6">
                    @if ($conta->tipo==0)
                      <span class="label label-warning">Debito</span>
                    @elseif ($conta->tipo==1)
                      <span class="label label-warning">Credito</span>
                    @endif
                    @if ($conta->estado==0 AND $conta->tipo==0)
                      <span class="label label-danger">A pagar</span>
                    @elseif ($conta->estado==0 AND $conta->tipo==1)
                      <span class="label label-danger">A receber</span>
                    @elseif ($conta->estado==1 AND $conta->tipo==0)
                      <span class="label label-success">Pago</span>
                    @elseif ($conta->estado==1 AND $conta->tipo==1)
                      <span class="label label-success">Recebido</span>
                    @endif
                    @if (strtotime($conta->vencimento)>strtotime(Carbon::now()))
                      <span class="label label-warning">
                    @else
                      <span class="label label-danger">
                    @endif
                      {{date('d/m/Y', strtotime($conta->vencimento))}}
                    </span> -
                     {{$conta->descricao}}
                  </div>
                </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>
<script>
  $(document).ready(function(){
    efetuarBusca();
  });
  function selectRow(id){
    $("#ids").val(id);
    $("#buttonDelete").attr('href', '{{ url('lista/frotas') }}/'+id+'/delete/');
    $("#buttonEdit").attr('href', '{{ url('novo/frotas') }}/'+id+'/edit');
    $("#buttonDetalhes").attr('onclick', 'openModal("{{url('lista/frotas')}}/'+id+'")');
    $("#buttonAbastecer").attr('href', '{{url('lista/frotas')}}/'+id+'/abastecer');
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
