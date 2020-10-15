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
            <v-btn @click="cargarPantallaIngresoDinero()">
              TRANSACCIONES
            </v-btn>



          </v-app-bar-nav-icon>
          <v-spacer></v-spacer>




          <v-toolbar-title> {{usuario}} </v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-title> Saldo: Q{{saldo}} </v-toolbar-title>



          <v-btn icon @click="cerrarSesion()">
            <v-icon>mdi-export</v-icon>
            Salir
          </v-btn>
        </v-toolbar>
        <div v-if="mostrar === 2">


          <v-img src="../images/sistema/desenfocado.jpeg">
            <center>
              <v-toolbar-title> PORTAL DE PAGOS</v-toolbar-title>
            </center>

            <center>
              <v-btn @click="mostrarPerfil = 1">
                Mostrar Perfil
              </v-btn>
              <v-btn @click="mostrarPerfil = 2">
                Registrar Metodo de Pago Alternativo
              </v-btn>
              <v-card width="300" height="300">
                <v-avatar class="profile" color="grey" size="300" tile>
                  <v-img src="https://www.paypalobjects.com/webstatic/icon/pp258.png" />
                </v-avatar>
              </v-card>
            </center>
            <br>
            <br>
            <center>


              <div v-if="mostrarPerfil === 1">


                <v-container class="pa-4 text-center">
                  <v-row class="fill-height" align="center" justify="center">


                    <v-hover v-slot:default="{ hover }">
                      <v-card :elevation="hover ? 15 : 2" class="scroll">
                        <v-responsive :aspect-ratio="16/9">
                          <v-img src="../images/sistema/fondo.jpg">
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
              </div>
              <div v-else-if="mostrarPerfil === 2">
                <center>
                  <v-toolbar-title center>PARA CREAR UNA CUENTA EN EL PORTAL DE PAGOS DEBES DE INICIAR SESION EN UNA CUENTA DEL PORTAL FINANCIERO</v-toolbar-title>
                </center>
                <br>
                <v-btn color="yellow" class="mr-4" @click="mostrarMetodoFinanciero = 1">
                  Usar Cuenta Bancaria
                </v-btn>

                <v-btn color="red" class="mr-4" @click="mostrarMetodoFinanciero = 2">
                  Usar Tarjeta de Credito
                </v-btn>

                <div v-if="mostrarMetodoFinanciero === 1">

                  <div>
                    INICIA SESION CON TU CUENTA EN EL PORTAL FINANCIERO
                  </div><br>
                  <v-text-field v-model="usuarioFinancieroCuentaForm" :counter="8" :rules="usuarioFinancieroCuentaFormRules" label="Usuario en el portal financiero" hint="Maximo 8 caracteres" counter required></v-text-field>


                  <v-text-field v-model="contrasenaUsuarioFinancieroCuentaForm" :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'" :type="show2 ? 'text' : 'password'" :rules="contrasenaFormRules" label="Contrasena de cuenta en el portal financiero" @click:append="show2 = !show2" required></v-text-field>

                  <v-text-field v-model="noCuentaUsuarioFinancieroCuentaForm" :counter="10" :rules="noCuentaUsuarioFinancieroCuentaFormRules" label="Numero de Cuenta en el portal financiero" hint="Maximo 10 caracteres" counter required></v-text-field>


                </div>
                <div v-else-if="mostrarMetodoFinanciero === 2">
                  <div>
                    UTILIZA TU TARJETA DE CREDITO DEL PORTAL FINANCIERO
                  </div><br>

                  <v-text-field v-model="numeroTarjetaForm" :counter="16" :rules="numeroTarjetaFormRules" label="Numero de tarjeta" hint="Maximo 16 caracteres" type="number" counter required></v-text-field>


                  <v-text-field v-model="dpiTarjetaForm" :counter="13" :rules="dpiTarjetaFormRules" label="Dpi CuentaHabiente" hint="Maximo 13 caracteres" type="number" counter required></v-text-field>

                  <v-text-field v-model="codigoCVCTarjetaForm" :counter="3" :rules="codigoCVCTarjetaFormRules" label="Codigo CVC" hint="Maximo 3 caracteres" type="number" counter required></v-text-field>

                  <div> Fecha Vencimiento</div>
                  <v-date-picker label="Fecha de Vencimiento por favor" v-model="fechaVencimientoTarjetaForm" class="mt-4" min="1900-01-01" max="2040-01-01"></v-date-picker>

                </div>

                <v-btn color="green" class="mr-4" @click="validarMetodoPago">
                  VALIDAR METODO DE PAGO
                </v-btn>
                <div> <br>
                  {{mensajeValidacionMetodo}} <br>
                  METODO DE PAGO: {{tipoMetodoPagoValidado}} <br>
                  NUMERO: {{numeroMetodoPagoValidado}} <br>
                </div>
              </div>

            </center>








        </div>


        <div v-if="mostrar === 3">


          <v-img src="../images/sistema/desenfocado.jpeg">
            <center>
              <v-toolbar-title> REPORTE DE INGRESOS Y EGRESOS</v-toolbar-title>
            </center>
            <div>
              <v-toolbar-title> Filtros </v-toolbar-title>
              <v-row class="fill-height" align="center">
                <v-col cols="12" sm="4">
                  <div> Fecha Inicio</div>
                  <v-date-picker label="Si quieres filtrar por fechas" v-model="filtroInicioFecha" class="mt-4" min="1900-01-01" max="2040-01-01"></v-date-picker>
                </v-col>
                <v-col cols="12" sm="4">

                  <div> Fecha Fin</div>
                  <v-date-picker label="Si quieres filtrar por fechas" v-model="filtroFinFecha" class="mt-4" min="1900-01-01" max="2040-01-01"></v-date-picker><br><br>
                </v-col>
              </v-row>

              <v-btn color="success" class="mr-4" @click="filtrarTransacciones()" name="btn5" required> OBTENER TRANSACCIONES
              </v-btn>
              <v-btn color="success" class="mr-4" @click="reiniciarFechas()" name="btn6" required> Reiniciar Fechas
              </v-btn>
            </div>

            <center>

              <v-toolbar-title> Subtotal Transacciones Financieras Q{{cierreFinanciero}} </v-toolbar-title>
              <v-toolbar-title> Subtotal Transacciones Internas Q{{cierreInterno}} </v-toolbar-title>
              <v-toolbar-title> Total Final Q {{cierreTotal}} </v-toolbar-title>
              
              <v-toolbar-title> Impuestos cobrados Q{{impuestos}} </v-toolbar-title>
              
              

              <!--  <v-container class="pa-4 text-center" fill-height fluid align="center">
                <v-row class="fill-height" align="center">
                  <v-col cols="12" sm="4">
                    <v-card>
                      <v-card-title>
                        <center>TRANSACCIONES FINANCIERAS</center><br><br>
                      </v-card-title>
                      <v-card-subtitle class="pb-0">
                        <v-text-field v-model="filtroTransaccionesFinancieras" append-icon="mdi-magnify" label="Escribe lo que desees buscar para cualquier campo" single-line hide-details></v-text-field>
                      </v-card-subtitle>
                      <br>


                      <v-data-table :headers="headerTransaccionesFinancieras" :items="datosTransaccionesFinancieras" :search="filtroTransaccionesFinancieras"></v-data-table>
                    </v-card>
                  </v-col>

                  <v-divider vertical></v-divider>
                  <v-col cols="12" sm="4">
                    <v-card>
                      <v-card-title>
                        <center>TRANSACCIONES INTERNAS</center><br><br>
                      </v-card-title>
                      <v-card-subtitle class="pb-0">
                        <v-text-field v-model="filtroTransaccionesInternas" append-icon="mdi-magnify" label="Escribe lo que desees buscar para cualquier campo" single-line hide-details></v-text-field>
                      </v-card-subtitle>
                      <br>
                      <v-data-table :headers="headerTransaccionesInternas" :items="datosTransaccionesInternas" :search="filtroTransaccionesInternas"></v-data-table>
                    </v-card>
                  </v-col>



                </v-row>
              </v-container> -->
              

              
              <v-container class="pa-4 text-center" fill-height fluid align="center">


                <v-card>
                  <v-card-title>
                    <center>TRANSACCIONES FINANCIERAS</center><br><br>
                  </v-card-title>
                  <v-card-subtitle class="pb-0">
                    <v-text-field v-model="filtroTransaccionesFinancieras" append-icon="mdi-magnify" label="Escribe lo que desees buscar para cualquier campo" single-line hide-details></v-text-field>
                  </v-card-subtitle>
                  <br>


                  <v-data-table :headers="headerTransaccionesFinancieras" :items="datosTransaccionesFinancieras" :search="filtroTransaccionesFinancieras"></v-data-table>
                </v-card>
              </v-container>
              
              <v-container class="pa-4 text-center" fill-height fluid align="center">
                <v-divider vertical></v-divider>

                <v-card>
                  <v-card-title>
                    <center>TRANSACCIONES INTERNAS</center><br><br>
                  </v-card-title>
                  <v-card-subtitle class="pb-0">
                    <v-text-field v-model="filtroTransaccionesInternas" append-icon="mdi-magnify" label="Escribe lo que desees buscar para cualquier campo" single-line hide-details></v-text-field>
                  </v-card-subtitle>
                  <br>
                  <v-data-table :headers="headerTransaccionesInternas" :items="datosTransaccionesInternas" :search="filtroTransaccionesInternas"></v-data-table>
                </v-card>





              </v-container>
              

            </center>







        </div>

        <div v-else-if="mostrar === 4">


          <v-img src="../images/sistema/desenfocado.jpeg">
            <center>
              <v-toolbar-title> REALIZAR TRANSACCION DE DINERO A LA CUENTA</v-toolbar-title>
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
                    <v-card :elevation="hover ? 15 : 2" class="scroll">
                      <v-responsive :aspect-ratio="16/9">
                        <v-img src="../images/sistema/fondo.jpg">
                          <v-form ref="form" v-model="valid" lazy-validation>
                            <div> MENU PARA LAS TRANSACCIONES DE DINERO</div> <br>
                            <v-text-field v-model="montoIngresoDinero" :rules="[
              () => !!montoIngresoDinero || 'El campo es requerido',
                ]" type="number" label="Ingresa el monto de dinero" required></v-text-field>

                            <div> SELECCIONA TU METODO DE PAGO</div>
                            <v-radio-group v-model="radioGroupMetodo">
                              <div v-if="cuentaFinanciera != null">
                                <v-radio :label="`Cuenta Financiera: ${cuentaFinanciera}`" :value="1" selected></v-radio>
                              </div>
                              <div v-if="tarjetaCredito != null">
                                <v-radio :label="`Tarjeta de Credito: ${tarjetaCredito}`" :value="2"></v-radio>
                              </div>
                            </v-radio-group>

                            <v-btn :disabled="!valid" color="success" class="mr-4" @click="realizarIngresoDinero">
                              REALIZAR INGRESO DE DINERO
                            </v-btn> <br><br>
                            <v-btn :disabled="!valid" color="blue" class="mr-4" @click="realizarRetiroDinero">
                              REALIZAR RETIRO DE DINERO
                            </v-btn><br><br>

                            <v-btn color="error" class="mr-4" @click="reset">
                              Borrar Datos
                            </v-btn>


                          </v-form>

                        </v-img>
                      </v-responsive>

                    </v-card>
                  </v-hover>


                </v-row>
              </v-container>

            </center>







        </div>



        <div v-else>
        <v-img src="../images/sistema/desenfocado.jpeg">
        SELECCIONA ALGUNA OPCION DEL MENU PARA VISUALIZARLO AQUI
        </v-img>
          
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