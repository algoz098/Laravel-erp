@extends('main')
@section('content')
  <div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-list fa-1x"></i> Nova opção de combobox</div>
    <div class="panel-body">
      <form method="post" action="{{{isset($combobox) ? url('admin/combobox/novo')."/".$combobox->id : url('admin/combobox/novo')}}}">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-md-12 pull-right text-right">
            <a  href="{{url('admin/combobox')}}" class="btn btn-warning">
              <i class="fa fa-list"></i> Voltar a lista
            </a>
            <button type="submit" class="btn btn-success">
              <i class="fa fa-plus"></i> Salvar
            </button>
            @if (!isset($combobox))
              <a class="btn btn-danger" onclick="remove()">
                <i class="fa fa-minus"></i>
              </a>
              <a class="btn btn-success" onclick="add()">
                <i class="fa fa-plus"></i>
              </a>
            @endif
          </div>
        </div>
        <div class="row">
            @if (isset($combobox))
              <div class="col-md-3">
                <label>Modulo selecionado: </label>
                <select class="form-control" id="tipo[0]" name="tipo" disabled>
                  <option value="{{substr($combobox->combobox_textable_type, 4)}}" selected>{{substr($combobox->combobox_textable_type, 4)}}</option>
                </select>
              </div>
              <div class="col-md-3" id="textHolder">
                <label id="textLabel">Assunto</label>
                <input value="{{{isset($combobox) ? $combobox->text : ""}}}" type="text" class="form-control" id="text[0]" name="text">
              </div>
            @else
              <div class="col-md-3">
                <label>Modulo selecionado: </label>
                <select class="form-control" id="tipo[0]" name="tipo" disabled>
                  <option value="Atendimentos" selected>Assunto de atendimento</option>
                </select>
                <input value="Atendimentos" name="tipo[0]" type="hidden">
              </div>
              <div class="col-md-3" id="textHolder">
                <label id="textLabel">Assunto</label>
                <input value="{{{isset($combobox) ? $combobox->text : ""}}}" type="text" class="form-control" id="text[0]" name="text[0]">
              </div>
            @endif
          </div>
        <span id="mais"></span>
      </form>
    </div>
  </div>
  <script language="javascript">
  window.i = 0;
  function add() {
    var $clone = $($('#ToClone').html());
    i = i + 1;
    $('#tipo', $clone).attr('name', 'tipo['+i+']');
    $('#text', $clone).attr('name', 'text['+i+']');
    $('#hidden', $clone).attr('name', 'tipo['+i+']');
    $('.3397', $clone).attr('id', 'linha'+i);
    $clone.appendTo('#mais');
  }
  function remove() {
    $('#linha'+i).remove();
    i = i - 1;
  }
  </script>

  <script id="ToClone" type="text/template">
  <div>
    <div class="row 3397">
      <div class="col-md-3">
        <label>Modulo selecionado: </label>
        @if (isset($combobox))
          <select class="form-control" id="tipo" disabled>
            <option value="{{substr($combobox->combobox_textable_type, 4)}}" selected>{{substr($combobox->combobox_textable_type, 4)}}</option>
          </select>
        @else
          <select class="form-control" id="tipo[0]"disabled>
            <option value="Atendimentos" selected>Assunto de atendimento</option>
          </select>
          <input id="hidden" value="Atendimentos" name="tipo[0]" type="hidden">
        @endif
      </div>
      <div class="col-md-3" id="textHolder">
        <label id="textLabel">Assunto</label>
        <input value="{{{isset($combobox) ? $combobox->text : ""}}}" type="text" class="form-control" id="text" name="text">
      </div>
    </div>
  </div>
</script>
@endsection
