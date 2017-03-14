@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-list fa-1x"></i> Lista de atendimentos realizados
        </div>
        <div class="panel-body">
          <div id="secondNavbar" class="row">
              <div class="row">
                <div class="col-md-2 text-left pull-left" >
                  <div class=" form-inline col-md-10 text-right">
                    @ifPerms(atendimentos*edicao)
                      @botaoDelete
                      @botaoEditar
                    @endPerms
                    @botaoDetalhes
                  </div>
                  <div class=" form-inline col-md-1 text-left">
                    @idSelecionado
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group form-inline text-center">
                    {{ csrf_field() }}
                    @buscaSimples(lista/atendimentos*Atendimentos)
                    @buscaExtraBotao
                  </div>
                </div>
                  <div class="col-md-1 pull-right text-right">
                    @ifPerms(atendimentos*adicao)
                      @botaoNovo(atendimentos)
                    @endPerms
                  </div>
              </div>
              <div id="buscaAvançada" class="row collapse " aria-expanded="" style="background-color: #fff; z-index:1030;">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="data_de">Busca por data <span class="label label-info">de</span></label>
                    <input type="text" class="form-control datepicker" name="data_de" id="data_de" value="">
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
          <div id="listaHolderAtendimentos"></div>
        </div>
      </div>
    </div>
    <script language="javascript">
    var imageStatus = false;
      function selectRow(id){
        window.id_attach_form = id;
        $("#ids").val(id);
        $("#botaoDelete").attr('href', '{{ url('lista/atendimentos') }}/'+id+'/delete/');
        $("#botaoDetalhes").attr('onclick', 'openModal("{{ url('lista/atendimentos') }}/'+id+'")');
        $("#botaoEditar").attr('href', '{{ url('novo/atendimentos') }}/'+id);
      }
      function listaTop(){
        var css = $('#listaHolder').css('margin-top');
        if(css == "75px"){
          $('#listaHolder').css('margin-top', '0px');
        } else {
          $('#listaHolder').css('margin-top', '75px');
        }
      }
    </script>
    <script language="javascript">
      $( function() {
        efetuarBusca('{{url('lista/atendimentos')}}', 'Atendimentos');
        $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
      } );
    </script>
@endsection
