@foreach ($contatos as $key => $contato)
  <div class="row list-contacts" onclick="retornarEsta({{$contato->id}}, '{{$contato->nome}}')">
    <div class="col-md-1">
      <span class="label label-info">
        ID: {{$contato->id}}
      </span>
    </div>
    <div class="col-md-11">
      {{$contato->nome}}
    </div>
  </div>
@endforeach
