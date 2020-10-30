new Vue({
  el: '#app',
  data: {
    autoGrow: true,
    autofocus: true,
    clearable: false,
    counter: 0,
    filled: true,
    flat: false,
    hint: '',
    label: '',
    loading: false,
    model: 'I\'m a textarea.',
    noResize: false,
    outlined: false,
    persistentHint: false,
    placeholder: '',
    rounded: false,
    rowHeight: 50,
    rows: 1,
    shaped: false,
    singleLine: false,
    solo: false,
    //
    valor: "hola",
    usuario: 'USUARIO',
    contrasena: '',
    mostrar: 1,
    mostrarInicio: 3,
    estado: 0,
    offsetTop: 0,
    selectedFile: null,
    foto: null,
    foto2: null,
    foto3: null,
    perfilImagen: "",
    correo: '',
    nombreCompleto: '',
    confianza: 0,
    valid2: false,
    valid4: true,

    
    icons: ['mdi-rewind', 'mdi-play', 'mdi-fast-forward'],

    //cosas del portal de pagos
    saldo: 0,
    nombreCompleto: '',
    codigoEmpresa: '',
    empresa: '',
    tipoUsuario: '',
    tarjetaCredito: '',
    cuentaFinanciera: '',
    estadoCuenta: '',

    radioGroupMetodo: 1,
    montoIngresoDinero: 0,

    radioGroupMetodoRetiro: 1,
    montoRetiroDinero: 300,

    tasaInteres: 0.013,

    //tabla datos
    filtroInicioFecha: '',
    filtroFinFecha: '',
    filtroTransaccionesFinancieras: '',
    filtroTransaccionesInternas: '',
    cierreFinanciero:0,
    cierreInterno:0,
    cierreTotal:0,
    impuestos:0,

    headerTransaccionesInternas: [
      {
        text: 'ID',
        align: 'start',
        filterable: true,
        value: 'id',
      },
      { text: 'Monto', value: 'monto_total' },
      { text: 'Cuenta Emisora', value: 'cuenta_emisora' },
      { text: 'Cuenta Receptora', value: 'cuenta_receptora' },
      { text: 'Descripcion', value: 'descripcion' },
      { text: 'Fecha', value: 'fecha_transaccion' },
    ],


    headerTransaccionesFinancieras: [
      {
        text: 'ID',
        align: 'start',
        filterable: false,
        value: 'id',
      },
      { text: 'Cuenta', value: 'cuenta_involucrada' },
      { text: 'Monto', value: 'monto' },
      { text: 'Impuestos', value: 'impuestos' },
      { text: 'Total', value: 'total' },
      { text: 'Tipo', value: 'tipo' },
      { text: 'Fecha', value: 'fecha_transaccion' },
      { text: 'Metodo', value: 'tipo_metodo_pago' },
      { text: 'Numero Metodo', value: 'numero_metodo_pago' },
      { text: 'Numero Transaccion Portal Financiero', value: 'numero_transaccion_portal_financiero' },
    ],

    datosTransaccionesFinancieras: [],
    datosTransaccionesInternas: [],


    //hasta aqui tabla

    //metodo pago secundario
    mostrarPerfil:1,
    mostrarMetodoFinanciero: 1,
    show2: false,

    contrasenaFormRules: [
      v => (v && v.length <= 35) || 'La Contrasena tiene que tener maximo 35 caracteres',
    ],

     //datos usuario financiero
     esValidoMetodoPago: false,
     tipoMetodoPagoValidado:'',
     numeroMetodoPagoValidado:'',
     mensajeValidacionMetodo: 'NO SE HA VALIDADO EL METODO DE PAGO',
     usuarioFinancieroCuentaForm: '',
     noCuentaUsuarioFinancieroCuentaForm: '',
     contrasenaUsuarioFinancieroCuentaForm: '',
     usuarioFinancieroCuentaFormRules: [
       v => (v && v.length <= 8) || 'El usuario financiero tiene que tener maximo 8 caracteres',
     ],
     noCuentaUsuarioFinancieroCuentaFormRules: [
       v => (v && v.length <= 10) || 'El numero de cuenta del portal financiero tiene que tener maximo 10 caracteres',
     ],
 
     // datos tarjeta financiero
     numeroTarjetaForm: '',
     numeroTarjetaFormRules: [
       v => (v && v.length <= 16) || 'El numero de tarjeta tiene que tener maximo 16 caracteres',
     ],
     dpiTarjetaForm: '',
     dpiTarjetaFormRules: [
       v => (v && v.length <= 13) || 'El dpi del CuentaHabiente tiene que tener maximo 13 caracteres',
     ],
     codigoCVCTarjetaForm: '',
     codigoCVCTarjetaFormRules: [
       v => (v && v.length <= 3) || 'El codigo CVC que tener maximo 3 caracteres',
     ],
     fechaVencimientoTarjetaForm: '2020-01-01',
 
     //
 

    //



  },
  mounted: function () {


  },
  methods: {
    validarDatos() {
      if (this.usuario === 'USUARIO' && this.contrasena === '') {
        window.location.href = './login.html'
      } else {
        let formData = new FormData()
        formData.append("usuario", this.usuario)
        formData.append("contrasena", this.contrasena)
        const url = "../php/validacionInicioSesion.php"
        axios.post(url, formData).then((response) => {
          if (response.data.result === false) {
            window.location.href = './login.html'
          } else {
            if (response.data.datos[0].estado === 'ACTIVO') {
              this.saldo = response.data.datos[0].saldo
              this.nombreCompleto = response.data.datos[0].nombre_completo
              this.codigoEmpresa = response.data.datos[0].codigo_empresa
              this.empresa = response.data.datos[0].empresa
              this.tipoUsuario = response.data.datos[0].tipo
              this.tarjetaCredito = response.data.datos[0].tarjeta_credito
              this.cuentaFinanciera = response.data.datos[0].cuenta_financiera
              this.estadoCuenta = response.data.datos[0].estado
            } else {
              window.location.href = './login.html'

            }
          }



        }).catch((error) => {
          alert("Surgio un error al intentar enviar la peticion")
          console.log(error)
        })
      }



    },
    hug: function () {
      this.vare = '9'
    },
    onFileSelected(event) {
      this.selectedFile = event
    },
    redireccionarLogin() {
      window.location.href = './login.html'
    },
    cerrarSesion() {
      window.location.href = './login.html'
    },
    cargarPantallaIngresoDinero() {
      this.mostrar = 4
    },
    reset() {
      this.$refs.form.reset()
      this.$refs.form3.reset()
    },
    realizarIngresoDinero() {
      if (this.radioGroupMetodo === 1) {
        let formData = new FormData()
        formData.append("correo", this.usuario)
        formData.append("numeroCuenta", this.cuentaFinanciera)
        formData.append("tipoMetodoPago", 'CUENTA')
        formData.append("tipoAccion", 'INGRESO')
        formData.append("monto", this.montoIngresoDinero)


        const url = "http://25.89.40.130/Proyecto_Final_SS1/Portal_Financiero/WebServices/acreditacionPortalPagos.php"
        axios.post(url, formData).then((response) => {
          if (response.data.result === true) {
            this.crearTransaccionFinanciera(this.usuario, this.montoIngresoDinero, 'ACREDITACION', 'CUENTA', this.cuentaFinanciera, response.data.codigoTransaccion)
            this.montoIngresoDinero = 0
            this.mostrar = 1
          } else {
            alert(response.data.mensaje)
          }



        }).catch((error) => {
          alert("Surgio un error al intentar enviar la peticion")
          console.log(error)
        })


      } else if (this.radioGroupMetodo === 2) {
        let formData = new FormData()
        formData.append("correo", this.usuario)
        formData.append("numeroTarjeta", this.tarjetaCredito)
        formData.append("tipoMetodoPago", 'TARJETA')
        formData.append("tipoAccion", 'INGRESO')
        formData.append("monto", this.montoIngresoDinero)
        const url = "http://25.89.40.130/Proyecto_Final_SS1/Portal_Financiero/WebServices/acreditacionPortalPagos.php"
        axios.post(url, formData).then((response) => {
          if (response.data.result === true) {
            this.crearTransaccionFinanciera(this.usuario, this.montoIngresoDinero, 'ACREDITACION', 'TARJETA', this.tarjetaCredito, response.data.codigoTransaccion)
            this.montoIngresoDinero = 0
            this.mostrar = 1
          } else {
            alert(response.data.mensaje)
          }



        }).catch((error) => {
          alert("Surgio un error al intentar enviar la peticion")
          console.log(error)
        })
      }
    },

    realizarRetiroDinero() {
      this.actualizarSaldo()
      var total = (parseFloat(this.tasaInteres) * parseFloat(this.montoIngresoDinero)) + parseFloat(this.montoIngresoDinero)
      var saldoResultante = this.saldo - total;
      if (saldoResultante >= 0) {

        if (this.radioGroupMetodo === 1) {
          let formData = new FormData()
          formData.append("correo", this.usuario)
          formData.append("numeroCuenta", this.cuentaFinanciera)
          formData.append("tipoMetodoPago", 'CUENTA')
          formData.append("tipoAccion", 'RETIRO')
          formData.append("monto", this.montoIngresoDinero)


          const url = "http://25.89.40.130/Proyecto_Final_SS1/Portal_Financiero/WebServices/acreditacionPortalPagos.php"
          axios.post(url, formData).then((response) => {
            if (response.data.result === true) {
              this.crearTransaccionFinanciera(this.usuario, this.montoIngresoDinero, 'RETIRO', 'CUENTA', this.cuentaFinanciera, response.data.codigoTransaccion)
              this.montoIngresoDinero = 0
              this.mostrar = 1
            } else {
              alert(response.data.mensaje)
            }



          }).catch((error) => {
            alert("Surgio un error al intentar enviar la peticion")
            console.log(error)
          })


        } else if (this.radioGroupMetodo === 2) {
          let formData = new FormData()
          formData.append("correo", this.usuario)
          formData.append("numeroTarjeta", this.tarjetaCredito)
          formData.append("tipoMetodoPago", 'TARJETA')
          formData.append("tipoAccion", 'RETIRO')
          formData.append("monto", this.montoIngresoDinero)
          const url = "http://25.89.40.130/Proyecto_Final_SS1/Portal_Financiero/WebServices/acreditacionPortalPagos.php"
          axios.post(url, formData).then((response) => {
            if (response.data.result === true) {
              this.crearTransaccionFinanciera(this.usuario, this.montoIngresoDinero, 'RETIRO', 'TARJETA', this.tarjetaCredito, response.data.codigoTransaccion)
              this.montoIngresoDinero = 0
              this.mostrar = 1
            } else {
              alert(response.data.mensaje)
            }



          }).catch((error) => {
            alert("Surgio un error al intentar enviar la peticion")
            console.log(error)
          })
        }

      } else {
        alert("SALDO INSUFICIENTE A RETIRAR, RECUERDA QUE SE APLICA EL 1.3% DE IMPUESTOS")
      }
    },
    actualizarSaldo() {
      let formData = new FormData()
      formData.append("cuentaInvolucrada", this.usuario)
      const url = "../php/actualizarSaldo.php"
      axios.post(url, formData).then((response) => {
        if (response.data.result === true) {
          this.saldo = response.data.saldo
        } else {
          alert(response.data.mensaje)
        }
      }).catch((error) => {
        alert("Surgio un error al intentar enviar la peticion")
        console.log(error)
      })
    },
    crearTransaccionFinanciera(correo, monto, tipoTransaccion, metodoPago, numeroMetodoPago, codigoTransaccion) {
      let formData = new FormData()
      formData.append("cuentaInvolucrada", correo)
      formData.append("monto", monto)
      if (tipoTransaccion === 'ACREDITACION') {
        formData.append("impuestos", 0)
        formData.append("total", monto)

      } else {
        formData.append("impuestos", parseFloat(this.tasaInteres) * parseFloat(monto))
        formData.append("total", parseFloat(monto) + (parseFloat(this.tasaInteres) * parseFloat(monto)))

      }
      formData.append("tipo", tipoTransaccion)
      formData.append("tipoMetodo", metodoPago)
      formData.append("numeroMetodoPago", numeroMetodoPago)
      formData.append("numeroTransaccionPortalFinanciero", codigoTransaccion)
      const url = "../php/crearTransaccionFinanciera.php"
      axios.post(url, formData).then((response) => {
        if (response.data.result === true) {
          alert(response.data.mensaje + '. Codigo de Transaccion: ' + response.data.codigoTransaccionFinanciera)
          this.saldo = response.data.saldo
        } else {
          alert(response.data.mensaje)
        }



      }).catch((error) => {
        alert("Surgio un error al intentar enviar la peticion")
        console.log(error)
      })
    },
    reiniciarFechas: function () {
      this.filtroInicioFecha = ''
      this.filtroFinFecha = ''
    },
    filtrarTransacciones() {
      this.cierreFinanciero=0
      this.cierreInterno=0
      this.impuestos= 0
      this.cierreTotal= 0
      this.obtenerTransaccionesFinancieras()
      this.obtenerTransaccionesInternas()
      this.obtenerTotales()

    },
    obtenerTotales() {
      
      
      
    },


    obtenerTransaccionesInternas() {
      let formData = new FormData()
      formData.append('usuario', this.usuario)
      formData.append('fechaInicio', this.filtroInicioFecha)
      formData.append('fechaFin', this.filtroFinFecha)
      formData.append('tipo', 'PERSONAL')
      axios.post('../php/obtenerTransaccionesInternas.php', formData)
        .then((response) => {
          if (response.data.result) {
            this.datosTransaccionesInternas = response.data.datos
            for (var i = 0; i < response.data.datos.length; i+=1) {

              if(response.data.datos[i].cuenta_receptora == this.usuario){
                this.cierreInterno = parseFloat(this.cierreInterno) + parseFloat(response.data.datos[i].monto_total)
              }else{
                this.cierreInterno = parseFloat(this.cierreInterno) - parseFloat(response.data.datos[i].monto_total)
                
              }
            }
            this.cierreTotal = parseFloat(this.cierreFinanciero) + parseFloat(this.cierreInterno)
          } else {
            alert(response.data.mensaje)
          }

        })
        .catch((error) => {
          alert(error)
        })
    },
    obtenerTransaccionesFinancieras() {
      let formData = new FormData()
      formData.append('usuario', this.usuario)
      formData.append('fechaInicio', this.filtroInicioFecha)
      formData.append('fechaFin', this.filtroFinFecha)
      formData.append('tipo', 'PERSONAL')
      axios.post('../php/obtenerTransaccionesFinancieras.php', formData)
        .then((response) => {
          if (response.data.result) {
            this.datosTransaccionesFinancieras = response.data.datos
            for (var i = 0; i < response.data.datos.length; i+=1) {
              if(response.data.datos[i].tipo == 'ACREDITACION'){
                this.cierreFinanciero = parseFloat(this.cierreFinanciero) + parseFloat(response.data.datos[i].total)
              }else{
                this.cierreFinanciero = parseFloat(this.cierreFinanciero) - parseFloat(response.data.datos[i].total)
                this.impuestos = parseFloat(this.impuestos) + parseFloat(response.data.datos[i].impuestos)
              }
             
            }
            
          } else {
            alert(response.data.mensaje)
          }

        })
        .catch((error) => {
          alert(error)
        })
    },
    validarMetodoPago() {

      if (this.mostrarMetodoFinanciero === 1) {
          
        let formData = new FormData()
          formData.append("metodoPago",'CUENTA')
          formData.append("usuarioFinanciero", this.usuarioFinancieroCuentaForm)
          formData.append("contrasenaUsuarioFinanciero", this.contrasenaUsuarioFinancieroCuentaForm)
          formData.append("noCuenta", this.noCuentaUsuarioFinancieroCuentaForm)
          
          //usar url externa
          const url = "http://25.89.40.130/Proyecto_Final_SS1/Portal_Financiero/WebServices/inicioSesionPortalPagos.php"
          axios.post(url, formData).then( (response) => {
            if (response.data.result) {
              
              alert(response.data.mensaje)
              this.mensajeValidacionMetodo = response.data.mensaje
              this.tipoMetodoPagoValidado = response.data.tipoMetodoPago
              this.numeroMetodoPagoValidado = response.data.numeroCuenta
              this.esValidoMetodoPago = true
              this.registrarMetodoPagoSecundario()

              //alert(response.data.mensaje)
              //respuesta del servidor
            } else {
              alert(response.data.mensaje)
              this.mensajeValidacionMetodo = response.data.mensaje
              this.tipoMetodoPagoValidado = ''
              this.numeroMetodoPagoValidado = ''
              this.esValidoMetodoPago = false
              
            }
          }).catch((error) =>{
            console.log(error)
            alert("Surgio un error al intentar enviar la peticion de validar metodo de pago por favor prueba otra vez, si el error persiste prueba mas tarde")
              this.mensajeValidacionMetodo = error
              this.tipoMetodoPagoValidado = ''
              this.numeroMetodoPagoValidado = ''
              this.esValidoMetodoPago = false
            
          })

      

        
      } else if (this.mostrarMetodoFinanciero === 2) {

        let formData = new FormData()
        formData.append("metodoPago",'TARJETA')
        formData.append("noTarjeta", this.numeroTarjetaForm)
        formData.append("dpi", this.dpiTarjetaForm)
        formData.append("fechaVencimiento", this.fechaVencimientoTarjetaForm)
        formData.append("codigoCVC", this.codigoCVCTarjetaForm)
        //usar url externa
        const url = "http://25.89.40.130/Proyecto_Final_SS1/Portal_Financiero/WebServices/inicioSesionPortalPagos.php"
        axios.post(url, formData).then( (response) =>{
          if (response.data.result) {
            alert(response.data.mensaje)
            this.mensajeValidacionMetodo = response.data.mensaje
            this.tipoMetodoPagoValidado = response.data.tipoMetodoPago
            this.numeroMetodoPagoValidado = response.data.numeroCuenta
            this.esValidoMetodoPago = true
            this.registrarMetodoPagoSecundario()
          } else {
            alert(response.data.mensaje)
            this.mensajeValidacionMetodo = response.data.mensaje
            this.tipoMetodoPagoValidado = ''
            this.numeroMetodoPagoValidado = ''
            this.esValidoMetodoPago = false
            
          }
        }).catch((error) =>{
          console.log(error)
          alert("Surgio un error al intentar enviar la peticion de validar metodo de pago por favor prueba otra vez, si el error persiste prueba mas tarde")
              this.mensajeValidacionMetodo = error
              this.tipoMetodoPagoValidado = ''
              this.numeroMetodoPagoValidado = ''
              this.esValidoMetodoPago = false
        })
        
      }
    },
    registrarMetodoPagoSecundario() {
          let formData = new FormData()
          formData.append("tipoMetodoPago", this.tipoMetodoPagoValidado)
          formData.append("numeroMetodoPago", this.numeroMetodoPagoValidado)
          formData.append("usuario", this.usuario)
          const url = "../php/metodoPagoAlternativo.php"
          axios.post(url, formData).then( (response) =>{
            if (response.data.result) {
              alert(response.data.mensaje)
              if(this.tipoMetodoPagoValidado === 'CUENTA'){
                this.cuentaFinanciera = this.numeroMetodoPagoValidado
              }else{
                this.tarjetaCredito = this.numeroMetodoPagoValidado
              }
            } else {
              alert(response.data.mensaje)
            }
          }).catch((error) => {
            console.log(error)
            alert("Surgio un error al intentar enviar la peticion de registrar un metodo de pago alternativo")
          })

        
      
    },

  },

  vuetify: new Vuetify(),
})
// INSERT INTO TRANSACCION_INTERNA VALUES(null,300,'juan.1@JPMAZATE.com','juanito.1@JPMAZATE.com','Pago tienda',now());


/**
 // INSERT INTO TRANSACCION_INTERNA VALUES(null -> ID
 ,300  -> MONTO
 'juan.1@JPMAZATE.com' -> CUENTA EMISORA
 ,'juanito.1@JPMAZATE.com'  -> CUENTA RECEPTORA
 ,'Pago tienda' ->DESCRIPCION
 ,now());  ->FECHA



 
 */
//INSERT INTO TRANSACCION_INTERNA VALUES(null,300,'juanito.1@JPMAZATE.com','juan.1@JPMAZATE.com','Pago tienda',now());
