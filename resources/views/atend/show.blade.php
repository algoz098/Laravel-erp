@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-11">
        <div class="form-group">
        <div class="panel panel-default">
          <div class="panel-heading"><i class="fa fa-list fa-1x"></i> Editar atendimento de <span class="label label-primary">{{$atendimento->contatos->nome}}</span></div>
          <form method="POST" action="{{ url('novo/atendimentos') }}/{{$atendimento->id}}">
            {{ csrf_field() }}
            <div class="panel-body">
              <div class="row text-right">
                <div class="col-sm-offset-2 col-sm-10">
                  <a class="btn btn-warning" href="{{ url('lista/atendimentos')}}" ><i class="fa fa-list"></i> Voltar a Lista</a>
                  <button type="submit" class="btn btn-success">Salvar</button>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="text">Assunto </label>
                    <select class="form-control" name="assunto" id="assunto">
                      <option value="" selected> - Escolha uma opção - </option>
                      @foreach($comboboxes as $key => $combobox)
                        <option value="{{$combobox->value}}" {{{$combobox->value==$atendimento->assunto? "selected":""}}}>{{$combobox->text}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="text">Contato </label>
                    <input type="text" class="form-control" value="{{$atendimento->contatos->nome}}" name="contato-off" id="contato" placeholder="Contato" disabled>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="text">Data criado </label>
                    <input type="text" class="form-control" value="{{$atendimento->created_at}}" name="data" id="data" placeholder="Criação" disabled>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="text">Descrição </label>
                    <textarea id="froala-editor" name="texto">{{$atendimento->texto}}</textarea>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
<script  language="javascript">
$(function() {
  $('#froala-editor').froalaEditor({
    direction: 'ltr'
  })
});
</script>
@endsection
