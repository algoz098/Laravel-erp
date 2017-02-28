{{ csrf_field() }}
@if(Request::url()!== 'url("novo/produto")')
  <div class="row">
    <div class="col-md-2 pull-right text-right">
      @botaoSalvarModal
    </div>
  </div>
@endif
<div class="row">
  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="form-group">
          <label for="barras">Codigo de barras</label>
          <div class="input-group">
             <input type="text" class="form-control" id="barras" name="barras">
             <span class="input-group-btn">
               <button class="btn btn-info" type="button" onclick="gerarBarras()"><i class="fa fa-gear"></i></button>
             </span>
           </div>
         </div>
        @campoTexto(Produto do grupo*grupo*)
        @campoTexto(Tipo do produto*tipo*)
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="panel panel-default">
        <div class="panel-body">
          @campoTexto(Nome do Produto*nome*)
          <div class="form-group">
            <label for="unidade">Unidade de medida:</label>
            <select class="form-control" id="unidade" name="unidade">
              <option selected>- Escolha -</option>
              <option value="Pç">Peça</option>
              <option value="Un">Unidade</option>
              <option value="Kg">Kilograma</option>
              <option value="Lts">Litro</option>
            </select>
          </div>
          @campoDinheiro(Valor de custo*custo*)
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Campos extras</h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-2 pull-right text-right">
              <div class="panel panel-default">
                <div class="panel-body">
                  <a class="btn btn-danger" onclick="remove()">
                    <i class="fa fa-minus"></i>
                  </a>
                  <a class="btn btn-success" onclick="add()">
                    <i class="fa fa-plus"></i>
                  </a>
                </div>
                <div class="panel-heading">Controle</div>
              </div>
            </div>
            <span id="mais"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="descricao">Descricao:</label>
        <textarea></textarea>
      </div>
    </div>
  </div>
  <script>
    $('#custo').maskMoney({thousands:'', decimal:'.', allowZero:true});
    tinymce.init({
      selector: 'textarea',
      height: 200,
      menubar: false,
      plugins: [
        'advlist autolink lists link charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime table contextmenu paste code'
      ],
      toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',

    });
    function gerarBarras(){
      var url = "{{url('novo/produto/barras')}}";
      $('#barras').prop('disabled', true);
      $.ajax({
        type: 'GET',
        url: url,
        data: { get_param: 'value' },
        dataType: 'json',
        success: function( data ) {
          $("#barras").val(data);
        },
        complete: function () {
          $('#barras').prop('disabled', false);
        }
      });
    }

    $(document).ready(function(){
      window.i = 0;
      @if (isset($estoque))
      @else
        add();
      @endif
    });
    function add() {
      var $clone = $($('#ToClone').html());
      $('#campo_nome', $clone).attr('name', 'campo_nome['+i+']');
      $('#campo_valor', $clone).attr('name', 'campo_valor['+i+']');
      $('#campo_nome', $clone).attr('id', 'campo_nome'+i);
      $('#campo_valor', $clone).attr('id', 'campo_valor'+i);
      $('.3397', $clone).attr('id', 'linha'+i);
      i = i + 1;
      $clone.appendTo('#mais');
    }
    function remove() {
      if (i<0){}else {
        $('#linha'+i).remove();
        if(i>0){
          i = i - 1;
        }
      }
    }

    function enviarModal(){
      var a = 0;
      var campo_nome = new Array;
      var campo_valor = new Array;
      while (a <= i){
        campo_nome[a] = $('#campo_nome'+a).val();
        campo_valor[a] = $('#campo_valor'+a).val();
        a++;
      }
      var tipo = new Array;
      var url = "{{url('lista/produtos/selecionar/novo')}}";
      var data = {
                '_token'            : $('input[name=_token]').val(),
                'codigo'            : $('input[name=codigo]').val(),
                'grupo'             : $('input[name=grupo]').val(),
                'tipo'              : $('input[name=tipo]').val(),
                'nome'              : $('input[name=nome]').val(),
                'unidade'           : $('select[name=unidade]').val(),
                'custo'             : $('input[name=custo]').val(),
                'campo_nome'        : campo_nome,
                'campo_valor'       : campo_valor
            };
      $("#contatosHolder").html("");
      $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function( data ) {
          $("#contatosHolder").html("");
          var url = "{{url('lista/produtos/selecionar')}}";
          var data = {
                    'busca'              : '',
                    '_token'            : $('input[name=_token]').val()
                };
          $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function( data ) {
              $("#contatosHolder").html(data);
            }
          });
        }
      });
}

  </script>
  <script id="ToClone" type="text/template">
  <span>
    <div class="3397 col-md-9" id="a">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="col-md-3">
            <div class="form-group">
              <label for="text" id="numeroText">Nome do campo</label>
              <input type="text" class="form-control" value="" name="campo_nome" id="campo_nome">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="text">Valor do campo</label>
              <input type="text" class="form-control" value="" name="campo_valor" id="campo_valor">
            </div>
          </div>
        </div>
      </div>
    </div>
  </span>
  </script>
