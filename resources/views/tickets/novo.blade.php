@extends('main')
@section('content')
  <div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-book"></i> Novo Ticket</div>
    <div class="panel-body">
      <div class="row" id="secondNavbar">
        <div class="col-md-2">
          <div class="row">
            <div class="col-md-3">
              <a href="" class="btn btn-info" id="buttonNovo"><i class="fa fa-gear"></i></a>
            </div>
            <div class="col-md-4">
              <input type="text" class="form-control" size="4" name="ids" id="ids" disabled>
            </div>
          </div>
        </div>
        <div class="col-md-3 pull-right text-right">
          <a href="{{url('lista/tickets')}}" class="btn btn-warning"><i class="fa fa-book"></i> Voltar a lista</a>
        </div>
      </div>
      @foreach ($contatos as $key => $contato)
        <div class="row list-contacts" onclick="selectRow({{$contato->id}})">
          <div class="col-md-2">
            <span class="label label-info">
              id: {{$contato->id}}
            </span>
          </div>
          <div class="col-md-4">
            {{$contato->nome}}
          </div>
        </div>
      @endforeach
      <div class="row">
        <div class="col-md-10 text-center">
          {{$contatos->links()}}
        </div>
      </div>
    </div>
  </div>
  <script language="javascript">
    function selectRow(id){
      window.id_attach_form= id;
      $("#ids").val(id);
      $("#buttonNovo").attr('href', '{{url("novo/tickets")}}/'+id);
    }
  </script>
@endsection
