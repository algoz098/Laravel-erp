<div class="row">
  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-body">
        {{ csrf_field() }}
        @if (isset($banco))
          @selecionaFilial($banco->contatos_id*$banco->contato->sobrenome)
          @selecionaContato(Banco*$banco->banco->id*$banco->banco->sobrenome)
        @else
          @selecionaFilial
          @selecionaContato(Banco)
        @endif
        <div class="form-group">
          <label>Tipo</label>
          <select class="form-control" id="tipo_banco" name="tipo" >
            @if (isset($banco))
              <option value="{{$banco->tipo}}" selected>{{$banco->tipo}} (atual)</option>
              <option value="Conta corrente" >Conta corrente</option>
              <option value="Poupança" >Poupança</option>
            @else
              <option value="Conta corrente" selected>Conta corrente</option>
              <option value="Poupança" >Poupança</option>
            @endif
          </select>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-body">
        @if (isset($banco))
          @campoTexto(Agencia*agencia*$banco->agencia)
          <div class="row">
            <div class="col-md-7">
              @campoTexto(Conta Corrente*cc*$banco->cc)
            </div>
            <div class="col-sm-5">
              @campoTexto(Dig.*cc_dig*$banco->cc_dig)
            </div>
          </div>
          @campoTexto(Compensação*comp*$banco->comp)
        @else
          @campoTexto(Agencia*agencia*)
          <div class="row">
            <div class="col-md-7">
              @campoTexto(Conta Corrente*cc*)
            </div>
            <div class="col-sm-5">
              @campoTexto(Dig.*cc_dig*)
            </div>
          </div>
          @campoTexto(Compensação*comp*)
        @endif
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-body">
        @if (isset($banco))
          @campoTexto(Valor em conta*valor*money_format('%.2n', $banco->valor))
        @else
          @campoTexto(Valor em conta*valor*)
        @endif
      </div>
    </div>
  </div>
</div>
