
  <v-app-bar :clipped-left="$vuetify.breakpoint.lgAndUp" app color="white" dark>
    <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"><v-icon color="black">menu</v-icon></v-app-bar-nav-icon>
      <img class="mr-5" style="width: 174px" src="/img/logo-evertec.png"/>
    </v-toolbar-title>
  <v-spacer></v-spacer>
</v-app-bar>
<v-main>
  <v-container fluid fill-height>
    <v-layout align-center justify-center>
    </v-layout>
  </v-container>
</v-main>

