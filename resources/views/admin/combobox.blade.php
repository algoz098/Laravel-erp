@extends('main')
@section('content')
  <div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-users fa-1x"></i> Logs</div>
    <div class="panel-body">
      <div>
        <div class="row" id="secondNavbar">
          <div class="col-md-1 text-right">
            <a href="{{url('/admin/combobox/delete')}}/" class="btn btn-danger" id="buttonDelete">
              <i class="fa fa-ban"></i>
            </a>
            <a href="{{url('/admin/combobox')}}/" class="btn btn-info" id="buttonEdit">
              <i class="fa fa-pencil"></i>
            </a>
          </div>
          <div class=" form-inline col-md-2">
            <input type="text" class="form-control" size="4" name="ids" id="ids" placeholder="Detalhes" disabled>
          </div>
          <div class="col-md-2 pull-right text-right">
            <a href="{{url('admin/combobox/novo')}}" class="btn btn-success">
              <i class="fa fa-plus"></i> Novo
            </a>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-1">
          ID
        </div>
        <div class="col-md-2">
          Modulo
        </div>
        <div class="col-md-2">
          Texto
        </div>
        <div class="col-md-2">
          Para relação
        </div>
      </div>
      @foreach($comboboxes as $key => $combobox)
        <div class="row list-contacts" onclick="selectRow({{$combobox->id}})">
          <div class="col-md-1">
            <span class="label label-info">
              id: {{$combobox->id}}
            </span>
          </div>
          <div class="col-md-2">
            {{substr($combobox->combobox_textable_type,4)}}
          </div>
          <div class="col-md-2">
            {{$combobox->value}}
          </div>
          @if($combobox->combobox_textable_type=="App\Relacionamento")
            <div class="col-md-2">
              {{$combobox->text}}
            </div>
          @endif
        </div>
      @endforeach
    </div>
  </div>
  <script>
  function selectRow(id){
    $("#ids").val(id);
    $("#buttonDelete").attr('href', '{{url('/admin/combobox/delete')}}/'+id);
    $("#buttonEdit").attr('href', '{{url('/admin/combobox')}}/'+id);
  }
  </script>
@endsection
