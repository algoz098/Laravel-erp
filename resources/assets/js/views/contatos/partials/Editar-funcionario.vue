<template>
<div>
  <div class="row">

    <div class="col-3">
      <b-card header="Informações basicas">

        <selecionar-filial :nome="filial" @retornado_filial="retornado_filial" />

        <input-texto v-model="funcionario.cargo" titulo="Cargo" />

        <input-mascara v-model="funcionario.data_adm" mascara="##/##/##" titulo="Data de Admissão" />

        <input-mascara v-model="funcionario.data_dem" mascara="##/##/##" titulo="Data de Demissão" />

      </b-card>
    </div>
    <div class="col-6">
      <b-card header="Pagamentos e salario">
        <div class="row">
          <div class="col-md-6">

            <input-dinheiro v-model="funcionario.sal" titulo="Salario Base" />

            <input-dinheiro v-model="funcionario.sal_real" titulo="Salario Real" />

            <div class="row">

              <div class="col-8">
                <input-dinheiro v-model="funcionario.vt" titulo="Vale Transporte" readonly="true" />
              </div>
              <div class="col-4">
                <input-percentual v-model="funcionario.vt_percentual" titulo="VT. Percentual" />
              </div>
              <!-- Passei um dia inteiro para fazer o computed funcionar, e so resolvi quando do print no computed.
              Então foda-se, ta certo, ta funcionando.
              -artur  -->
              <span style="display: none">{{calcula_vt}}</span>
            </div>

          </div>
          <div class="col-6">

            <input-dinheiro v-model="funcionario.va" titulo="Vale Alimentação" />

            <input-dinheiro v-model="funcionario.vr" titulo="Vale Refeição" />

            <div class="row">

              <div class="col-8">
                <input-dinheiro v-model="funcionario.peri" titulo="Periculosidade" readonly="true" />
              </div>
              <div class="col-4">
                <input-percentual v-model="funcionario.peri_percentual" titulo="P. Percentual" />
              </div>
              <!-- Passei um dia inteiro para fazer o computed funcionar, e so resolvi quando do print no computed.
              Então foda-se, ta certo, ta funcionando.
              -artur  -->
              <span style="display: none">{{calcula_peri}}</span>

            </div>
          </div>
        </div>

      </b-card>
    </div>
    <div class="col-3">
      <b-card header="Acesso ao sistema">

        <switch-erp label="Habilitar acesso?" :value="user.ativo" @change="ativo_mudar" />

        <input-texto v-model="user.email" titulo="Usuario" />

        <input-texto v-model="user.password" type="password" titulo="Senha" />

      </b-card>
    </div>

  </div>
  <br>
  <div class="row">

    <div class="col-3">
      <b-card header="Dados do colaborador">

        <input-mascara v-model="funcionario.cart_trab_num" mascara="###############" titulo="Numero da Cart. Trab." />

        <input-mascara v-model="funcionario.cart_trab_serie" mascara="###############" titulo="Serie da Cart. Trab." />

        <input-mascara v-model="funcionario.pis" mascara="###############" titulo="Serie da Cart. Trab." />

        <input-texto v-model="funcionario.pis_banco" titulo="Banco do PIS" />

        <div class="row">

          <div class="col-8">
            <input-dinheiro v-model="funcionario.inss" titulo="INSS" readonly="true" />
          </div>
          <div class="col-4">
            <input-percentual v-model="funcionario.sal_inss" titulo="Percentual" />
          </div>
          <!-- Passei um dia inteiro para fazer o computed funcionar, e so resolvi quando do print no computed.
          Então foda-se, ta certo, ta funcionando.
          -artur  -->
          <span style="display: none">{{calcula_inss}}</span>

        </div>

      </b-card>
    </div>

    <div class="col-3">
      <b-card header="Referente a CNH">

        <input-mascara v-model="funcionario.cnh" mascara="###############" titulo="Numero da CNH" />

        <input-mascara v-model="funcionario.cnh_cat" mascara="###############" titulo="Categoria da CNH" />

        <input-mascara v-model="funcionario.cnh_venc" mascara="###############" titulo="Vencimento da CNH." />

      </b-card>
    </div>

    <div class="col-3">
      <b-card header="Referente ao cidadão">

        <input-mascara v-model="funcionario.eleitor" mascara="###############" titulo="Numero do eleitor" />

        <input-mascara v-model="funcionario.eleitor_sessao" mascara="###############" titulo="Sessão do eleitor" />

        <input-mascara v-model="funcionario.eleitor_zona" mascara="###############" titulo="Zona do eleitor" />

        <input-mascara v-model="funcionario.eleitor_exp" mascara="##/##/##" titulo="Data de Exp. de eleitor" />

        <input-mascara v-model="funcionario.reservista" mascara="###############" titulo="Numero de reservista" />

      </b-card>
    </div>

    <div class="col-3">
      <b-card header="Referente ao R.G.">

        <input-mascara v-model="contato.rg" mascara="##.###.###-##" titulo="Numero do R.G." readonly="true" />

        <input-mascara v-model="funcionario.rg_exp" mascara="##/##/##" titulo="Data de Exp. do RG" />

        <input-texto v-model="funcionario.rg_mae" titulo="Nome da Mãe" />

        <input-texto v-model="funcionario.rg_pai" titulo="Nome do Pai" />

      </b-card>
    </div>

  </div>

