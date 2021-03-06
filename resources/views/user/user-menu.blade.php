
<v-navigation-drawer class="menu_principal" v-model="drawer" :clipped="$vuetify.breakpoint.lgAndUp" app dark>
    <v-list dense>
      <template>
            <v-list-item key="1" @click="" href="/">
                <v-list-item-icon>
                <v-icon large>mdi-playlist-edit</v-icon>
                </v-list-item-icon>
                <v-list-item-title class="subtitle-1">Nueva Orden</v-list-item-title>
          </v-list-item>
        <v-list-item key="2" @click="" href="{{ route('ordenes-pagar') }}">
            <v-list-item-icon>
              <v-icon large> mdi-account-cash-outline</v-icon>
            </v-list-item-icon>
            <v-list-item-title class="subtitle-1">Pagar Ordenes</v-list-item-title>
          </v-list-item>
          
          <v-list-item key="3" @click="" href="{{ route('lista-ordenes') }}">
            <v-list-item-icon>
              <v-icon large> mdi-clipboard-list-outline</v-icon>
            </v-list-item-icon>
            <v-list-item-title class="subtitle-1">Lista Ordenes</v-list-item-title>
          </v-list-item>
         
        <v-divider  dark class="my-3"></v-divider>
      </template>
    </v-list>
</v-navigation-drawer>
