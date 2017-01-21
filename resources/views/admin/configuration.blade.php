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
          <div class="col-md-2">
            <div class="form-group">
              <label for="sel1">{{$field_codigo->text}}</label>
              <select class="form-control" id="sel1" name="{{$field_codigo->field}}">
                <option value="0" {{{$field_codigo->value=="0"? "selected" : ""}}}>Não usar</option>
                <option value="1" {{{$field_codigo->value=="1"? "selected" : ""}}}>Usar o campo</option>
              </select>
            </div>
          </div>
        </div>

      </div>
    </form>
  </div>
@endsection
