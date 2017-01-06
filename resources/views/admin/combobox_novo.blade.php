@extends('main')
@section('content')
  <div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-list fa-1x"></i> Nova opção de combobox</div>
    <div class="panel-body">
      <form method="post" action="{{{isset($combobox) ? url('admin/combobox/novo')."/".$combobox->id : url('admin/combobox/novo')}}}">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-md-3 pull-right text-right">
            <a  href="{{url('admin/combobox')}}" class="btn btn-warning">
              <i class="fa fa-list"></i> Voltar a lista
            </a>
            <button type="submit" class="btn btn-success">
              <i class="fa fa-plus"></i> Salvar
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <label>Escolha o modulo</label>
            @if (isset($combobox))
              <select class="form-control" id="tipo" disabled>
                <option value="{{substr($combobox->combobox_textable_type, 4)}}" selected>{{substr($combobox->combobox_textable_type, 4)}}</option>
              </select>
            @else
              <select class="form-control" id="tipo" name="tipo" onchange="changeModule()">
                <option value="" selected> - Escolha uma opção - </option>
                <option value="Telefones">Tipo de telefones</option>
                <option value="Relacionamento">Relacionamento entre entidades</option>
                <option value="Atendimentos">Assunto de atendimentos</option>
              </select>
            @endif
          </div>
          <div class="col-md-3" style="display:none;" id="campoHolder">
            <label id="campoLabel">Campo do modulo</label>
            <select class="form-control" id="field" name="field">
              <option value="{{{isset($combobox) ? $combobox->field : ""}}}" selected> - Escolha uma opção - </option>
            </select>
          </div>
          <div class="col-md-3" style="display:none;"  id="textHolder">
            <label id="textLabel">Texto da opção</label>
            <input value="{{{isset($combobox) ? $combobox->text : ""}}}" type="text" class="form-control" id="text" name="text">
          </div>
          <div class="col-md-3" style="display:none;"  id="valueHolder">
            <label id="valueLabel">Valor da opção</label>
            <input value="{{{isset($combobox) ? $combobox->value : ""}}}" type="text" class="form-control" id="value" name="value">
          </div>
        </div>
      </form>
    </div>
  </div>
  <script language="javascript">
  $('#tipo').ready(changeModule());
  function changeModule(){
    var tipo = $('#tipo').val();
    if (tipo=="Telefones"){
      $("#campoHolder").hide();
      //$("#campoLabel").text("");
      $("#valueHolder").hide();
      //$("#valueLabel").text("");
      $("#textHolder").show();
      $("#textLabel").text("Texto da opção");
    }
    if (tipo=="Relacionamento"){
      $("#campoHolder").hide();
      //$("#campoLabel").text("");
      $("#valueHolder").show();
      $("#valueLabel").text("Relação de outro para um");
      $("#textHolder").show();
      $("#textLabel").text("Relação de um para outro");
    }
    if (tipo=="Atendimentos"){
      $("#campoHolder").hide();
      //$("#campoLabel").text("");
      $("#valueHolder").hide();
      //$("#valueLabel").text("");
      $("#textHolder").show();
      $("#textLabel").text("Texto do assunto");
    }
  }
  </script>
@endsection
