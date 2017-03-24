@extends('main')
@section('content')
    <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-users fa-1x"></i> Lista de entidades
        </div>
        <div class="panel-body">
          <div id="secondNavbar" class="row">
            <div class="col-md-3 col-xs-12 text-left pull-left">
              <div class="row">
                <div class=" form-inline col-md-10 col-xs-8 text-right">
                  @ifPerms(contatos*edicao)
                  @botaoDelete
                  @botaoEditar
                  @endPerms
                  @botaoDetalhes
                  <span id="buttonRelate" class="btn btn-primary hidden-xs" title="Relacionamentos"  data-toggle="collapse" data-target="#relacionamentos" aria-expanded="">
                    <i class="fa fa-users"></i>
                  </span>
                  @botaoAnexos
                </div>
                <div class=" form-inline col-md-2 col-xs-2 text-left">
                  @idSelecionado
                </div>
                <div class="col-xs-2 hidden-md">
                  <a class="btn btn-warning" role="button" data-toggle="collapse" href=".collapse-mobile">
                    <i class="fa fa-search"></i>
                  </a>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xs-12 collapse-mobile" data-toggle="collapse">
              <div class="form-group form-inline text-center ">
                {{ csrf_field() }}
                @buscaSimples(lista/contatos*Contatos)
                <div class="hidden-xs">
                  @buscaExtraBotao
                </div>
              </div>
            </div>
            <div class="col-md-2 col-xs-12 pull-right collapse-mobile" data-toggle="collapse">
              @ifPerms(contatos*adicao  )
              @botaoNovo(contatos*funcionarios*Nova Entidade*Novo Func.)
              @endPerms
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
          <span id="listaHolderContatos"></span>
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
    $(document).ready(function(){
      efetuarBusca('{{url('lista/contatos')}}', 'Contatos');
      $('#busca').focus();
    });
    $(document).keypress(function(e) {
        if(e.which == 13) {
          efetuarBusca();
        }
    });

    function selectRow(id){
      window.id_attach_form = id;
      $("#ids").val(id);
      $("#botaoEditar").attr('href', '{{ url('novo/contatos') }}/'+id);
      $("#buttonRelate").attr('data-target', '#relacionamentos'+id);
      $("#botaoAnexos").attr('onclick', "openModal('{{url('lista/contatos')}}/"+id+"/attachs')");
      $("#botaoDetalhes").attr('onclick', "openModal('{{url('lista/contatos')}}/"+id+"')");
      $("#botaoDelete").attr('href', '{{ url('lista/contatos') }}/delete/'+id);
      if (id=="1") {
        $("#botaoDelete").attr('disabled', true);

      }
    }
    function listaTop(){
      var css = $('#listaHolderContatos').css('margin-top');
      if(css == "75px"){
        $('#listaHolderContatos').css('margin-top', '0px');
      } else {
        $('#listaHolderContatos').css('margin-top', '75px');
      }
    }
  </script>
@endsection
