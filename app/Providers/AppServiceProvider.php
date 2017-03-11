<?php

namespace App\Providers;

use App\Contatos;
use App\Atendimento;
use App\Bancos;
use App\Caixas;
use App\Estoque;
use App\Frotas;
use App\Vendas;
use App\Contas;
use App\Observers\ContatosObserver;
use App\Observers\AtendimentosObserver;
use App\Observers\BancosObserver;
use App\Observers\CaixasObserver;
use App\Observers\EstoqueObserver;
use App\Observers\FrotasObserver;
use App\Observers\VendasObserver;
use App\Observers\ContasObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

Use Auth;
use App\Erp_configs as Configs;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Contatos::observe(ContatosObserver::class);
      Atendimento::observe(AtendimentosObserver::class);
      Bancos::observe(BancosObserver::class);
      Caixas::observe(CaixasObserver::class);
      Estoque::observe(EstoqueObserver::class);
      Frotas::observe(FrotasObserver::class);
      Vendas::observe(VendasObserver::class);
      Contas::observe(ContasObserver::class);

      Blade::directive('botaoSimNao', function ($a) {
        list($nome, $subnome, $valor) = explode('*', $a);
        if ($valor==1){
          return "<?php echo '
          <div class=\"btn-group\" data-toggle=\"buttons\">
            <label class=\"btn btn-success btn-xs active\">
              <input type=\"radio\" name=\"$nome&#91;$subnome&#93;\" value=\"1\" id=\"$nome.$subnome.Sim\" autocomplete=\"off\" checked> Sim
            </label>
            <label class=\"btn btn-danger btn-xs \">
              <input type=\"radio\" name=\"$nome&#91;$subnome&#93;\" value=\"0\" id=\"$nome.$subnome\" autocomplete=\"off\"> Não
            </label>
          </div>
          '; ?>";
        } else {
          return "<?php echo '
          <div class=\"btn-group\" data-toggle=\"buttons\">
            <label class=\"btn btn-success btn-xs \">
              <input type=\"radio\" name=\"$nome&#91;$subnome&#93;\" value=\"1\" id=\"$nome.$subnome.Sim\" autocomplete=\"off\" > Sim
            </label>
            <label class=\"btn btn-danger btn-xs active\">
              <input type=\"radio\" name=\"$nome&#91;$subnome&#93;\" value=\"0\" id=\"$nome.$subnome\" autocomplete=\"off\" checked> Não
            </label>
          </div>
          '; ?>";
        }

      });



      Blade::directive('botaoSalvar', function () {
        return "<?php echo '<button type=\"submit\"  class=\"btn btn-success\"><i class=\"fa fa-check\"></i> Salvar</button>'; ?>";
      });
      Blade::directive('botaoSalvarModal', function () {
        return "<?php echo '<button type=\"button\" onclick=\"enviarModal()\"  class=\"btn btn-success\"><i class=\"fa fa-check\"></i> Salvar</button>'; ?>";
      });
      Blade::directive('botaoLista', function ($a) {
        list($url, $icone) = explode('*', $a);
        return "<?php echo '<a class=\"btn btn-warning\" href=\"'.URL::to('lista\\$url').'\" ><i class=\"fa $icone\"></i> Voltar a Lista</a>'; ?>";
      });
      Blade::directive('buscaSimples', function ($url) {
        return "<?php echo '
            <div class=\"input-group\">
              <input type=\"text\" class=\"form-control\" name=\"busca\" id=\"busca\"   data-toggle=\"tooltip\" title=\"Busca\" size=\"40\" placeholder=\"Busca...\">
              <span class=\"input-group-btn\">
                <button   data-toggle=\"tooltip\" title=\"Efetuar busca\" class=\"btn btn-info\" type=\"submit\" onclick=\"efetuarBusca(&#39;'.URL::to('$url').'&#39;)\"><i class=\"fa fa-search\"></i></button>
              </span>
            </div>';?>";
      });
      Blade::directive('buscaModal', function ($a) {
        return "<?php echo '
            <div class=\"input-group\">
              <input type=\"text\" class=\"form-control\" name=\"busca\" id=\"busca_modal\" size=\"40\" placeholder=\"Busca...\">
              <span class=\"input-group-btn\">
                <button class=\"btn btn-info\" type=\"button\" onclick=\"$a\"><i class=\"fa fa-search\"></i></button>
              </span>
            </div>';?>";
      });

      Blade::directive('buscaExtraBotao', function () {
        return "<?php echo '
            <a class=\"btn btn-info\"   data-toggle=\"collapse\" title=\"Busca Avançada\" data-toggle=\"collapse\" data-target=\"#buscaAvançada\" aria-expanded=\"\" onclick=\"listaTop()\">
            <span data-toggle=\"tooltip\" title=\"Mostrar busca avançada\" >
                <i class=\"fa fa-search-plus\"></i>
              </span>
            </a>'?>";
      });
      Blade::directive('botaoDelete', function () {
        return "<?php echo '
            <a id=\"botaoDelete\" href=\"\" class=\"btn btn-danger btn_xs \" data-toggle=\"tooltip\" title=\"Deletar\">
              <i class=\"fa fa-ban\" ></i>
            </a>'?>";
      });
      Blade::directive('botaoEditar', function () {
        return "<?php echo '
            <a id=\"botaoEditar\" href=\"\" class=\"btn btn-info \" data-toggle=\"tooltip\" title=\"Editar\">
              <i class=\"fa fa-pencil\"></i>
            </a>'?>";
      });
      Blade::directive('botaoDetalhes', function () {
        return "<?php echo '
            <a id=\"botaoDetalhes\" class=\"btn btn-info \" data-toggle=\"tooltip\" title=\"Detalhes\">
              </i><i class=\"fa fa-file-text\"></i>
            </a>'?>";
      });
      Blade::directive('botaoAnexos', function () {
        return "<?php echo '
            <span id=\"botaoAnexos\" class=\"btn btn-warning \"  data-toggle=\"tooltip\" title=\"Anexos\">
              <i class=\"fa fa-paperclip\"></i>
            </span>'?>";
      });
      Blade::directive('idSelecionado', function () {
        return "<?php echo '<input type=\"text\" class=\"form-control\" size=\"2\" name=\"ids\" id=\"ids\"   data-toggle=\"tooltip\" title=\"ID Selecionado\" placeholder=\"\" disabled>'?>";
      });
      Blade::directive('botaoNovo', function ($a) {
        if (strpos($a, '*')){
          list($botao1, $botao2, $texto1, $texto2) = explode('*', $a);
        }
        if (isset($texto2)){
          return "<?php echo '
            <div class=\"btn-group\">
              <a href=\"'.URL::to('novo\\$botao1').'\" class=\"btn btn-success\">
                <i class=\"fa fa-plus fa-1x\"></i> Novo
              </a>
              <button type=\"button\" class=\"btn btn-success dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                <span class=\"caret\"></span>
                <span class=\"sr-only\">Toggle Dropdown</span>
              </button>
              <ul class=\"dropdown-menu\">
                <li><a href=\"'.URL::to('novo\\$botao1').'\">$texto1</a></li>
                <li><a href=\"'.URL::to('novo\\$botao2').'\">$texto2</a></li>
              </ul>
            </div>
          '; ?>";
        } else {
          return "<?php echo '
          <a href=\"'.URL::to('novo\\$a').'\" class=\"btn btn-success\">
            <i class=\"fa fa-plus fa-1x\"></i> Novo</a>
          '; ?>";
        }
      });

      Blade::directive('mostraContato', function ($a) {
        list($id, $nome) = explode('*', $a);
        return "<?php echo '
          <a onclick=\"openModal(&#39;'.URL::to('lista/contatos').'/'.$id.'&#39;)\" class=\"label label-primary\">
            <i class=\"fa fa-user\"></i> '.$nome.'
          </a>
        '?>";
      });

      Blade::directive('selecionaContato', function ($a) {
        if (strpos($a, '*')){
          list($label, $id, $nome) = explode('*', $a);
          return "<?php echo '
            <div class=\"form-group\">
              <label for=\"por\">$label</label>
              <div class=\"input-group\">
                <input type=\"hidden\" class=\"form-control\" id=\"contatosHidden\" name=\"contatos_id\" value=\"'.$id.'\">
                <input type=\"text\" class=\"form-control\" id=\"contatos\" disabled value=\"'.$nome.'\">
                <a onclick=\"window.activeTarget=&#39;contatos&#39;&#59; openModal(&#39;'.URL::to('lista/contatos/selecionar').'&#39;)\" class=\"input-group-addon btn btn-info\"><i class=\"fa fa-gear\"></i></a>
              </div>
            </div>'?>";
          } else {
            return "<?php echo '
              <div class=\"form-group\">
                <label for=\"por\">$a</label>
                <div class=\"input-group\">
                  <input type=\"hidden\" class=\"form-control\" id=\"contatosHidden\" name=\"contatos_id\" value=\"\">
                  <input type=\"text\" class=\"form-control\" id=\"contatos\" disabled value=\"\">
                  <a onclick=\"window.activeTarget=&#39;contatos&#39;&#59; openModal(&#39;'.URL::to('lista/contatos/selecionar').'&#39;)\" class=\"input-group-addon btn btn-info\"><i class=\"fa fa-gear\"></i></a>
                </div>
              </div>
            '?>";
          }
      });
      Blade::directive('selecionaFilial', function ($a) {
        if (strpos($a, '*')){
          list($id, $nome) = explode('*', $a);
          return "<?php echo '
            <div class=\"form-group\">
              <label for=\"por\">Filial</label>
              <div class=\"input-group\">
                <input type=\"hidden\" class=\"form-control\" id=\"filiaisHidden\" name=\"filiais_id\" value=\"'.$id.'\">
                <input type=\"text\" class=\"form-control\" id=\"filiais\" disabled value=\"'.$nome.'\">
                <a onclick=\"window.activeTarget=&#39;filiais&#39;&#59; openModal(&#39;'.URL::to('lista/filiais/selecionar').'&#39;)\" class=\"input-group-addon btn btn-info\"><i class=\"fa fa-gear\"></i></a>
              </div>
            </div>'?>";
          } else {
            return "<?php echo '
              <div class=\"form-group\">
                <label for=\"por\">Filial:</label>
                <div class=\"input-group\">
                  <input type=\"hidden\" class=\"form-control\" id=\"filiaisHidden\" name=\"filiais_id\" value=\"\">
                  <input type=\"text\" class=\"form-control\" id=\"filiais\" disabled value=\"\">
                  <a onclick=\"window.activeTarget=&#39;filiais&#39;&#59; openModal(&#39;'.URL::to('lista/filiais/selecionar').'&#39;)\" class=\"input-group-addon btn btn-info\"><i class=\"fa fa-gear\"></i></a>
                </div>
              </div>
            '?>";
          }
      });
      Blade::directive('selecionaBanco', function ($a) {
        if (strpos($a, '*')){
          list($id, $nome) = explode('*', $a);
          return "<?php echo '
            <div class=\"form-group\">
              <label for=\"por\">Selecionar Banco</label>
              <div class=\"input-group\">
                <input type=\"hidden\" class=\"form-control\" id=\"bancosHidden\" name=\"bancos_id\" value=\"'.$id.'\">
                <input type=\"text\" class=\"form-control\" id=\"bancos\" disabled value=\"'.$nome.'\">
                <a onclick=\"window.activeTarget=&#39;bancos&#39;&#59; openModal(&#39;'.URL::to('lista/bancos/selecionar').'&#39;)\" class=\"input-group-addon btn btn-info\"><i class=\"fa fa-gear\"></i></a>
              </div>
            </div>'?>";
          } else {
            return "<?php echo '
              <div class=\"form-group\">
                <label for=\"por\">Selecionar Banco</label>
                <div class=\"input-group\">
                  <input type=\"hidden\" class=\"form-control\" id=\"bancosHidden\" name=\"bancos_id\" value=\"\">
                  <input type=\"text\" class=\"form-control\" id=\"bancos\" disabled value=\"\">
                  <a onclick=\"window.activeTarget=&#39;bancos&#39;&#59; openModal(&#39;'.URL::to('lista/bancos/selecionar').'&#39;)\" class=\"input-group-addon btn btn-info\"><i class=\"fa fa-gear\"></i></a>
                </div>
              </div>
            '?>";
          }
      });
      Blade::directive('selecionaProduto', function ($a) {
        if (strpos($a, '*')){
          list($id, $nome) = explode('*', $a);
          return "<?php echo '
            <div class=\"form-group\">
              <label for=\"por\">Escolhe produto:</label>
              <div class=\"input-group\">
                <input type=\"hidden\" class=\"form-control\" id=\"produtosHidden\" name=\"produtos_id\" value=\"'.$id.'\">
                <input type=\"text\" class=\"form-control\" id=\"produtos\" disabled value=\"'.$nome.'\">
                <a onclick=\"window.activeTarget=&#39;produtos&#39;&#59; openModal(&#39;'.URL::to('lista/produtos/selecionar').'&#39;)\" class=\"input-group-addon btn btn-info\"><i class=\"fa fa-gear\"></i></a>
              </div>
            </div>'?>";
          } else {
            return "<?php echo '
              <div class=\"form-group\">
                <label for=\"por\">Escolher produto:</label>
                <div class=\"input-group\">
                  <input type=\"hidden\" class=\"form-control\" id=\"produtosHidden\" name=\"produtos_id\" value=\"\">
                  <input type=\"text\" class=\"form-control\" id=\"produtos\" disabled value=\"\">
                  <a onclick=\"window.activeTarget=&#39;produtos&#39;&#59; openModal(&#39;'.URL::to('lista/produtos/selecionar').'&#39;)\" class=\"input-group-addon btn btn-info\"><i class=\"fa fa-gear\"></i></a>
                </div>
              </div>
            '?>";
          }
      });
      Blade::directive('botaoEditarExtenso', function ($a) {
        list($caminho, $id) = explode('*', $a);
        return "<?php echo '
          <a href=\"'.URL::to('$caminho').'/'.$id.'\" class=\"btn btn-primary\"><i class=\"fa fa-pencil\"></i> Editar</a>
        '?>";
      });
      Blade::directive('botaoFecharModal', function () {
        return "<?php echo '
          <button type=\"button\" class=\"btn btn-warning\" data-dismiss=\"modal\">
            <i class=\"fa fa-times\"></i>
            Fechar
          </button>
        '?>";
      });

      //
      // Para formularios
      //
      Blade::directive('campoTexto', function ($a){
        list($label, $name, $value) = explode('*', $a);
        if ($value==""){
          return "<?php echo '
            <div class=\"form-group\">
              <label>$label</label>
              <input type=\"text\" class=\"form-control\" id=\"$name\" name=\"$name\"  value=\"\">
            </div>
          ';?>";
        }
        return "<?php echo '
          <div class=\"form-group\">
            <label>$label</label>
            <input type=\"text\" class=\"form-control\" id=\"$name\" name=\"$name\"  value=\"'.$value.'\">
          </div>
        ';?>";
      });
      Blade::directive('campoDinheiro', function ($a){
        list($label, $name, $value) = explode('*', $a);
        if ($value==""){
          return "<?php echo '
            <div class=\"form-group\">
              <label>".$label."</label>
              <div class=\"input-group\">
                <span class=\"input-group-addon\" id=\"campoDinheiroAddon\">R$</span>
                <input type=\"text\" class=\"form-control\" aria-describedby=\"campoDinheiroAddon\" id=\"".$name."\" name=\"".$name."\" value=\"\" >
              </div>
            </div>
          '?>";
        }
        return "<?php echo '
          <div class=\"form-group\">
            <label>".$label."</label>
            <div class=\"input-group\">
              <span class=\"input-group-addon\" id=\"campoDinheiroAddon\">R$</span>
              <input type=\"text\" class=\"form-control\" aria-describedby=\"campoDinheiroAddon\" id=\"".$name."\" name=\"".$name."\" value=\"'.$value.'\">
            </div>
          </div>
        '?>";
      });

      Blade::directive('ifPerms', function ($a) {
        list($modulo, $nivel) = explode('*', $a);
        return "<?php
          if (!isset(Auth::user()->perms[\"$modulo\"][\"$nivel\"]) or Auth::user()->perms[\"$modulo\"][\"$nivel\"]!=1){}else{
        ?>";
      });
      Blade::directive('endPerms', function () {
        return "<?php } ?>";
      });

      // Menu lateral
      Blade::directive('sidemenuItem', function ($a) {
        list($tipo, $modulo, $icone, $label) = explode('*', $a);
        return "<?php
          if (!isset(Auth::user()->perms[\"$modulo\"][\"leitura\"]) or Auth::user()->perms[\"$modulo\"][\"leitura\"]!=1){}else{
            echo '
              <li class=\"pushy-link \">
                <a class=\"\" href=\"'.URL::to('$tipo\\$modulo').'\">
                  <i class=\"fa $icone\"></i> $label
                </a>
              </li>
          ';}
        ?>";
      });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
