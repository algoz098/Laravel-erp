<div class="row">
  <div class="col-md-1">
    Id
  </div>
  <div class="col-md-2">
    Contato
  </div>
  <div class="col-md-3">
    Estado
  </div>
  <div class="col-md-2">
    Descrição
  </div>
  <div class="col-md-1 pull-right text-right">
    Quando
  </div>
</div>
@foreach ($tickets as $key => $ticket)
  <div class="row list-contacts" onclick="selectRow({{$ticket->id}})">
    <div class="col-md-1">
      <span class="label label-info">
        id: {{$ticket->id}}
      </span>
    </div>
    <div class="col-md-2">
      @mostraContato($ticket->contato->id*$ticket->contato->nome)
    </div>
    <div class="col-md-3">
      {{$ticket->status}}
    </div>
    <div class="col-md-5">
      {{strip_tags($ticket->descricao)}}
    </div>
    <div class="col-md-1 pull-right text-right">
      <span class="label label-info">
        {{date('d/m/Y', strtotime($ticket->created_at))}}
      </span>
    </div>
  </div>
@endforeach
