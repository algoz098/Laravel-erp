<div class="row hidden-xs" id="lista">
  <div class="col-md-1">
    IDs
  </div>
  <div class="col-md-1">
    Social
  </div>
  <div class="col-md-4">
    Razão Social
  </div>
  <div class="col-md-3">
    Nome Fantasia
  </div>
  <div class="col-md-2">
    Documento
  </div>
  <div class="col-md-1 pull-right">
    Detalhes
  </div>
</div>
@foreach($contatos as $key => $contato)
    <div class="row list-contacts" onclick="selectRow({{$contato->id}}), retornarEsta({{$contato->id}}, '{{$contato->nome}}')" >
      <div class="col-md-1  col-xs-2">
        <span class="label label-primary">
          {{{$contato->id}}}
        </span>
      </div>
      <div class="col-md-1  col-xs-2">
        @if(is_null($contato->active))
          <i class="fa fa-user level1"></i>
        @else
          <i class="fa fa-user level{{$contato->active}}"></i>
        @endif
        <i class="fa fa-signal level{{$contato->sociabilidade}}"></i>
      </div>
      <div class="limitar-string col-md-4 col-xs-3">
        {{ $contato->nome }}
        @if ($contato->tipo=="1"){{ $contato->sobrenome }}@endif
      </div>
      <div class="limitar-string col-md-3 col-xs-3">
         @if ($contato->tipo!="1"){{ $contato->sobrenome }}@endif
      </div>
      <div class="col-md-2 hidden-xs">
        {{ $contato->cpf }}
      </div>
      <div class="col-md-1 hidden-xs pull-right">
        <span class="label label-primary">{{date('d/m/Y', strtotime($contato->created_at))}}</label>
      </div>
    </div>
    <div class="sub-menu collapse " aria-expanded="" id="relacionamentos{{$contato->id}}" style="padding-left: 100px; padding-top: 15px; padding-bottom: 30px;">
      <a href="{{ url('lista/contatos') }}/{{$contato->id}}/relacoes" class="btn btn-warning" title="Relacionamentos">
        Editar relações
      </a><br>
      @foreach($contato->from as $key => $from)
        <div class="row list-contacts">
          {{$from->nome}} <span class="label label-info">{{$from->pivot->to_text}}</span>
        </div>
      @endforeach
      @foreach($contato->to as $key => $to)
        <div class="row list-contacts">
          {{$to->nome}} <span class="label label-info">{{$to->pivot->from_text}}</span>
        </div>
      @endforeach
    </div>
  <!-- Modal -->
  <form action="{{ url('lista/contatos') }}/{{$contato->id}}/attach" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
  <div class="modal fade" id="upload{{$contato->id}}" tabindex="-1" role="dialog" aria-labelledby="upload">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="addTelefonesLabel">Adicionar Anexo</h4>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Novo</button>
        </div>
      </div>
    </div>
  </div>
</form>
@endforeach
<div class="row">
  <div class="col-md-10 text-center">
    <span class="label label-primary">
      PJ: {{$empresas}}
    </span>&nbsp
    <span class="label label-primary">
      PF: {{$pessoas}}
    </span>&nbsp
    <span class="label label-primary">
      Total: {{$total}}
    </span>
  </div>
</div>
<script>
$(document).ready( function(){
  @if ($contatos->count()<1)
    $.toaster({ message : 'Nao achei nada, veja a busca...', title : 'Ops!', priority : 'warning' , settings : {'timeout' : 3000,}});
  @endif
});
</script>
