<div class="row">
  <div class="col-md-1">
    ID:
  </div>
  <div class="col-md-2">
    Filial
  </div>
  <div class="col-md-1">
    Fornecedor
  </div>
  <div class="col-md-1">
    Total
  </div>
</div>
@if ($nfs!==0)
  @foreach($nfs as $key => $nf)
    <div class="row list-contacts" onclick="selectRow({{$nf->id}})">
      <div class="col-md-1">
        <span class="label label-info">ID: {{$nf->id}} </span>
      </div>
      <div class="col-md-2 limitar-string">
        @mostraContato($nf->filial->id*$nf->filial->nome)
      </div>
      <div class="col-md-1">
        @mostraContato($nf->fornecedor->id*$nf->fornecedor->nome)
      </div>
      <div class="col-md-1">
        R$ {{$nf->total}}
      </div>

    </div>
  @endforeach
@endif
