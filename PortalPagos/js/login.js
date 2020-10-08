new Vue({
  el: '#login',
  data: {
    valid: true,
    valid2: true,
    select: null,
    show1: false,
    show2: false,
    show3: false,
    checkbox: false,
    mostrarLogin: true,
    mostrarMetodoFinanciero: 1,

    tituloLogin: "INICIO DE SESION",
    usuarioLogin: '',
    contrasenaLogin: '',
    usuarioForm: '',
    contrasenaForm: '',
    contrasenaRepetidaForm: '',
    nombreForm: '',
    fechaForm: '2020-01-01',
    nombreEmpresaForm: '',

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




    email: '',
    name: '',
    usuarioRules: [
      v => !!v || 'El usuario es requerido',
    ],

    contrasenaRules: [
      v => !!v || 'Contrasena es requerida',
    ],

    usuarioFormRules: [
      v => (v && v.length <= 20) || 'El usuario tiene que tener maximo 20 caracteres',
    ],
    contrasenaFormRules: [
      v => (v && v.length <= 35) || 'La Contrasena tiene que tener maximo 35 caracteres',
    ],
    contrasenaRepetidaFormRules: [
      v => (v && v.length <= 35) || 'La Contrasena tiene que tener maximo 35 caracteres',
    ],
    nombreFormRules: [
      v => (v && v.length <= 75) || 'El nombre completo tiene que tener maximo 75 caracteres',
    ],
    nombreEmpresaFormRules: [
      v => (v && v.length <= 50) || 'El nombre de la empresa tiene que tener maximo 50 caracteres',
    ],
    correoFormRules: [
      v => /.+@.+\..+/.test(v) || 'Correo no valido',

    ],

  },
  methods: {
    iniciarSesion() {
      this.$refs.form.validate()
      let formData = new FormData()
      formData.append("usuario", this.usuarioLogin)
      formData.append("contrasena", this.contrasenaLogin)
      const url = "../php/inicioSesion.php"
      axios.post(url, formData).then(function (response) {
        if (response.data.result) {
          alert(response.data.estado)
          if (response.data.estado === 'ACTIVO') {
            if (response.data.tipo == 'EMPRESA') {
              window.location.href = '../paginas/usuario.php?user=' + response.data.correo + '&key=' + response.data.key
            } else if (response.data.tipo == 'ADMINISTRADOR') {
              window.location.href = './administrador.php?user=' + response.data.correo+ '&key=' + response.data.key
            } else {
              window.location.href = '../paginas/login.html'
            }
          } else {
            alert("Tu Cuenta de Usuario ha sido bloqueada temporalmente, ponte en contacto con nosotros al correo: jpmazate@gmail.com")
          }

        } else {
          alert(response.data.mensaje)

        }
      }).catch(function (error) {
        alert("Surgio un error al intentar enviar la peticion")
        console.log(error)
      })



    },
    registrarUsuario() {
      this.$refs.form2.validate()
      if (this.contrasenaForm === this.contrasenaRepetidaForm) {

        if (this.esValidoMetodoPago) {

          let formData = new FormData()
          
          formData.append("tipoMetodoPago", this.tipoMetodoPagoValidado)
          formData.append("numeroMetodoPago", this.numeroMetodoPagoValidado)
          formData.append("contrasena", this.contrasenaForm)
          formData.append("nombre", this.nombreForm)
          formData.append("empresa", this.nombreEmpresaForm)
          formData.append("usuario", this.usuarioForm)
          formData.append("tipoUsuario", 'EMPRESA')
          const url = "../php/crearUsuario.php"
          axios.post(url, formData).then( (response) =>{
            if (response.data.result) {
              alert(response.data.mensaje + '. TU CORREO CON EL QUE INICIARAS SESION ES: '+response.data.correo)
              //respuesta del servidor
              window.location.href = './login.html'
            } else {
              alert(response.data.mensaje)
            }
          }).catch((error) => {
            console.log(error)
            alert("Surgio un error al intentar enviar la peticion de crear usuario")
          })

        }else{
          alert("El metodo de pago no ha sido validado correctamente, no se puede proceder a crear la cuenta")  
        }
      } else {
        alert("Las contrasenas no coinciden")
      }
    },
    reset() {
      this.$refs.form.reset()
      this.$refs.form2.reset()
    },

    cambiarBanderaLogin() {
      if (this.mostrarLogin) {
        this.tituloLogin = "FORMULARIO DE CREACION USUARIO"
      } else {
        this.tituloLogin = "INICIO DE SESION"
      }
      this.mostrarLogin = !this.mostrarLogin
    },
    validarMetodoPago() {

      if (this.mostrarMetodoFinanciero === 1) {
          
        let formData = new FormData()
          formData.append("metodoPago",'CUENTA')
          formData.append("usuarioFinanciero", this.usuarioFinancieroCuentaForm)
          formData.append("contrasenaUsuarioFinanciero", this.contrasenaUsuarioFinancieroCuentaForm)
          formData.append("noCuenta", this.noCuentaUsuarioFinancieroCuentaForm)
          
          //usar url externa
          const url = "http://localhost/Proyecto_Final_SS1/Portal_Financiero/WebServices/inicioSesionPortalPagos.php"
          axios.post(url, formData).then( (response) => {
            if (response.data.result) {
              
              alert(response.data.mensaje)
              this.mensajeValidacionMetodo = response.data.mensaje
              this.tipoMetodoPagoValidado = response.data.tipoMetodoPago
              this.numeroMetodoPagoValidado = response.data.numeroCuenta
              this.esValidoMetodoPago = true

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
        const url = "http://localhost/Proyecto_Final_SS1/Portal_Financiero/WebServices/inicioSesionPortalPagos.php"
        axios.post(url, formData).then( (response) =>{
          if (response.data.result) {
            alert(response.data.mensaje)
            this.mensajeValidacionMetodo = response.data.mensaje
            this.tipoMetodoPagoValidado = response.data.tipoMetodoPago
            this.numeroMetodoPagoValidado = response.data.numeroCuenta
            this.esValidoMetodoPago = true
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
    reiniciarValores() {
      this.usuarioLogin = ''
      this.contrasenaLogin = ''
      this.usuarioForm = ''
      this.contrasenaForm = ''
      this.contrasenaRepetidaForm = ''
      this.nombreForm = ''
      this.fechaForm = ''
      this.correoElectronicoFor = ''
    },
  },
  vuetify: new Vuetify(),
})

/*
CUENTA BANCARIA
39593607
t7921p13
3357505441

TARJETA DE CREDITO
1999926551891481
5555555555555
2024-10-01
894

*/
