@extends('main')
@section('content')
  <form method="POST" action="{{ url('/lista/estoque') }}/">
    {{ csrf_field() }}
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading ">
            <i class="fa fa-bell-o fa-1x"></i> Estoque
          </div>
          <div class="panel-body">
            <div class="row" id="secondNavbar">
              <div class="col-md-2 pull-right text-right">
                @ifPerms(estoques*adicao)
                  @botaoNovo(estoque*produto*Estoque*Produto)
                @endPerms
              </div>
              <div class="col-md-3">
                <div class="row">
                  <div class="col-md-6 text-right">
                    @ifPerms(estoques*edicao)
                      @botaoDelete
                      @botaoEditar
                    @endPerms
                    @botaoDetalhes
                  </div>
                  <div class="col-md-3 text-left">
                    @idSelecionado
                  </div>
                </div>
              </div>
              <div class="col-md-7">
                <div class="form-group form-inline text-center">
                  @buscaSimples
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-1">
                ID:
              </div>
              <div class="col-md-2">
                Descricao
              </div>
              <div class="col-md-1">
                Valor
              </div>
              <div class="col-md-2">
                Qtd.
              </div>
              <div class="col-md-4">
                Esta em:
              </div>
            </div>
            @if ($estoques!==0)
              @foreach($estoques as $key => $estoque)
                <div class="row list-contacts" onclick="selectRow({{$estoque->id}})">
                  <div class="col-md-1">
                    <span class="label label-info">ID: {{$estoque->id}} </span>
                  </div>
                  <div class="col-md-2">
                    {{$estoque->produto->nome}}
                  </div>
                  <div class="col-md-1">
                    <span class="label label-warning">R$ {{ number_format($estoque->valor_custo, 2) }}</span>
                  </div>
                  <div class="col-md-2">
                    <span class="label label-info">{{$estoque->quantidade}} {{$estoque->unidade}}</span>
                  </div>
                  <div class="col-md-6" >
                    @mostraContato($estoque->contato->id*str_limit($estoque->contato->nome, 55))
                  </div>
                </div>
              @endforeach
              <hr>
              <div class="row">
                <div class="col-md-10 text-center">
                  <span class="label label-primary">
                    Total de produtos: {{ $total }}
                  </span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 text-center">
                  {{ $estoques->links() }}
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </form>
  <script>
    var imageStatus = false;
    function selectRow(id){
      window.id_attach_form = id;
      $("#ids").val(id);
      $("#botaoDelete").attr('href', '{{ url('lista/estoque') }}/'+id+'/delete/');
      $("#botaoDetalhes").attr('onclick', 'openModal("{{ url('lista/estoque') }}/'+id+'")');
      $("#botaoEditar").attr('href', '{{ url('novo/estoque') }}/'+id);
    }
  </script>
@endsection
