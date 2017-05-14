<div class="row">
  <div class="col-md-1">
    ID
  </div>
  <div class="col-md-1">
    Data
  </div>
  <div class="col-md-1">
    NF
  </div>
  <div class="col-md-2">
    Fornecedor
  </div>
  <div class="col-md-1">
    Total
  </div>
  <div class="col-md-2">
    Filial
  </div>
  <div class="col-md-1">
    Obs
  </div>
</div>
@if ($nfs!==0)
  @foreach($nfs as $key => $nf)
    <div class="row list-contacts" onclick="selectRow({{$nf->id}})">
      <div class="col-md-1">
        <span class="label label-info">ID: {{$nf->id}} </span>
      </div>
      <div class="col-md-1">
        {{date('d/m/Y', strtotime($nf->created_at))}}
      </div>
      <div class="col-md-1 limitar-string">
        {{$nf->numero}}
      </div>
      <div class="col-md-2 limitar-string">
        @mostraContato($nf->fornecedor->id*$nf->fornecedor->nome)
      </div>
      <div class="col-md-1 limitar-string">
        R$ {{$nf->total}}
      </div>
      <div class="col-md-2">
        @mostraContato($nf->filial->id*$nf->filial->nome)
      </div>
      <div class="col-md-1">
        {{strip_tags($nf->obs)}}
      </div>

    </div>
  @endforeach
@endif
