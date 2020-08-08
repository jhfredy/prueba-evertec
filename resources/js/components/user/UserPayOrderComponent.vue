<template>
  <div style="width: 100%">
    <v-toolbar class="mb-2" color="#fafafa" light flat>
      <v-toolbar-title class="black--text">
        <v-avatar color="primary" class="mr-5">
          <v-icon large dark>mdi-clipboard-text-multiple-outline</v-icon>
        </v-avatar>Resumen
      </v-toolbar-title>
    </v-toolbar>
    <v-divider color="#0054a5" style="border: 1px dashed #fafafa"></v-divider>

    <v-card class="mx-auto">
      <v-row>
        <v-col cols="12">
          <v-toolbar color light flat>
            <v-toolbar-title class="black--text text-uppercase">Ordenes Por Pagar</v-toolbar-title>
          </v-toolbar>

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
                      <p class="mt-2">{{item.status=="CREATED"?"CREADO":"RECHAZADO"}}</p>
                    </template>
                    <template v-slot:item.action="{item}">
                      <v-row>
                        <template>
                          <v-tooltip top>
                            <template v-slot:activator="{ on, attrs }">
                              <v-col cols="6" sm="3">
                                <v-btn
                                  @click="abrirDialogPagar(item)"
                                  v-bind="attrs"
                                  v-on="on"
                                  class="mx-2"
                                  fab
                                  dark
                                  dense
                                  small
                                  color="green darken-4"
                                >
                                  <v-icon dark>mdi-cash-multiple</v-icon>
                                </v-btn>
                              </v-col>
                            </template>
                            <span>Pagar</span>
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
    <!-- dialogs  -->
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

          <v-btn color="primary" @click="guardarOrden()">
            <v-icon left>check_circle</v-icon>Pagar Orden
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- aqui empieza el dialog de carga -->

    <v-dialog v-model="dialogEnviando" persistent width="600" height="200">
      <v-card color="primary" dark>
        <v-card-text class="white--text font-weight-bold">
          Pagando Orden...
          <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-snackbar :color="color_snackbar" top right v-model="snackbar_mensaje">
      <div>
        <p class="mx-2 my-2" v-for="(item, i) in text_snackbar" :key="i">
          <v-icon large>mdi-message-alert-outline</v-icon>
          {{item}}
        </p>
      </div>

      <v-btn color="white" text @click="snackbar_mensaje = false">CERRAR</v-btn>
    </v-snackbar>
  </div>
</template>
<script>
import funcionesgenerales from "../../mixins/funcionesGenerales";
export default {
  mixins: [funcionesgenerales],
  data() {
    return {
      search: "",
      dialogEnviar: false,
      dialogEnviando: false,
      color_snackbar: "success",
      text_snackbar: [],
      snackbar_mensaje: false,
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
    listarOrdenes() {
      axios
        .post("/mostrarOrdenes", {
          opcion: 1,
        })
        .then((response) => {
          this.arrayOrdenes = response.data;
        });
    },
    guardarOrden() {
      this.dialogEnviar = false;
      this.dialogEnviando = true;
      this.text_snackbar = [];
      axios
        .post("/pagarOrden", {
          model: this.model,
        })
        .then((response) => {
          this.dialogEnviando = false;
          this.color_snackbar = "success";
          this.snackbar_mensaje = true;
          this.text_snackbar.push("Orden pagada Correctamente");
          this.limpiarCampos();
          window.open(response.data, '_blank');
        })
        .catch((error) => {
          this.dialogEnviando = false;
          this.color_snackbar = "error";
          this.snackbar_mensaje = true;

          var errores = error.response.data.errors;

          for (var key in errores) {
            if (errores.hasOwnProperty(key)) {
              errores[key].forEach((element) => {
                this.text_snackbar.push(element);
              });
            }
          }
        });
    },
    abrirDialogPagar(item) {
      this.model.id = item.id;
      this.model.customer_name = item.customer_name;
      this.model.customer_email = item.customer_email;
      this.model.customer_mobile = item.customer_mobile;
      this.model.status = item.status;
      this.dialogEnviar = true;
    },
    limpiarCampos() {
      this.model.id = "";
      this.model.customer_name = "";
      this.model.customer_email = "";
      this.model.customer_mobile = "";
      this.model.status = "";
    },
  },
  mounted() {
    this.listarOrdenes();
  },
};
</script>
