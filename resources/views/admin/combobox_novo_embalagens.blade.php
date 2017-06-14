@extends('main')
@section('content')
  <div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-list fa-1x"></i> Nova opção de combobox</div>
    <div class="panel-body">
      <form method="post" action="{{{isset($combobox) ? url('admin/combobox/novo')."/".$combobox->id : url('admin/combobox/novo')}}}">
        {{ csrf_field() }}
        <div class="row" id="secondNavbar">
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
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="col-md-3">
                  <label>Modulo selecionado: </label>
                  @if (isset($combobox))
                  <select class="form-control" id="tipo[0]" name="tipo[0]" disabled>
                    <option value="{{substr($combobox->combobox_textable_type, 4)}}" selected>{{substr($combobox->combobox_textable_type, 4)}}</option>
                  </select>
                  @else
                  <select class="form-control" id="tipo[0]" name="tipo[0]" disabled>
                    <option value="Produtos\Embalagens" selected>Unidade de medida para produtos</option>
                  </select>
                  <input value="Produtos\Embalagens" id="hidden" name="tipo[0]" type="hidden">
                  @endif
                </div>
                <div class="col-md-3" id="textHolder">
                  <label id="textLabel">Tipo de Embalagem (ex: Pacote)</label>
                  <input value="{{{isset($combobox) ? $combobox->value : ""}}}" type="text" class="form-control" id="value" name="value">
                </div>
                <div class="col-md-3" id="textHolder">
                  <label id="textLabel">Nome reduzido: (ex: Pct)</label>
                  <input value="{{{isset($combobox) ? $combobox->text : ""}}}" type="text" class="form-control" id="text" name="text">
                </div>
              </div>
            </div>
          @endif
        <span id="mais"></span>
      </form>
    </div>
  </div>
  <script language="javascript">
  window.i = -1;
  $(document).ready(function(){
    @if (!isset($combobox))
      add();
    @endif;
  });
  function add() {
    var $clone = $($('#ToClone').html());
    i = i + 1;
    $('#tipo', $clone).attr('name', 'tipo['+i+']');
    $('#text', $clone).attr('name', 'text['+i+']');
    $('#a', $clone).attr('name', 'value['+i+']');
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
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="col-md-3">
            <label>Modulo selecionado: </label>
            @if (isset($combobox))
            <select class="form-control" id="tipo[0]" name="tipo[0]" disabled>
              <option value="{{substr($combobox->combobox_textable_type, 4)}}" selected>{{substr($combobox->combobox_textable_type, 4)}}</option>
            </select>
            @else
            <select class="form-control" id="tipo[0]" name="tipo[0]" disabled>
              <option value="Produtos\Embalagens" selected>Embalagens de produtos</option>
            </select>
            <input value="Produtos\Embalagens" id="hidden" name="tipo[0]" type="hidden">
            @endif
          </div>
          <div class="col-md-3" id="textHolder">
            <label id="textLabel">Tipo de Embalagem (ex: Pacote)</label>
            <input value="{{{isset($combobox) ? $combobox->text : ""}}}" type="text" class="form-control" id="a" name="value">
          </div>
          <div class="col-md-3" id="textHolder">
            <label id="textLabel">Nome reduzido: (ex: Pct)</label>
            <input value="{{{isset($combobox) ? $combobox->text : ""}}}" type="text" class="form-control" id="text" name="text">
          </div>
        </div>
      </div>
    </div>
  </div>
</script>
@endsection
