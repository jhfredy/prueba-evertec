
<v-navigation-drawer class="menu_principal" v-model="drawer" :clipped="$vuetify.breakpoint.lgAndUp" app dark>
    <v-list dense>
      <template>
            <v-list-item key="1" @click="" >
                <v-list-item-icon>
                <v-icon large>mdi-playlist-edit</v-icon>
                </v-list-item-icon>
                <v-list-item-title class="subtitle-1">Nueva Orden</v-list-item-title>
          </v-list-item>
        <v-list-item key="2" @click="" href="#">
            <v-list-item-icon>
              <v-icon large> mdi-clipboard-text-multiple-outline</v-icon>
            </v-list-item-icon>
            <v-list-item-title class="subtitle-1">Resumen</v-list-item-title>
          </v-list-item>
          <v-list-item key="3" @click="" href="#">
            <v-list-item-icon>
              <v-icon large> mdi-state-machine</v-icon>
            </v-list-item-icon>
            <v-list-item-title class="subtitle-1">Estado Orden</v-list-item-title>
          </v-list-item>
          <v-list-item key="4" @click="" href="#">
            <v-list-item-icon>
              <v-icon large> mdi-clipboard-list-outline</v-icon>
            </v-list-item-icon>
            <v-list-item-title class="subtitle-1">Ordenes</v-list-item-title>
          </v-list-item>
         
        <v-divider  dark class="my-3"></v-divider>
      </template>
    </v-list>
</v-navigation-drawer>
