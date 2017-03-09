<?php
use Carbon\Carbon;
?>
@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-usd fa-1x"></i> Novo historico bancario
        </div>
        <div class="panel-body">
          @if (isset($is_consumos) and $is_consumos=="1")
            @if (isset($conta))
              <form method="POST" action="{{ url('/novo/contas') }}/{{$conta->id}}">
            @else
              <form method="POST" action="{{ url('/novo/consumos') }}/parcelas">
            @endif
          @else
            @if (isset($conta))
              <form method="POST" action="{{ url('/novo/contas') }}/{{$conta->id}}">
            @else
              <form method="POST" action="{{ url('/novo/contas') }}/parcelas">
              @endif
          @endif
            <div class="row" id="secondNavbar">
              <div class="col-md-12 text-right pull-right">
                <a class="btn btn-warning" href="{{ url('lista/contas')}}" ><i class="fa fa-usd"></i> Voltar a Lista</a>
                <button type="submit" id="saveButton" class="btn btn-success"><i class="fa fa-check"></i> Salvar</a>
              </div>
            </div>
            {{ csrf_field() }}
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Inicio</a></li>
              @if (isset($is_consumos) and $is_consumos=="1")
                <li role="presentation"><a href="#consumos" aria-controls="consumos" role="tab" data-toggle="tab">Consumos</a></li>
              @endif
              <li role="presentation"><a href="#descricao" aria-controls="descricao" role="tab" data-toggle="tab">Descrição</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="home"><br>
                <div class="row">
                  <div class="col-md-3">
                    <div class="panel panel-default">
                      <div class="panel-heading">Informações basicas</div>
                      <div class="panel-body">
                        @if (isset($conta))
                          @selecionaContato(Provisao para:*$conta->contatos->id*$conta->contatos->nome)
                        @else
                          @selecionaContato(Provisao para:)
                        @endif
                        <div class="form-group">
                          <label>Tipo</label>
                          @if (isset($is_consumos) and $is_consumos=="1")
                            <input type="hidden" name="tipo" value="2">
                            <select class="form-control" id="tipo_conta" name="tipo" onchange="tipoChange()" disabled>
                                <option value="2" selected>Conta de consumo</option>
                            @else
                              @if (isset($conta))
                                <select class="form-control" id="tipo_conta" name="tipo" onchange="tipoChange()">
                                  <option value="0" {{$conta->tipo==0 ? "selected" : ""}}>Saida</option>
                                  <option value="1" {{$conta->tipo==1 ? "selected" : ""}}>Entrada</option>
                              @else
                                <select class="form-control" id="tipo_conta" name="tipo" onchange="tipoChange()">
                                  <option value="0" selected>Saida</option>
                                  <option value="1">Entrada</option>
                              @endif
                            @endif

                          </select>
                        </div>
                        <div class="form-group">
                          <label>Referencia</label>
                          <select class="form-control" id="nome" name="nome"  onchange="referenciaChange()">
                            <option value="" {{!isset($conta) ? "selected" : ""}}> - Escolha uma opção - </option>
                            @foreach($comboboxes as $key => $combobox)
                              <option value="{{$combobox->value}}"
                                {{{isset($conta) && $conta->nome==$combobox->value ? "selected" : ""}}}>{{$combobox->text}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="panel panel-default">
                      <div class="panel-heading">Pagamento e valores</div>
                      <div class="panel-body">
                        <div class="form-group">
                          <label for="cheio">Vencimento</label>
                          <input string="numeric" class="form-control datepicker" id="vencimento" name="vencimento" value="{{{isset($conta) ? $conta->vencimento : Carbon::Now()}}}">
                        </div>
                        <div class="form-group">
                          <label for="cheio">Valor cheio</label>
                          <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">R$</span>
                            <input type="text" class="form-control real-mask" name="cheio" id="cheio" placeholder="" value="{{{isset($conta) ? $conta->valor : ""}}}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="cheio">Desconto</label>
                          <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">R$</span>
                            <input type="text" class="form-control real-mask" name="desconto" id="desconto" value="{{{isset($conta) ? $conta->desconto : ""}}}">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="panel panel-default">
                      <div class="panel-heading">Desconto e detalhes</div>
                      <div class="panel-body">
                        <div class="form-group" style="display: none;">
                          <label for="parcelas">Qtd de parcelas</label>
                          <input type="numeric" class="form-control integer-mask" id="parcelas" name="parcelas" value="0" placeholder="Numero" onchange="parcelaChange()">
                        </div>
                        <div class="form-group" id="valorEntrada" style="display: none;">
                          <label for="parcelas">Valor de entrada</label>
                          <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">R$</span>
                            <input type="numeric" class="form-control real-mask" id="valor_entrada" name="valor_entrada" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="parcelas" id="parcelasText">D.M. - Num. documento</label>
                          <input type="numeric" class="form-control" id="dm" name="dm" value="{{{isset($conta) ? $conta->dm : ""}}}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="descricao"><br>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="text">Descrição </label>
                      <textarea class="form-control" id="texto" rows="2" name="descricao">{{{isset($conta) ? $conta->descricao : ""}}}</textarea>
                    </div>
                  </div>
                </div>
              </div>
              @if (isset($is_consumos) and $is_consumos=="1")
                <div role="tabpanel" class="tab-pane" id="consumos"><br>
                  @include('contas.consumos.valores')
                </div>
              @endif
            </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready( function(){
      referenciaChange();
    });
    function tipoChange(){
      var tipo = $('#tipo').val();
      var anterior = $('#saveButton').html();
      if(tipo==2){
        $('#discRow').show();
        $('#saveButton').html('<i class="fa fa-check"></i> Salvar');
      } else {
        $('#discRow').hide();
        //parcelaChange();
      }
    }

    function parcelaChange(){
      var value = parseInt($('#parcelas').val());
      if (value>0){
        $('#valorEntrada').show();
        $('#saveButton').html('<i class="fa fa-arrow-right"></i> Parcelas');
      } else {
        $('#valorEntrada').hide();
        $('#saveButton').html('<i class="fa fa-check"></i> Salvar');
      }
    }
</script>
@endsection
