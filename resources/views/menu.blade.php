<b-navbar toggleable type="light" variant="light" toggleable sticky="true">

  <b-nav-toggle label=" oi" target="nav_collapse"></b-nav-toggle>

  <b-link class="navbar-brand" to="/">
    <span>@{{erpDono}}</span>
  </b-link>

  <b-collapse is-nav id="nav_collapse">

    <b-nav is-nav-bar>

      {{-- <b-nav-item v-if="menus.admin" :href="base_url + 'admin'">Administrator</b-nav-item> --}}

      <b-nav is-nav-bar>
        <b-nav-item-dropdown v-if='index!="edicao"' :text="index | capitalize"v-for='(menu,index) in menus' left-alignment :key="menu.index">
          <b-dropdown-item v-for="(acao, index2) in menu" :to="'/' + acao"  :key="menu.index">@{{index2 | capitalize}}</b-dropdown-item>
        </b-nav-item-dropdown>
      </b-nav>

    </b-nav>


    <b-nav is-nav-bar class="ml-auto">

      <b-nav-item-dropdown right-alignment>

        <!-- Using text slot -->
        <template slot="text">
          <span style="font-weight: bold;">Olá, {{explode(' ', Auth::user()->contato->nome, 2)[0]}}</span>
        </template>

        <b-dropdown-item @click=""><template><span @click="deslogar">Sair</span></template></b-dropdown-item>
      </b-nav-item-dropdown>

    </b-nav>
  </b-collapse>
</b-navbar>



<div class="container-fluid">
  <router-view></router-view>
</div>

<imagens-selecionar></imagens-selecionar>
<produtos-selecionar></produtos-selecionar>
<bancos-selecionar></bancos-selecionar>
<grupos-selecionar></grupos-selecionar>
<contatos-selecionar></contatos-selecionar>
<nfentrada-detalhes></nfentrada-detalhes>
<contatos-detalhes></contatos-detalhes>
<contas-detalhes></contas-detalhes>
<vue-toastr ref="toastr"></vue-toastr>
