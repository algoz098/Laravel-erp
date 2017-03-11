<div class="row "  id="lista">
  <div class="col-md-1">
    IDs
  </div>
  <div class="col-md-2">
    Quem foi atendido
  </div>
  <div class="col-md-2">
    Assunto
  </div>
  <div class="col-md-5">
    Descrição
  </div>
  <div class="col-md-1 pull-right">
    Quando
  </div>
</div>
@if (!empty($atendimentos))
  @foreach($atendimentos as $key => $atendimento)
    <div class="row list-contacts" onclick="selectRow({{$atendimento->id}})">
      <div class="limitar-string col-md-1 text-left ajuda-popover" @if ($key==0) title="Criação e contato" data-content="Data do atendimento, e contato atendido." data-placement="bottom" @endif >
        <span class="label label-info">
          ID: {{$atendimento->id}}
        </span>
      </div>
      <div class="col-md-2">
        @mostraContato($atendimento->contatos->id*str_limit($atendimento->contatos->nome, 15))
      </div>
      <div class="col-md-2">
        {{$atendimento->assunto}}
      </div>
      <div class="col-md-6">
        {{ str_limit(strip_tags($atendimento->texto), 60)}}
      </div>
      <div class="col-md-1 pull-right">
        <span class="label label-info">
          {{date('d/m/Y', strtotime($atendimento->created_at))}}
        </span>
      </div>
    </div>
  @endforeach
@endif
<div class="row">
  <div class="col-md-10 text-center">
    <span class="label label-primary">
      Total de atendimentos: {{ $total }}
    </span>
  </div>
</div>
<script>
$(document).ready( function(){
  @if ($atendimentos->count()<1)
    $.toaster({ message : 'Nao achei nada, veja a busca...', title : 'Ops!', priority : 'warning' , settings : {'timeout' : 3000,}});
  @endif
});
</script>
