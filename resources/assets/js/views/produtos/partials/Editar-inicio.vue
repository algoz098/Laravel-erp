<template>
<div>
  <div class="row">

    <div class="col-2 flex-last">
      <b-card>
        <switch-erp label="Ativo?" :value="produto.ativo" @change="ativo_mudar" />
      </b-card>
    </div>

    <div class="col-6 offset-md-3">

      <b-card>

        <div class="row">

          <div class="col-6">
            <input-texto v-model="produto.nome" titulo="Codigo" />
          </div>

        </div>
        <div class="row">

          <div class="col-6">
            <selecionar-grupo :nome="produto.tipo_nome" @retornado_grupo="retornado_grupo" id="grupo_id" />
          </div>

        </div>
        <div class="row">

          <div class="col-6">
            <selecionar-contato id="fabricantes_id" titulo="Selecionar fabricante" :erros="produto.errors.errors.fabricante" :nome="produto.fabricante.nome" @retornado_contato="retornado_fabricante" />
          </div>

        </div>
        <div class="row">

          <div class="col-8">
            <input-texto v-model="produto.barras" titulo="Codigo de barras" />
          </div>

        </div>
        <div class="row">

          <div class="col-8">
            <input-texto v-model="produto.aplicacao" titulo="Aplicação:" />
          </div>

        </div>
        <div class="row">

          <div class="col-6">
            <input-texto v-model="produto.armazenagem" titulo="Local de armazenagem:" />
          </div>

        </div>

      </b-card>

    </div>

  </div>

  <br>

  <div class="row">

    <div class="col-6 offset-md-3">
      <b-card>

        <div class="row">

          <div class="col-4">
            <selecionar-busca v-model="produto.embalagem" titulo="Embalagem:" :erros="produto.errors.errors.embalagem" :options="opcoes.embalagem" v-if="edicao==false" />
          </div>

          <div class="col-4">
            <input-texto v-model="produto.peso" titulo="Peso:" />
          </div>

          <div class="col-4">
            <selecionar-busca v-model="produto.medida" titulo="Uni. medida:" :erros="produto.errors.errors.medida" :options="opcoes.medida" v-if="edicao==false" />
          </div>

        </div>

      </b-card>
    </div>

  </div>

  <br>

  <div class="row">

    <div class="col-6 offset-md-3">
      <b-card>

        <div class="row">

          <div class="col-4">
            <input-dinheiro v-model="produto.valor" titulo="Valor de custo:" />
          </div>

          <div class="col-4">
            <input-percentual v-model="produto.margem" titulo="Margem:" />
          </div>

          <div class="col-4">
            <input-dinheiro v-model="produto.venda" titulo="Valor de venda:" />
          </div>

        </div>

      </b-card>
    </div>

  </div>

  <br>

  <div class="row">

    <div class="col-6 offset-md-3">
      <b-card>

        <div class="row">

          <div class="col-4">
            <input-texto v-model="produto.minimo" titulo="Estoque minimo:" />
          </div>

        </div>
        <div class="row">

          <div class="col-4">
            <input-texto v-model="produto.maximo" titulo="Estoque maximo:" />
          </div>

        </div>

      </b-card>
    </div>

  </div>

  <br>

  <div class="row">

    <div class="col-6 offset-md-3">

      <carta zIndex="499" top="136">

        <template slot="header" >

          <div class="row">

             <div class="col-9">
               Produtos semelhantes internos
             </div>

             <div class="col-3 flex-last text-right">
               <button type="button" class="btn btn-success btn-sm" @click="adicionar_semelhante_interno"><icone icon="plus" /></button>
               <button type="button" class="btn btn-danger btn-sm" @click="remover_semelhante_interno"><icone icon="minus" /></button>
             </div>

          </div>

        </template>

        <div v-for="(interno, index) in produto.semelhantes_to" key="externo">
          <b-card variant="outline-info" >
            <div class="row">

              <div class="col-1" v-if="interno.id">
                <div class="form-group">

                  <label for="">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                  <br>

                  <button type="button" class="btn btn-danger btn-sm" @click="apagar_interno_to(interno.id, index)">
                    <icone icon="ban" />
                  </button>

                </div>
              </div>

              <div class="col-4">
                <selecionar-produto titulo="Selecionar semelhante:" :nome="interno.nome" @retornado="retornado_produto(index, $event)" :id="'produto_id' + index" />
              </div>

            </div>
          </b-card>
          <br>

        </div>


      </carta>

    </div>

  </div>

  <br>

  <div class="row" v-if="produto.id">

    <div class="col-6 offset-md-3">

      <carta zIndex="499" top="136">

        <template slot="header" >

          <div class="row">

             <div class="col-9">
               Produtos que são semelhantes a este
             </div>

          </div>

        </template>

        <div v-for="(interno, index) in produto.semelhantes_from" key="externo">
          <b-card variant="outline-info" >
            <div class="row">

              <div class="col-4">
                <input-texto disabled=true titulo="Produto semelhante a este:" v-model="interno.nome" />
              </div>

            </div>
          </b-card>
          <br>

        </div>

      </carta>

    </div>

  </div>

  <br>

  <div class="row">

    <div class="col-6 offset-md-3">

      <carta zIndex="499" top="136">

        <template slot="header" >

          <div class="row">

             <div class="col-9">
               Produtos semelhantes externos
             </div>

             <div class="col-3 flex-last text-right">
               <button type="button" class="btn btn-success btn-sm" @click="adicionar_semelhante_externo"><icone icon="plus" /></button>
               <button type="button" class="btn btn-danger btn-sm" @click="remover_semelhante_externo"><icone icon="minus" /></button>
             </div>

          </div>

        </template>

        <div v-for="(externo, index) in produto.externos" key="externo">
          <b-card variant="outline-info" >
            <div class="row">

              <div class="col-1" v-if="externo.id">
                <div class="form-group">

                  <label for="">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                  <br>

                  <button type="button" class="btn btn-danger btn-sm" @click="apagar_externo(index)">
                    <icone icon="ban" />
                  </button>

                </div>
              </div>

              <div class="col-3">
                <input-texto v-model="externo.codigo" titulo="Codigo:" />
              </div>

              <div class="col-4">
                <input-texto v-model="externo.nome" titulo="Nome:" />
              </div>

              <div class="col-4">
                <input-texto v-model="externo.origem" titulo="Origem:" />
              </div>

            </div>
          </b-card>
          <br>

        </div>

      </carta>

    </div>

  </div>

  <br>

  <div class="row">

    <div class="col-6 offset-md-3">
      <carta zIndex="499" top="136">

        <template slot="header" >

          <div class="row">

             <div class="col-9">
               Campos extras do produto
             </div>

             <div class="col-3 flex-last text-right">
               <button type="button" class="btn btn-success btn-sm" @click="adicionar_campo_extra"><icone icon="plus" /></button>
               <button type="button" class="btn btn-danger btn-sm" @click="remover_campo_extra"><icone icon="minus" /></button>
             </div>

          </div>

        </template>

        <div v-for="(campo, index) in produto.campos" key="externo">
          <b-card variant="outline-info" >
            <div class="row">

              <div class="col-1" v-if="campo.id">
                <div class="form-group">

                  <label for="">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                  <br>

                  <button type="button" class="btn btn-danger btn-sm" @click="apagar_campo(index)">
                    <icone icon="ban" />
                  </button>

                </div>
              </div>

              <div class="col-4 offset-md-1">
                <input-texto v-model="campo.nome" titulo="Nome do campo:" />
              </div>

              <div class="col-4">
                <input-texto v-model="campo.valor" titulo="Valor do campo:" />
              </div>

            </div>
          </b-card>
          <br>

        </div>

      </carta>

    </div>

  </div>

