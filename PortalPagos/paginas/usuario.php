<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
</head>

<body>
  <div id="app">

    <v-app>
      <div>
        <?php
        if (isset($_GET['user']) && isset($_GET['key'])) {
          $usuario = $_GET['user'];
          $key = $_GET['key'];
          $estado = 1;
        }
        ?>
        <div style="display: none">
          {{ usuario = '<?php echo $usuario ?>' }}
          {{ contrasena = '<?php echo $key ?>'}}
          {{ estado = <?php echo $estado ?>}}
          {{validarDatos() }}

        </div>


        <v-toolbar dark prominent src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg">

          <v-app-bar-nav-icon>
            <v-list-item-avatar size="70px">
              <v-img :src="`${perfilImagen}`" />
            </v-list-item-avatar>
          </v-app-bar-nav-icon>

          <v-spacer></v-spacer>

          <v-app-bar-nav-icon>
            <v-btn @click="mostrar = 2">
              Ver Perfil
            </v-btn>



          </v-app-bar-nav-icon>
          <v-spacer></v-spacer>

          <v-app-bar-nav-icon>
            <v-btn @click="mostrar = 3">
              Reporte Ingresos/Egresos
            </v-btn>



          </v-app-bar-nav-icon>

          <v-spacer></v-spacer>

          <v-app-bar-nav-icon>
            <v-btn @click="verPublicaciones()">
              Ingresar Dinero
            </v-btn>



          </v-app-bar-nav-icon>
          <v-spacer></v-spacer>

          <v-app-bar-nav-icon>

            <v-btn @click="mostrar = 5">
              Retirar Dinero
            </v-btn>

          </v-app-bar-nav-icon>

          
          <v-toolbar-title> {{usuario}} </v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-title> Saldo: Q{{saldo}} </v-toolbar-title>

          

          <v-btn icon @click="cerrarSesion()">
            <v-icon>mdi-export</v-icon>
            Salir
          </v-btn>
        </v-toolbar>
        <div v-if="mostrar === 2">


          <v-img src="../images/sistema/desenfocado2.jpeg">
            <center>
              <v-toolbar-title>  PORTAL DE PAGOS</v-toolbar-title>
            </center>

            <center>
              <v-card width="300" height="300">
                <v-avatar class="profile" color="grey" size="300" tile>
                  <v-img src="https://www.paypalobjects.com/webstatic/icon/pp258.png" />
                </v-avatar>
              </v-card>
            </center>
            <br>
            <br>
            <center>


            <v-container class="pa-4 text-center">
                <v-row class="fill-height" align="center" justify="center">
                  
                    
                      <v-hover v-slot:default="{ hover }">
                        <v-card :elevation="hover ? 15 : 2"  class="scroll">
                          <v-responsive :aspect-ratio="16/9">
                            <v-img src="../images/sistema/fondo.jpg" >
                              <v-card-title class="title black--text">
                                BIENVENIDO A TU PERFIL DEL PORTAL DE PAGOS
                              </v-card-title>
                              <v-card-title class="title black--text">
                                DATOS DE LA CUENTA DEL CORREO: {{usuario}}
                              </v-card-title><br>
                                <v-card-subtitle class="pb-0">Correo: {{usuario}}</v-card-subtitle>
                                <v-card-subtitle class="pb-0">Saldo: Q{{saldo}}</v-card-subtitle>
                                <v-card-subtitle class="pb-0">Nombre Completo: {{nombreCompleto}}</v-card-subtitle>
                                <v-card-subtitle class="pb-0">Codigo Empresa: {{codigoEmpresa}}</v-card-subtitle>
                                <v-card-subtitle class="pb-0">Empresa: {{empresa}}</v-card-subtitle>
                                <v-card-subtitle class="pb-0">Tipo Usuario: {{tipoUsuario}}</v-card-subtitle>
                                <v-card-subtitle class="pb-0">Tarjeta Credito: {{tarjetaCredito}}</v-card-subtitle>
                                <v-card-subtitle class="pb-0">Cuenta Financiera: {{cuentaFinanciera}}</v-card-subtitle>
                                <v-card-subtitle class="pb-0">Estado Cuenta: {{estadoCuenta}}</v-card-subtitle>
                    
                            </v-img>
                          </v-responsive>

                        </v-card>
                      </v-hover>
                    
                  
                </v-row>
              </v-container>
            
              </center>
            






        </div>


        <div v-else>
          SELECCIONA ALGUNA OPCION DEL MENU PARA VISUALIZARLO AQUI
        </div>











      </div>
    </v-app>
  </div>




  <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
  <script src="../js/usuario.js"> </script>
</body>

</html>