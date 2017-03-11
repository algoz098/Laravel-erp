
<div class="row" id="lista">
  <div class="col-md-1">
    ID
  </div>
  <div class="col-md-2">
    Filial
  </div>
  <div class="col-md-1">
    Banco
  </div>
  <div class="col-md-2">
    Tipo
  </div>
  <div class="col-md-1">
    Agencia
  </div>
  <div class="col-md-1">
    CC/Dig
  </div>
  <div class="col-md-1">
    Comp
  </div>
  <div class="col-md-1">
    Em conta
  </div>
  <div class="col-md-1 pull-right">
    Criado em
  </div>
</div>
@foreach($bancos as $key => $banco)
  <div class="row list-contacts" onclick="selectRow({{$banco->id}})">
    <div class="col-md-1" >
      <span class="label label-info">
        ID: {{$banco->id}}
      </span>
    </div>
    <div class="col-md-2 ">
      @mostraContato($banco->contato->id*$banco->contato->sobrenome)
    </div>
    <div class="col-md-1 ">
      @if (isset($banco->banco->id))
        @mostraContato($banco->banco->id*$banco->banco->sobrenome)
      @else
        N/C
      @endif
    </div>

    <div class="col-md-2">
      {{$banco->tipo}}
    </div>
    <div class="col-md-1">
      {{$banco->agencia}}
    </div>
    <div class="col-md-1">
      {{$banco->cc}}-{{$banco->cc_dig}}
    </div>
    <div class="col-md-1">
      {{$banco->comp}}
    </div>
    <div class="col-md-1">
      R$ {{money_format('%.2n', $banco->valor)}}
    </div>
    <div class="col-md-1 pull-right">
      <span class="label label-{{{$banco->tipo!="1" ? "danger" : "success"}}}">
        {{date('d/m/Y', strtotime($banco->created_at))}}
      </span>
    </div>
  </div>
@endforeach
