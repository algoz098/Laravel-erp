<?php use Carbon\Carbon; ?>
<div class="modal-dialog modal-lg extra" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">
        Detalhes do banco:
      </h4>
    </div>
    <div class="modal-body">
      <!-- Nav tabs -->
     <ul class="nav nav-tabs" role="tablist">
       <li role="presentation" class="active"><a href="#dados" aria-controls="dados" role="tab" data-toggle="tab">Dados</a></li>
       <li role="presentation"><a href="#historico" aria-controls="profile" role="tab" data-toggle="tab">historico</a></li>
     </ul>

     <!-- Tab panes -->
     <div class="tab-content">
       <div role="tabpanel" class="tab-pane active" id="dados"><br>
         <div class="row">
           <div class="col-md-2">
             <strong>Filial:</strong>
           </div>
           <div class="col-md-4">
             {{$banco->contato->sobrenome}}
           </div>
           <div class="col-md-2">
             <strong>Agencia:</strong>
           </div>
           <div class="col-md-4">
             {{$banco->agencia}}
           </div>
         </div>
         <div class="row">
           <div class="col-md-2">
             <strong>Banco:</strong>
           </div>
           <div class="col-md-4">
             {{$banco->banco->sobrenome}}
           </div>
           <div class="col-md-2">
             <strong>Conta corrente</strong>
           </div>
           <div class="col-md-4">
             {{$banco->cc}}-{{$banco->cc_dig}}
           </div>
         </div>
         <div class="row">
           <div class="col-md-2">
             <strong>Tipo:</strong>
           </div>
           <div class="col-md-4">
             {{$banco->tipo}}
           </div>
           <div class="col-md-2">
             <strong>Compensação</strong>
           </div>
           <div class="col-md-4">
             {{$banco->comp}}
           </div>
         </div>
         <div class="row">
           <div class="col-md-12 text-right">
             <h1>Valor em conta: R${{money_format('%.2n', $banco->valor)}}
           </div>
         </div>
       </div>
       <div role="tabpanel" class="tab-pane" id="historico">
         @foreach ($banco->contas as $key => $conta)
           <div class="row list-contacts">
             <div class="col-md-1">
               <span class="label label-info">
                 {{$conta->id}}
               </span>
             </div>
             <div class="col-md-2">
               {{$conta->nome}}
             </div>
             <div class="col-md-3">
               {{$conta->valor}}
             </div>
           </div>
         @endforeach
       </div>
     </div>

    </div>
    <div class="modal-footer">
      @botaoFecharModal
      @botaoEditarExtenso(novo/bancos*$banco->id)
    </div>
  </div>
</div>
