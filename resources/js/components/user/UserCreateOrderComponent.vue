<template>
  <div style="width: 100%">
    <v-toolbar class="mb-2" color="#fafafa" light flat>
      <v-toolbar-title class="black--text">
        <v-avatar color="primary" class="mr-5">
          <v-icon large dark>mdi-playlist-edit</v-icon>
        </v-avatar>Nueva Orden
      </v-toolbar-title>
    </v-toolbar>
    <v-divider color="#0054a5" style="border: 1px dashed #fafafa"></v-divider>

    <v-card class="mx-auto">
      <v-row>
        <v-col cols="12">
          <v-toolbar color light flat>
            <v-toolbar-title class="black--text text-uppercase">Crear Orden</v-toolbar-title>
          </v-toolbar>

          <v-container>
            <v-card class="mx-auto" elevation="0">
              <v-form ref="form_orden" v-model="form_orden">
                <v-row class="mt-2">
                  <v-col cols="12" sm="12" md="12">
                    <v-text-field
                      maxlength="80"
                      outlined
                      v-model="model.customer_name"
                      :counter="80"
                      label="Nombre"
                      dense
                      :rules="[rules_form.requerido]"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="6">
                    <v-text-field
                      maxlength="120"
                      outlined
                      v-model="model.customer_email"
                      :counter="120"
                      label="Dirección de correo electrónico"
                      dense
                      :rules="[rules_form.requerido,rules_form.email]"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="6">
                    <v-text-field
                    
                      maxlength="10"
                      outlined
                      v-model="model.customer_mobile"
                      :counter="10"
                      label=" Número de celular "
                      dense
                       :rules="[rules_form.requerido,rules_form.numeros]"
                    ></v-text-field>
                  </v-col>
                </v-row>
                <v-btn
                  :loading="dialogEnviando"
                  class="white--text"
                  block
                  :disabled="dialogEnviando"
                  color="primary"
                  depressed
                  @click="abrirDialogGuardar()"
                >Guardar</v-btn>
              </v-form>
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
            </tbody>
          </template>
        </v-simple-table>

        <v-card-actions>
          <div class="flex-grow-1"></div>
          <v-btn color="indigo darken-4" outlined @click="dialogEnviar=false">
            <v-icon left>mdi-arrow-left-circle</v-icon>Volver
          </v-btn>

          <v-btn color="primary" @click="guardarOrden()">
            <v-icon left>check_circle</v-icon>Guardar Orden
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- aqui empieza el dialog de carga -->

    <v-dialog v-model="dialogEnviando" persistent width="600" height="200">
      <v-card color="primary" dark>
        <v-card-text class="white--text font-weight-bold">
          Creando Orden...
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
      dialogEnviar: false,
      dialogEnviando: false,
      color_snackbar: "success",
      text_snackbar: [],
      snackbar_mensaje: false,
      model: {
        customer_name: "",
        customer_email: "",
        customer_mobile: "",
      },
      form_orden: false,
    };
  },

  methods: {
    guardarOrden() {
      
         this.dialogEnviar = false;
      this.dialogEnviando = true;
      this.text_snackbar = [];
      axios.post("/guardarOrden", {
          model: this.model,
        })
        .then(response => {
        
          this.dialogEnviando = false;
          this.color_snackbar = "success";
          this.snackbar_mensaje = true;
          this.text_snackbar.push("Orden Creada Correctamente");
          this.limpiarCampos();
          // window.open(response.data, '_blank');
        })
        .catch(error => {
          this.dialogEnviando = false;
          this.color_snackbar = "error";
          this.snackbar_mensaje = true;

          var errores = error.response.data.errors;

          for (var key in errores) {
            if (errores.hasOwnProperty(key)) {
              errores[key].forEach(element => {
                this.text_snackbar.push(element);
              });
            }
          }
        });
    },
    abrirDialogGuardar() {
      if (this.$refs.form_orden.validate()) {
        this.dialogEnviar = true;
      }
    },
    limpiarCampos() {
      this.model.customer_name = "";
      this.model.customer_email = "";
      this.model.customer_mobile = "";
    },
  },
  mounted() {},
};
</script>
