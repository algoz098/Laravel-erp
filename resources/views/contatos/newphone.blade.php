@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-11">
      <form method="POST" action="{{ url('lista/contatos') }}/{{$contato->id}}/telefones/">
        <div class="form-group">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="">
        <div class="panel panel-default">
          <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Adicionar telefone para <span class="label label-primary">{{$contato->nome}}</span></div>
          <div class="panel-body">
            <div class="row text-right">
              <div class="col-sm-offset-2 col-sm-10">
                <a class="btn btn-warning" href="{{ url('lista/contatos')}}" ><i class="fa fa-users"></i> Voltar a Lista</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Salvar</button>
                <a class="btn btn-danger" onclick="remove()">
                  <i class="fa fa-minus"></i>
                </a>
                <a class="btn btn-success" onclick="add()">
                  <i class="fa fa-plus"></i>
                </a>
              </div>
            </div>
            <div class="row" id="linha">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="text">Tipo</label>
                  <select class="form-control" id="tipo" name="tipo[0]">
                    <option value="" selected> - Escolha uma opção - </option>
                    @foreach($comboboxes as $key => $combobox)
                      <option value="{{$combobox->value}}">{{$combobox->text}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-9">
                <div class="form-group">
                  <label for="text">Numero</label>
                  <div class="input-group">
                    <input type="text" class="form-control" value="" name="numero[0]" id="numero0" placeholder="">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">- Escolher formatação -  <span class="caret"></span></button>
                      <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="#" onclick="selMask(0, 0)">Mascara a usar: (99) 9.9999-9999</a></li>
                        <li><a href="#" onclick="selMask(1, 0)">Mascara a usar: (99) 9999-9999</a></li>
                        <li><a href="#" onclick="selMask(99, 0)">Remover mascara</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                  </div>
                </div>
              </div>
            </div>
            <span id="mais"></span>
        </div>
      </form>
    </div>
  </div>
  <script language="javascript">
  window.i = 0;
  function add() {
    var $clone = $($('#ToClone').html());
    i = i + 1;
    $('#tipo', $clone).attr('name', 'tipo['+i+']');
    $('#numero', $clone).attr('name', 'numero['+i+']');
    $('.3397', $clone).attr('id', 'linha'+i);
    $('#lia', $clone).attr('onclick', 'selMask(0, '+i+')');
    $('#lib', $clone).attr('onclick', 'selMask(1, '+i+')');
    $('#lic', $clone).attr('onclick', 'selMask(99, '+i+')');
    $clone.appendTo('#mais');
  }
  function remove() {
    $('#linha'+i).remove();
    i = i - 1;
  }
  function selMask(a, key){
    if( a=='99'){
      $('#numero'+key).mask("");
    } if (a=='0'){
      $('#numero'+key).mask("(99) 9.9999-9999");
    } if (a=='1'){
      $('#numero'+key).mask("(99) 9999-9999");
    }
  }
  </script>

  <script id="ToClone" type="text/template">
  <div>
    <div class="row 3397" id="a">
      <div class="col-md-3">
        <div class="form-group">
          <label for="text">Tipo</label>
          <select class="form-control" id="tipo" name="tipo[0]">
            <option value="" selected> - Escolha uma opção - </option>
            @foreach($comboboxes as $key => $combobox)
              <option value="{{$combobox->value}}">{{$combobox->text}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-md-9">
        <div class="form-group">
          <label for="text">Numero</label>
          <div class="input-group">
            <input type="text" class="form-control" value="" name="numero[0]" id="numero" placeholder="">
            <div class="input-group-btn">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">- Escolher formatação -  <span class="caret"></span></button>
              <ul class="dropdown-menu dropdown-menu-right">
                <li><a href="#" id="lia" onclick="selMask(0, 0)">Mascara a usar: (99) 9.9999-9999</a></li>
                <li><a href="#" id="lib" onclick="selMask(1, 0)">Mascara a usar: (99) 9999-9999</a></li>
                <li><a href="#" id="lic" onclick="selMask(99, 0)">Remover mascara</a></li>
              </ul>
            </div><!-- /btn-group -->
          </div>
        </div>
      </div>
    </div>
  </div>
</script>
@endsection
