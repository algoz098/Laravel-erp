@extends('main')
@section('content')
  @if (isset($produto))
    <form method="POST" action="{{ url('/novo/produto') }}/{{$produto->id}}">
  @else
    <form method="POST" action="{{ url('/novo/produto') }}">
  @endif
    {{ csrf_field() }}
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading ">
            <i class="fa fa-bell-o fa-1x"></i> Criar novo produto ao estoque
          </div>
          <div class="panel-body">
            <div class="row" id="secondNavbar">
              <div class="col-md-3 text-right pull-right">
                @botaoLista(estoque*fa-bell-o)
                @botaoSalvar
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="form-group">
                      <label for="barras">Codigo de barras</label>
                      <div class="input-group">
                        @if(isset($produto))
                          <input type="text" class="form-control" id="barras" name="barras" value="{{$produto->barras}}">
                        @else
                          <input type="text" class="form-control" id="barras" name="barras">
                        @endif
                         <span class="input-group-btn">
                           <button class="btn btn-info" type="button" onclick="gerarBarras()"><i class="fa fa-gear"></i></button>
                         </span>
                       </div>
                     </div>
                     @if(isset($produto))
                        @campoTexto(Produto do grupo*grupo*$produto->grupo)
                        @campoTexto(Tipo do produto*tipo*$produto->tipo)
                    @else
                      @campoTexto(Produto do grupo*grupo*)
                      @campoTexto(Tipo do produto*tipo*)
                    @endif
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      @if(isset($produto))
                        @campoTexto(Nome do Produto*nome*$produto->nome)
                      @else
                        @campoTexto(Nome do Produto*nome*)
                      @endif
                      <div class="form-group">
                        <label for="unidade">Unidade de medida:</label>
                        <select class="form-control" id="unidade" name="unidade">
                          @if(isset($produto))
                            <option value="{{$produto->unidade}}" selected>{{$produto->unidade}} (atual)</option>
                          @else
                            <option selected>- Escolha -</option>
                          @endif
                          <option value="Pç">Peça</option>
                          <option value="Un">Unidade</option>
                          <option value="Kg">Kilograma</option>
                          <option value="Lts">Litro</option>
                        </select>
                      </div>
                      @if(isset($produto))
                        @campoDinheiro(Valor de custo*custo*$produto->custo)
                      @else
                        @campoDinheiro(Valor de custo*custo*)
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title">Campos extras</h3>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-2 pull-right text-right">
                          <div class="panel panel-default">
                            <div class="panel-body">
                              <a class="btn btn-danger" onclick="remove()">
                                <i class="fa fa-minus"></i>
                              </a>
                              <a class="btn btn-success" onclick="add()">
                                <i class="fa fa-plus"></i>
                              </a>
                            </div>
                            <div class="panel-heading">Controle</div>
                          </div>
                        </div>
                        <span id="mais">
                          @if (isset($produto))
                            @foreach ($produto->campos as $key => $campo)
                              <div class="col-md-9" id="campo{{$key}}">
                                <div class="panel panel-default">
                                  <div class="panel-body">
                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label>Nome do campo</label>
                                        <input type="hidden" class="form-control" name="campo_id_edit[{{$key}}]" id="campo_nome_edit" value="{{$campo->id}}">
                                        <input type="text" class="form-control" name="campo_nome_edit[{{$key}}]" id="campo_nome_edit" value="{{$campo->nome}}">
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label>Valor do campo</label>
                                        <input type="text" class="form-control" name="campo_valor_edit[{{$key}}]" id="campo_valor_edit" value="{{$campo->valor}}">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            @endforeach
                          @endif
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="descricao">Descricao:</label>
                    <textarea></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
  <script>
    $('#custo').maskMoney({thousands:'', decimal:'.', allowZero:true});

    function gerarBarras(){
      var url = "{{url('novo/produto/barras')}}";
      $('#barras').prop('disabled', true);
      $.ajax({
        type: 'GET',
        url: url,
        data: { get_param: 'value' },
        dataType: 'json',
        success: function( data ) {
          $("#barras").val(data);
        },
        complete: function () {
          $('#barras').prop('disabled', false);
        }
      });
    }

    $(document).ready(function(){
      window.i = 0;
      @if (isset($estoque))
      @else
        add();
      @endif
    });
    function add() {
      var $clone = $($('#ToClone').html());
      $('#campo_nome', $clone).attr('name', 'campo_nome['+i+']');
      $('#campo_valor', $clone).attr('name', 'campo_valor['+i+']');
      $('.3397', $clone).attr('id', 'linha'+i);
      i = i + 1;
      $clone.appendTo('#mais');
    }
    function remove() {
      if (i<0){}else {
        $('#linha'+i).remove();
        if(i>0){
          i = i - 1;
        }
      }
    }
  </script>
  <script id="ToClone" type="text/template">
  <span>
    <div class="3397 col-md-9" id="a">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="col-md-3">
            <div class="form-group">
              <label for="text" id="numeroText">Nome do campo</label>
              <input type="text" class="form-control" value="" name="campo_nome" id="campo_nome">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="text">Valor do campo</label>
              <input type="text" class="form-control" value="" name="campo_valor" id="campo_valor">
            </div>
          </div>
        </div>
      </div>
    </div>
  </span>
  </script>
@endsection
