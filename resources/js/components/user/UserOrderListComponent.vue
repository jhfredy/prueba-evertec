<template>
  <div style="width: 100%">
    <v-toolbar class="mb-2" color="#fafafa" light flat>
      <v-toolbar-title class="black--text">
        <v-avatar color="primary" class="mr-5">
          <v-icon large dark>mdi-clipboard-list-outline</v-icon>
        </v-avatar>Ordenes
      </v-toolbar-title>
    </v-toolbar>
    <v-divider color="#0054a5" style="border: 1px dashed #fafafa"></v-divider>

    <v-card class="mx-auto">
      <v-row>
        <v-col cols="12">
          <v-toolbar color light flat>
            <v-toolbar-title class="black--text text-uppercase">Lista Ordenes</v-toolbar-title>
          </v-toolbar>
          
  <!-- busqueda de la orden -->
          <v-container>
            <v-card class="mx-auto" elevation="0">
              <v-row>
                <v-col cols="5">
                  <v-text-field
                    dense
                    v-model="search"
                    outlined
                    flat
                    label="Buscar..."
                    rounded
                    autofocus
                    class="mt-3"
                    clearable
                  >
                    <template v-slot:prepend>
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                          <v-icon color="primary" v-on="on">mdi-help-circle</v-icon>
                        </template>
                        Buscar Orden
                      </v-tooltip>
                    </template>
                  </v-text-field>
                </v-col>
              </v-row>
              <!-- tabla de ordenes -->
              <v-row class="mt-2">
                <v-col cols="12" sm="12" md="12">
                  <v-data-table
                    :headers="cabecera_ordenes"
                    :items="arrayOrdenes"
                    :search="search"
                    sort-by="calories"
                    class="elevation-0"
                    hide-default-footer
                    dense
                  >
                    <template v-slot:item.estado="{item}">
                    
                       <p class="mt-2" v-if="item.status=='CREATED'">CREADO</p>
                    <p class="mt-2" v-if="item.status=='PAYED'">PAGADO</p>
                    <p class="mt-2" v-if="item.status=='REJECTED'">RECHAZADO</p>
                    </template>
                    <template v-slot:item.action="{item}">
                      <v-row>
                        <template>
                          <v-tooltip top>
                            <template v-slot:activator="{ on, attrs }">
                              <v-col cols="6" sm="3">
                                <v-btn
                                  @click="abrirDialogVer(item)"
                                  v-bind="attrs"
                                  v-on="on"
                                  class="mx-2"
                                  fab
                                  dark
                                  dense
                                  x-small
                                  color="indigo darken-4"
                                >
                                  <v-icon dark>mdi-eye</v-icon>
                                </v-btn>
                              </v-col>
                            </template>
                            <span>Ver</span>
                          </v-tooltip>
                        </template>
                      </v-row>
                    </template>
                  </v-data-table>
                </v-col>
              </v-row>
            </v-card>
          </v-container>
        </v-col>
      </v-row>
    </v-card>
    <!-- vista para ver la informacion de la orden  -->
    <v-dialog v-model="dialogEnviar" persistent max-width="950">
      <v-card style="border-left: 5px solid #1A237E ;">
        <v-card-title class="font-weight-bold"></v-card-title>

        <v-card-text class="mb-0 mt-3">
          <v-alert
            color="primary"
            dark
            icon="mdi-progress-check"
            border="left"
            prominent
            class="display-1 mb-0"
          >Detalle de la Orden</v-alert>
        </v-card-text>
        <v-simple-table dense>
          <template v-slot:default>
            <thead></thead>
            <tbody>
              <tr>
                <td colspan="2" class="font-weight-bold">Nombre</td>
                <td colspan="2">{{model.customer_name}}</td>
              </tr>
              <tr>
                <td colspan="2" class="font-weight-bold">Dirección de correo electrónico</td>
                <td colspan="2">{{model.customer_email}}</td>
              </tr>
              <tr>
                <td colspan="2" class="font-weight-bold">Número de celular</td>
                <td colspan="2">{{model.customer_mobile}}</td>
              </tr>
              <tr>
                <td colspan="2" class="font-weight-bold">Estado</td>
                <td colspan="2" v-if="model.status=='CREATED'">CREADO</td>
                <td colspan="2" v-if="model.status=='PAYED'">PAGADO</td>
                <td colspan="2" v-if="model.status=='REJECTED'">RECHAZADO</td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>

        <v-card-actions>
          <div class="flex-grow-1"></div>
          <v-btn color="indigo darken-4" outlined @click="dialogEnviar=false">
            <v-icon left>mdi-arrow-left-circle</v-icon>Volver
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- aqui empieza el dialog de carga -->

  
  
  </div>
</template>
<script>
import funcionesgenerales from "../../mixins/funcionesGenerales";
export default {
  mixins: [funcionesgenerales],
  data() {
    return {
      search: "",
      dialogEnviar:false,
     
      model: {
        id: "",
        customer_name: "",
        customer_email: "",
        customer_mobile: "",
        status: "",
      },
      arrayOrdenes: [],
      cabecera_ordenes: [
        { text: "Referencia", value: "id", sortable: false },
        { text: "Nombre", value: "customer_name", sortable: false },
        { text: "Estado", value: "estado", sortable: false },
        { text: "Accion", value: "action", sortable: false },
      ],
    };
  },

  methods: {
    //funcion para listar todas las ordenes
    listarOrdenes() {
      axios
        .post("/mostrarOrdenes", {
          opcion: 2,
        })
        .then((response) => {
          this.arrayOrdenes = response.data;
        });
    },
    //funcion para ver la vista de informacion de la orden
    abrirDialogVer(item) {
      this.model.id = item.id;
      this.model.customer_name = item.customer_name;
      this.model.customer_email = item.customer_email;
      this.model.customer_mobile = item.customer_mobile;
      this.model.status = item.status;
      this.dialogEnviar = true;
    },
    //funcion para limpiar los campos 
    limpiarCampos() {
      this.model.id = "";
      this.model.customer_name = "";
      this.model.customer_email = "";
      this.model.customer_mobile = "";
      this.model.status = "";
    },
  },
  mounted() {
    //al momento de iniciar el componente llama la funcion de listar ordenes
    this.listarOrdenes();
  },
};
</script>
