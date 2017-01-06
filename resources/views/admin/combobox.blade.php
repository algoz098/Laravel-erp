@extends('main')
@section('content')
  <div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Logs</div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-2 pull-right text-right">
          <a href="{{url('admin/combobox/novo')}}" class="btn btn-success">
            <i class="fa fa-plus"></i> Novo
          </a>
        </div>
      </div>
      @foreach($comboboxes as $key => $combobox)
        <div class="row list-contacts" style="font-size: 16px;">
          <div class="col-md-1">
            <a href="{{url('/admin/combobox/delete')}}/{{$combobox->id}}" class="btn btn-danger">
              <i class="fa fa-ban"></i>
            </a>
            <a href="{{url('/admin/combobox')}}/{{$combobox->id}}" class="btn btn-info">
              <i class="fa fa-pencil"></i>
            </a>
          </div>
          <div class="col-md-2">
            {{substr($combobox->combobox_textable_type,4)}}
          </div>
          <div class="col-md-1">
            {{$combobox->field}}
          </div>
          <div class="col-md-1">
            {{$combobox->value}}
          </div>
          <div class="col-md-1">
            {{$combobox->text}}
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection
