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
   <div id="administrador">

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
           {{validarDatos()}}

         </div>

         <v-toolbar dark prominent src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg">


           <v-spacer></v-spacer>




           </v-app-bar-nav-icon>
           <v-spacer></v-spacer>

           <v-app-bar-nav-icon>
             <v-btn @click="mostrarInicio = 3">
               Reporte Ingresos/Egresos

             </v-btn>



           </v-app-bar-nav-icon>


           <v-spacer></v-spacer>

           <v-app-bar-nav-icon>
             <v-btn @click="verDashboardUsuarios()">
               Ver Usuarios
             </v-btn>

           </v-app-bar-nav-icon>
           <v-spacer></v-spacer>

           <v-app-bar-nav-icon>
             <v-btn @click="crearUsuarioAdmin()">
               Crear Admin
             </v-btn>

           </v-app-bar-nav-icon>


           <v-toolbar-title> {{usuario}} </v-toolbar-title>

           <v-spacer></v-spacer>

           <v-btn icon @click="salir()">
             <v-icon>mdi-export</v-icon>
             Salir
           </v-btn>
         </v-toolbar>

         <div v-if="mostrarInicio === 3 ">
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

               <v-toolbar-title> Total Dinero Movido en Transacciones Internas Q{{cierreInterno}} </v-toolbar-title>
               <v-toolbar-title> Total Transacciones Financieras Q{{cierreFinanciero}} </v-toolbar-title>
               <v-toolbar-title> GANANCIAS OBTENIDAS(IMPUESTOS): Q{{impuestos}} </v-toolbar-title>

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

         <div v-else-if="mostrarInicio === 6">
         <v-img src="../images/sistema/desenfocado.jpeg">

          <center>
         <h1><v-toolbar-title> VER USUARIOS<br> </v-toolbar-title></h1>
        </center>
           <v-btn color="blue" class="mr-4" @click="mostrarFiltrosUsuario = !mostrarFiltrosUsuario" name="btn6" required> Mostrar Filtros
           </v-btn><br>

           <div v-if="mostrarFiltrosUsuario">

             <v-toolbar-title> Filtros </v-toolbar-title>
             <v-combobox v-model="filtroUsuarioTipo" :items="itemsUsuarioTipo" label="Si quieres filtrar por tipo de usuario"></v-combobox>
             <v-text-field v-model="filtroNombreUsuario" :counter="40" label="Si quieres filtrar por usuario" hint="Maximo 300 caracteres" counter required></v-text-field>
             <v-row class="fill-height" align="center">
               <v-col cols="12" sm="4">
                 <div> Fecha Inicio</div>
                 <v-date-picker label="Si quieres filtrar por fechas" v-model="filtroUsuarioInicioFecha" class="mt-4" min="1900-01-01" max="2040-01-01"></v-date-picker>
               </v-col>
               <v-col cols="12" sm="4">

                 <div> Fecha Fin</div>
                 <v-date-picker label="Si quieres filtrar por fechas" v-model="filtroUsuarioFinFecha" class="mt-4" min="1900-01-01" max="2040-01-01"></v-date-picker><br><br>
               </v-col>
             </v-row>




             <v-btn color="success" class="mr-4" @click="filtrarUsuarios()" name="btn5" required> Filtrar USUARIOS
             </v-btn>
             <v-btn color="success" class="mr-4" @click="reiniciarUsuarioFechas()" name="btn6" required> Reiniciar Fechas
             </v-btn>
           </div>
           <div>
             <v-container class="pa-4 text-center">
               <v-row class="fill-height" align="center" justify="center">
                 <div v-for="(item, i) in usuariosSistema">
                   <v-col :key="i" cols="20" md="8" id="scroll-target">
                     <v-hover v-slot:default="{ hover }">
                       <v-card :elevation="hover ? 15 : 2" class="scroll">
                         <v-responsive :aspect-ratio="16/9">
                           <v-img src="../images/sistema/fondo.jpg">
                             <v-card-title class="title black--text">
                               Correo: {{item.correo}}
                             </v-card-title>
                             <v-card-subtitle class="pb-0">Cuenta Financiera: {{item.cuenta_financiera}}</v-card-subtitle></b>
                             <v-card-subtitle class="pb-0">Tarjeta de Credito: {{item.tarjeta_credito}}</v-card-subtitle></b>
                             <v-card-subtitle class="pb-0">Nombre Completo: {{item.nombre_completo}}</v-card-subtitle></b>
                             <v-card-subtitle class="pb-0">Codigo Empresa: {{item.codigo_empresa}}</v-card-subtitle></b>
                             <v-card-subtitle class="pb-0">Nombre Empresa: {{item.empresa}}</v-card-subtitle></b>
                             <v-card-subtitle class="pb-0">Usuario: {{item.usuario}}</v-card-subtitle></b>
                             <v-card-subtitle class="pb-0">Fecha Creacion: {{item.fecha_creacion}}</v-card-subtitle></b>
                             <v-card-subtitle class="pb-0">Tipo Usuario: {{item.tipo}}</v-card-subtitle></b>
                             <v-card-subtitle class="pb-0">Estado: {{item.estado}}</v-card-subtitle></b>


                             <v-btn color="success" class="mr-4" @click="habilitarUsuario(i)" name="btn6" required> Habilitar Usuario
                             </v-btn>
                             <v-btn color="success" class="mr-4" @click="deshabilitarUsuario(i)" name="btn6" required> Deshabilitar Usuario
                             </v-btn>




                           </v-img>
                         </v-responsive>

                       </v-card>
                     </v-hover>
                   </v-col>
                 </div>
               </v-row>
             </v-container>


           </div>
         </v-img>

         </div>


         <div v-else-if="mostrarInicio === 7">

         <v-img src="../images/sistema/desenfocado.jpeg">

         <center>
          <h1>CREAR USUARIO ADMINISTRADOR</h1>
            <v-divider horizontal></v-divider>
          </center>
           <v-form ref="form2" v-model="valid9" lazy-validation method="post" action="crearUsuario.php"><br>




             <center>
               <v-toolbar-title center>{{tituloLogin}}</v-toolbar-title>
             </center>

             <v-text-field v-model="usuarioForm" :counter="20" :rules="usuarioFormRules" label="Usuario" hint="Maximo 20 caracteres" counter required></v-text-field>

             <v-text-field v-model="contrasenaForm" :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'" :type="show2 ? 'text' : 'password'" :rules="contrasenaFormRules" label="Contrasena" @click:append="show2 = !show2" required></v-text-field>

             <v-text-field v-model="contrasenaRepetidaForm" :append-icon="show3 ? 'mdi-eye' : 'mdi-eye-off'" :type="show3 ? 'text' : 'password'" :rules="contrasenaRepetidaFormRules" label="Contrasena Repetida" @click:append="show3 = !show3" required></v-text-field>

             <v-text-field v-model="nombreForm" :counter="75" :rules="nombreFormRules" label="Nombre Completo" hint="Maximo 75 caracteres" counter required></v-text-field>


             <br><br>
             <v-btn :disabled="!valid9" color="success" class="mr-4" @click="registrarAdministrador" name="btn2">
               Registrarse
             </v-btn>
           </v-form>
         </v-img>
         </div>
         <div v-else>
         <v-img src="../images/sistema/desenfocado.jpeg">

           SELECCIONA ALGUNA OPCION DEL MENU PARA VISUALIZARLA AQUI
         </v-img>
         </div>
       </div>
   </div>
   </v-app>

   </div>
   <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
   <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
   <script src="../js/administrador.js"> </script>
 </body>

 </html>