</div>
</template>

<script>
    export default {
      props: {
        contato: {type: Object},
      },
      data(){
        return {
          filial: '',
          user:{
            ativo: true,
            user: '',
            password: ''
          },
          funcionario: {
            ativo: true,
            cargo: '',
            data_adm: '',
            data_dem: '',
            sal: '0',
            sal_real: '',
            vt: '0',
            vt_percentual: '0',
            peri: '0',
            peri_percentual: '0',
            vr: '0',
            inss: '0',
            sal_inss: '0',
            cart_trab_num: '0',
            cart_trab_serie: '0',
            pis: '0',
            pis_banco: '0',
            cnh: '',
            cnh_cat: '',
            cnh_venc: '',
            eleitor: '',
            eleitor_sessao: '',
            eleitor_zona: '',
            eleitor_exp: '',
            reservista: '',
            rg_exp: '',
            rg_mae: '',
            rg_pai: '',
          }
        }
      },
      created(){
        if (this.$route.name == "contato_editar"){
          // Setando objeto local de data para funcionario
          this.filial = this.contato.user.trabalho.nome + ' (' + this.contato.user.trabalho.sobrenome + ')';
          this.funcionario.cargo = this.contato.funcionario.cargo;
          this.funcionario.data_adm = this.contato.funcionario.data_adm;
          this.funcionario.data_dem = this.contato.funcionario.data_dem;
          this.funcionario.sal = this.contato.funcionario.sal;
          if (this.contato.funcionario.sal_real==null){
            this.funcionario.sal_real = '';
          } else {
            this.funcionario.sal_real = this.contato.funcionario.sal_real;
          }
          this.funcionario.vt = this.contato.funcionario.vt;
          this.funcionario.vt_percentual = this.contato.funcionario.vt_percentual;
          this.funcionario.peri = this.contato.funcionario.peri;
          this.funcionario.peri_percentual = this.contato.funcionario.peri_percentual;
          this.funcionario.vr = this.contato.funcionario.vr;
          this.funcionario.inss = this.contato.funcionario.inss;
          this.funcionario.sal_inss = this.contato.funcionario.sal_inss;
          this.funcionario.cart_trab_num = this.contato.funcionario.cart_trab_num;
          this.funcionario.cart_trab_serie = this.contato.funcionario.cart_trab_serie;
          this.funcionario.pis = this.contato.funcionario.pis;
          this.funcionario.pis_banco = this.contato.funcionario.pis_banco;
          this.funcionario.cnh = this.contato.funcionario.cnh;
          this.funcionario.cnh_cat = this.contato.funcionario.cnh_cat;
          this.funcionario.cnh_venc = this.contato.funcionario.cnh_venc;
          this.funcionario.eleitor = this.contato.funcionario.eleitor;
          this.funcionario.eleitor_sessao = this.contato.funcionario.eleitor_sessao;
          this.funcionario.eleitor_zona = this.contato.funcionario.eleitor_zona;
          this.funcionario.eleitor_exp = this.contato.funcionario.eleitor_exp;
          this.funcionario.reservista = this.contato.funcionario.reservista;
          this.funcionario.rg_exp = this.contato.funcionario.rg_exp;
          this.funcionario.rg_mae = this.contato.funcionario.rg_mae;
          this.funcionario.rg_pai = this.contato.funcionario.rg_pai;
          this.funcionario.trabalho_id = this.contato.user.trabalho_id;

          // Setando objeto local de data para user
          this.user.email = this.contato.user.email;
          if(this.contato.user.ativo=="0" || this.contato.user.ativo==false){
            this.user.ativo = false;
          }
          else{
            this.user.ativo = true;
          }
        }

        this.contato.funcionario = this.funcionario;
        this.contato.user = this.user;
      },
      computed: {
        calcula_vt(){
          if(this.funcionario.sal_real.search(',')){
            var salario = parseFloat(this.funcionario.sal_real.replace(',', ''));
          } else {
            var salario = parseFloat(this.funcionario.sal_real);
          }
          this.funcionario.vt = salario * (parseInt(this.funcionario.vt_percentual) / 100);
          return this.funcionario.vt;
        },
        calcula_peri(){
          if(this.funcionario.sal_real.search(',')){
            var salario = parseFloat(this.funcionario.sal_real.replace(',', ''));
          } else {
            var salario = parseFloat(this.funcionario.sal_real);
          }
          this.funcionario.peri = salario * (parseInt(this.funcionario.peri_percentual) / 100);
          return this.funcionario.peri;
        },
        calcula_inss(){
          if(this.funcionario.sal_real.search(',')){
            var salario = parseFloat(this.funcionario.sal_real.replace(',', ''));
          } else {
            var salario = parseFloat(this.funcionario.sal_real);
          }
          this.funcionario.inss = salario * (parseInt(this.funcionario.sal_inss) / 100);
          return this.funcionario.inss;
        }
      },
      methods: {
        retornado_filial(a){
          this.contato.funcionario.trabalho_id = a.id;
        },
        ativo_mudar(e){
          this.user.ativo = e.value;
        },
      }
    }
</script>
