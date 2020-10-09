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

    //DASHBOARD
    mostrarDashboard: 0,
    anunciosDashboard: [],
    hitosDashboard: [],
    comentariosHitos: [],
    escribirComentarioHitos: [],
    botonesMostrarComentarios: [],
    variableAuxiliarIdHito: '',






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


        const url = "http://localhost/Proyecto_Final_SS1/Portal_Financiero/WebServices/acreditacionPortalPagos.php"
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
        const url = "http://localhost/Proyecto_Final_SS1/Portal_Financiero/WebServices/acreditacionPortalPagos.php"
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


          const url = "http://localhost/Proyecto_Final_SS1/Portal_Financiero/WebServices/acreditacionPortalPagos.php"
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
          const url = "http://localhost/Proyecto_Final_SS1/Portal_Financiero/WebServices/acreditacionPortalPagos.php"
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
  },

  vuetify: new Vuetify(),
})
