@extends('main')
@section('content')
  <div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-gear fa-1x"></i> Configurações do ERP</div>
    <form method="post" action="{{url('admin/config')}}">
      {{ csrf_field() }}
      <div class="panel-body">
        <div class="row">
          <div class="col-md-1 pull-right text-right">
            <button type="submit" class="btn btn-success">
              <i class="fa fa-plus"></i> Salvar
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="sel1">{{$field_codigo->text}}</label>
              <select class="form-control" id="sel1" name="{{$field_codigo->field}}">
                <option value="0" {{{$field_codigo->value=="0"? "selected" : ""}}}>Não usar</option>
                <option value="1" {{{$field_codigo->value=="1"? "selected" : ""}}}>Usar o campo</option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="sel1">{{$img_destaque->text}}</label>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-info" type="button" data-toggle="modal" data-target="#img_destaque">Escolher foto</button>
                </span>
                <input class="form-control" id="img_destaqueInput" type="text" value="{{$img_destaque->value}}" disabled="false">
                <input class="form-control" id="img_destaqueHidden" type="hidden" name="{{$img_destaque->field}}" value="{{$img_destaque->options}}">
              </div>
            </div>
          </div>
        </div>

      </div>
    </form>
  </div>

<div class="modal fade" tabindex="-1" role="dialog" id="img_destaque">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Escolher foto de destaque</h4>
      </div>
      <div class="modal-body">
        <p>Clique no anexo da matriz</p>
        @foreach($matriz->attachs as $key => $attach)
          <div class="row list-contacts" onclick="img_destaqueSelect('{{$attach->id}}', '{{$attach->name}}')">
            <div class="col-md-4">
              Nome:
              <span class="label label-info">
                {{$attach->name}}
              </span>
            </div>
            <div class="col-md-8">
              Arquivo: {{substr($attach->path, 7)}}
            </div>
          </div>
        @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
function img_destaqueSelect(id, name){
  $('#img_destaqueInput').val(name);
  $('#img_destaqueHidden').val(id);
  $('#img_destaque').modal('toggle');
}
</script>
@endsection
