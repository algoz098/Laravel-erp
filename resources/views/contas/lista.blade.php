<div class="row" id="lista">
  <div class="col-md-1">
    ID
  </div>
  <div class="col-md-2">
    Entidade
  </div>
  <div class="col-md-2">
    Valor
  </div>
  <div class="col-md-2">
    Vencimento
  </div>
  <div class="col-md-2">
    Estado
  </div>
  <div class="col-md-2">
    Banco
  </div>
</div>
@foreach($contas as $key => $conta)
  <div class="row list-contacts" onclick="selectRow({{$conta->id}})" style="background-color: rgba(@if ($conta->tipo!="1") 244, 67, 54, @else 139, 195, 74, @endif 0.25);">
    <div class="col-md-1" >
      <span class="label label-info">
        ID: {{$conta->id}}
      </span>
    </div>
    <div class="col-md-2">
      <a onclick="openModal('{{url('lista/contatos')}}/{{$conta->contatos->id}}')" class="label label-primary">
        <i class="fa fa-user"></i>
        {{str_limit($conta->contatos->nome,15)}}
      </a>
    </div>
    <div class="col-md-2 ">
      <span >
        R$ {{ number_format($conta->valor, 2) }}
      </span>
    </div>
    <div class="col-md-2">
      <span >
        {{date('d/m/Y', strtotime($conta->vencimento))}}
      </span>&nbsp
    </div>
    <div class="col-md-2">
      <span >
        @if ($conta->estado==0 AND ($conta->tipo==0 OR $conta->tipo==2))
          A pagar
        @elseif ($conta->estado==0 AND ($conta->tipo==1 OR $conta->tipo==2))
          A receber
        @elseif ($conta->estado==1 AND ($conta->tipo==0 OR $conta->tipo==2))
          Pago
        @elseif ($conta->estado==1 AND ($conta->tipo==1 OR $conta->tipo==2))
          Recebido
        @endif
      </span>
    </div>
    <div class="col-md-2">
      @if (isset($conta->banco->banco))
        @mostraContato($conta->banco->banco->id*$conta->banco->banco->sobrenome)
      @endif
    </div>
  </div>
@endforeach
<div class="row">
  <div class="col-md-12 text-center">
    <span class="label label-danger">
      Debito pagos: R$ {{ money_format('%n', $total_debito) }}
    </span>&nbsp
    <span class="label label-danger">
      Debito a pagar: R$ {{ money_format('%n', $total_apagar) }}
    </span>&nbsp
    <span class="label label-success">
      Credito recebidos: R$ {{ money_format('%n', $total_credito) }}
    </span>&nbsp
    <span class="label label-success">
      Credito a receber: R$ {{ money_format('%n', $total_areceber) }}
    </span>&nbsp
  </div>
</div>