</div>
</template>

<script>
import VueSticky from 'vue-sticky';

    export default {
      directives:{
        'sticky': VueSticky,
      },
      props: {
        produto: {type: Object},
      },
      data(){
        return {
          false: true,
          edicao: false,
          opcoes: {
            embalagem: [
              {value: '', label: '- Escolha - '},
            ],
            medida: [
              {value: '', label: '- Escolha - '},
            ],
          }

        }
      },
      created(){

      },
      methods: {
        adicionar_semelhante_externo(){
          this.produto.externos.push({codigo: '', nome: '', origem: ''});
        },
        adicionar_semelhante_interno(){
          this.produto.semelhantes_to.push({produtos_id: '', nome: ''});
        },
        remover_semelhante_externo(){
          if (this.produto.externos[this.produto.externos.length - 1].id == null) {
            this.produto.externos.splice(-1, 1);
          } else {
            this.$root.$refs.toastr.w("Use o botão apagar para remover o semelhante externo", "Erro");
          }
        },
        remover_semelhante_interno(){
          this.produto.semelhantes_to.splice(-1, 1);
        },
        adicionar_campo_extra(){
          this.produto.campos.push({nome: '', valor: ''});
        },
        remover_campo_extra(){
          if (this.produto.campos[this.produto.campos.length - 1].id == null) {
            this.produto.campos.splice(-1, 1);
          } else {
            this.$root.$refs.toastr.w("Use o botão apagar para remover o campo extra", "Erro");
          }
        },
        ativo_mudar(e){
          this.produto.ativo = e.value;
        },
        retornado_fabricante(a){
          this.produto.fabricante.nome = a.nome;
          this.produto.fabricante_id = a.id;
        },
        retornado_filial(a){
          this.produto.filial.nome = a.nome;
          this.produto.filial_id = a.id;
        },
        retornado_grupo(a){
          this.produto.tipo_nome = a.nome;
          this.produto.produtos_tipo_id = a.id;
        },
        retornado_produto(a, b){
          this.produto.semelhantes_to[a].nome = b.nome;
          this.produto.semelhantes_to[a].produtos_id = b.id;
        },
        apagar_externo(index){
          var self = this;
          axios.get(base_url + 'lista/produtos/' + self.produto.id + '/externo/' + self.produto.externos[index].id + '/delete')
            .then(function(response){
              self.produto.externos.splice(index, 1);
              self.$root.$refs.toastr.i("Removido produto externo", "Aviso");
            })
        },
        apagar_interno_from(id, index){
          var self = this;

          self.produto.semelhantes_from.splice(index, 1);
          self.$root.$refs.toastr.i("Semelhante interno: sera removido quando for salvo", "Aviso");
        },
        apagar_interno_to(id, index){
          var self = this;

          self.produto.semelhantes_to.splice(index, 1);
          self.$root.$refs.toastr.i("Semelhante interno: sera removido quando for salvo", "Aviso");
        },
        apagar_campo(index){
          var self = this;
          axios.get(base_url + 'lista/produtos/' + self.produto.id + '/campo/' + self.produto.campos[index].id + '/delete')
            .then(function(response){
              self.produto.campos.splice(index, 1);
              self.$root.$refs.toastr.i("Removido campo extra", "Aviso");
            })
        },
        onInput(value) {
          this.$emit('input', value);
        }
      }
    }
</script>
