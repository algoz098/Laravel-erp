<div class="row" id="lista">
  <div class="col-md-1">
    ID
  </div>
  <div class="col-md-1">
    Placa
  </div>
  <div class="col-md-2">
    Modelo
  </div>
  <div class="col-md-1">
    Ano
  </div>
  <div class="col-md-2">
    Combustivel
  </div>
  <div class="col-md-2">
    A quem
  </div>
  <div class="col-md-1 pull-right">
    Compra
  </div>
</div>
@foreach($frotas as $key => $frota)
  <div class="row list-contacts" onclick="selectRow({{$frota->id}})">
    <div class="col-md-1" >
      <span class="label label-info">
        ID: {{$frota->id}}
      </span>
    </div>
    <div class="col-md-1" >
      <span class="label label-info">
        {{$frota->placa}}
      </span>
    </div>
    <div class="col-md-2" >
      <span class="label label-info">
        {{$frota->modelo}}
      </span>
    </div>
    <div class="col-md-1" >
      <span class="label label-info">
        {{$frota->ano}}
      </span>
    </div>
    <div class="col-md-2" >
      <span class="label label-info">
        {{$frota->combustivel}}
      </span>
    </div>
    <div class="col-md-2" >
      <a class="label label-primary" onclick="openModal('{{url('lista/contatos/')}}/{{$frota->contato->id}}')">
        <i class="fa fa-user"></i>
        {{$frota->contato->nome}}
      </a>
    </div>
    <div class="col-md-1 pull-right" >
      <span class="label label-info">
        {{$frota->compra}}
      </span>
    </div>
  </div>
@endforeach
