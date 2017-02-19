@foreach ($contatos as $key => $contato)
  <div class="row list-contacts" onclick="retornarEsta({{$contato->id}}, '{{$contato->nome}}')">
    <div class="col-md-1">
      <span class="label label-info">
        ID: {{$contato->id}}
      </span>
    </div>
    <div class="col-md-2">
      {{$contato->cpf}}
    </div>
    @if ($contato->tipo!="0")

      <div class="col-md-7">
        {{$contato->nome}} {{$contato->sobrenome}}
      </div>
    @else
      <div class="col-md-4">
        {{str_limit($contato->nome, 40)}}
      </div>
      <div class="col-md-3">
        {{$contato->sobrenome}}
      </div>
    @endif
    <div class="col-md-2">
      @if ($contato->id=="1")<span class="label label-danger">Matriz</span>
      @else
        @foreach($contato->from as $key => $from)
          @if ($from->id=="1")
            <span class="label label-warning">{{$from->pivot->from_text}}</span>
          @else
            <span class="label label-default">N/C</span>
          @endif
        @endforeach
      @endif
      @if ($contato->from=="[]" and $contato->id!=1)
        <span class="label label-default">N/C</span>
      @endif
    </div>
  </div>
@endforeach
