<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
      Blade::directive('botaoSalvar', function () {
        return "<?php echo '<button type=\"submit\"  class=\"btn btn-success\"><i class=\"fa fa-check\"></i> Salvar</button>'; ?>";
      });
      Blade::directive('botaoLista', function ($a) {
        list($url, $icone) = explode('*', $a);
        return "<?php echo '<a class=\"btn btn-warning\" href=\"'.URL::to('lista\\$url').'\" ><i class=\"fa $icone\"></i> Voltar a Lista</a>'; ?>";
      });
      Blade::directive('buscaSimples', function () {
        return "<?php echo '
            <div class=\"input-group\">
              <input type=\"text\" class=\"form-control\" name=\"busca\" id=\"busca\" size=\"40\" placeholder=\"Busca...\">
              <span class=\"input-group-btn\">
                <button class=\"btn btn-info\" type=\"submit\"><i class=\"fa fa-search\"></i></button>
              </span>
            </div>';?>";
      });
      Blade::directive('buscaExtraBotao', function () {
        return "<?php echo '
            <a class=\"btn btn-info\"  title=\"Busca Avançada\" data-toggle=\"collapse\" data-target=\"#buscaAvançada\" aria-expanded=\"\" onclick=\"listaTop()\">
              <i class=\"fa fa-search-plus\"></i>
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
            <a id=\"botaoEditar\" href=\"\" class=\"btn btn-info btn_xs\" data-toggle=\"tooltip\" title=\"Editar\">
              <i class=\"fa fa-pencil\"></i>
            </a>'?>";
      });
      Blade::directive('botaoDetalhes', function () {
        return "<?php echo '
            <a id=\"botaoDetalhes\" class=\"btn btn-info btn_xs\" >
              </i><i class=\"fa fa-file-text\"></i>
            </a>'?>";
      });
      Blade::directive('botaoAnexos', function () {
        return "<?php echo '
            <span id=\"botaoAnexos\" class=\"btn btn-warning btn_xs\" title=\"Anexos\">
              <i class=\"fa fa-paperclip\"></i>
            </span>'?>";
      });
      Blade::directive('idSelecionado', function () {
        return "<?php echo '<input type=\"text\" class=\"form-control\" size=\"2\" name=\"ids\" id=\"ids\" placeholder=\"\" disabled>'?>";
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
                <input type=\"hidden\" class=\"form-control\" id=\"contatosHidden\" name=\"filial\" value=\"'.$id.'\">
                <input type=\"text\" class=\"form-control\" id=\"contatos\" disabled value=\"'.$nome.'\">
                <a onclick=\"window.activeTarget=&#39;contatos&#39;&#59; openModal(&#39;'.URL::to('lista/filiais/selecionar').'&#39;)\" class=\"input-group-addon btn btn-info\"><i class=\"fa fa-gear\"></i></a>
              </div>
            </div>'?>";
          } else {
            return "<?php echo '
              <div class=\"form-group\">
                <label for=\"por\">Filial:</label>
                <div class=\"input-group\">
                  <input type=\"hidden\" class=\"form-control\" id=\"contatosHidden\" name=\"contatos_id\" value=\"\">
                  <input type=\"text\" class=\"form-control\" id=\"contatos\" disabled value=\"\">
                  <a onclick=\"window.activeTarget=&#39;contatos&#39;&#59; openModal(&#39;'.URL::to('lista/filiais/selecionar').'&#39;)\" class=\"input-group-addon btn btn-info\"><i class=\"fa fa-gear\"></i></a>
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
