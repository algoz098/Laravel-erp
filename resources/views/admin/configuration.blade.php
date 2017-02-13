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
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#modulos" aria-controls="modulos" role="tab" data-toggle="tab">Modulos</a></li>
              <li role="presentation"><a href="#geral" aria-controls="geral" role="tab" data-toggle="tab">Geral</a></li>
              <li role="presentation"><a href="#contatos" aria-controls="contatos" role="tab" data-toggle="tab">Contatos</a></li>

            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane fade" id="geral"><br>
                <div class="row">
                  <div class="col-md-3">
                    <div class="panel panel-default">
                      <div class="panel-body">
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
                </div>
              </div>
              <div role="tabpanel" class="tab-pane fade" id="contatos"><br>
                <div class="row">
                  <div class="col-md-3">
                    <div class="panel panel-default">
                      <div class="panel-body">
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
                </div>
              </div>

              <div role="tabpanel" class="tab-pane fade in active" id="modulos"><br>
                <div class="row">
                  <div class="col-md-3">
                    <div class="panel panel-default">
                      <div class="panel-body">
                        <div class="form-group">
                          <label for="sel1">{{$modulo_atendimentos->text}}</label>
                          <select class="form-control" id="sel1" name="{{$modulo_atendimentos->field}}">
                            <option value="0" {{{$modulo_atendimentos->value=="0"? "selected" : ""}}}>Desativado</option>
                            <option value="1" {{{$modulo_atendimentos->value=="1"? "selected" : ""}}}>Ativado</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="sel1">{{$modulo_tickets->text}}</label>
                          <select class="form-control" id="sel1" name="{{$modulo_tickets->field}}">
                            <option value="0" {{{$modulo_tickets->value=="0"? "selected" : ""}}}>Desativado</option>
                            <option value="1" {{{$modulo_tickets->value=="1"? "selected" : ""}}}>Ativado</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="sel1">{{$modulo_contas->text}}</label>
                          <select class="form-control" id="sel1" name="{{$modulo_contas->field}}">
                            <option value="0" {{{$modulo_contas->value=="0"? "selected" : ""}}}>Desativado</option>
                            <option value="1" {{{$modulo_contas->value=="1"? "selected" : ""}}}>Ativado</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="sel1">{{$modulo_caixas->text}}</label>
                          <select class="form-control" id="sel1" name="{{$modulo_caixas->field}}">
                            <option value="0" {{{$modulo_caixas->value=="0"? "selected" : ""}}}>Desativado</option>
                            <option value="1" {{{$modulo_caixas->value=="1"? "selected" : ""}}}>Ativado</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="panel panel-default">
                      <div class="panel-body">
                        <div class="form-group">
                          <label for="sel1">{{$modulo_vendas->text}}</label>
                          <select class="form-control" id="sel1" name="{{$modulo_vendas->field}}">
                            <option value="0" {{{$modulo_vendas->value=="0"? "selected" : ""}}}>Desativado</option>
                            <option value="1" {{{$modulo_vendas->value=="1"? "selected" : ""}}}>Ativado</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="sel1">{{$modulo_estoques->text}}</label>
                          <select class="form-control" id="sel1" name="{{$modulo_estoques->field}}">
                            <option value="0" {{{$modulo_estoques->value=="0"? "selected" : ""}}}>Desativado</option>
                            <option value="1" {{{$modulo_estoques->value=="1"? "selected" : ""}}}>Ativado</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="sel1">{{$modulo_frotas->text}}</label>
                          <select class="form-control" id="sel1" name="{{$modulo_frotas->field}}">
                            <option value="0" {{{$modulo_frotas->value=="0"? "selected" : ""}}}>Desativado</option>
                            <option value="1" {{{$modulo_frotas->value=="1"? "selected" : ""}}}>Ativado</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
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
