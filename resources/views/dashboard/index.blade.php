@section('content')
@extends('main')
  @if ($contatos!="0")
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default text-center">
          <div class="panel-heading"><i class="fa fa-users"></i> Entidades:</div>
          <div class="panel-body">
            <a href="{{ url('lista/contatos') }}">Ver lista</a>
            <div class="row">
              <div class="col-md-4">
                <div id="contatos-donut" style="height: 200px;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
  @if ($atendimentos!="0")
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default text-center">
          <div class="panel-heading"><i class="fa fa-list"></i> Atendimentos:</div>
          <div class="panel-body">
            <a href="{{ url('lista/atendimentos') }}">Ver lista</a>
            <div class="row">
              <div class="col-md-4">
                <div id="atendimento-donut" style="height: 200px;"></div>
              </div>
              <div class="col-md-8">
                <div id="atendimento-line" style="height: 200px;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
  <script>
  @if ($contatos!="0")
    new Morris.Donut({
      element: 'contatos-donut',
      data: [
        {label: "Pessoas Fisicas", value: "{{count($contatos->where('tipo', '1'))}}"},
        {label: "Pessoas Juridicas", value: "{{count($contatos->where('tipo', '0'))}}"}
      ]
    });
  @endif
  @if ($contatos!="0")
    new Morris.Donut({
      element: 'atendimento-donut',
      data: [
        @foreach($contatos as $key => $contato)
        @if (isset($contato->atendimento[0]))
        {label: "{{$contato->nome}}", value: "{{count($contato->atendimento)}}"},
        @endif
        @endforeach
      ]
    });
  @endif
  @if ($atendimentos!="0")
    new Morris.Line({
      element: 'atendimento-line',
      data: [
        @foreach($atendimentos as $key => $atendimento)
        { y: '{{$atendimento[0]->created_at->format('Y-m')}}', a: "{{$atendimento->count()}}"},
        @endforeach
      ],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['Atendimentos']
    });
  @endif
  </script>
@endsection
