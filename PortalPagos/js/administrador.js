var vm = new Vue({
  el: '#administrador',
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
    valid9: true,
    mostrarInicio: 0,
    usuario: 'USUARIO',
    contrasena: '',
    estado: 0,


    saldo: 0,
    nombreCompleto: '',
    codigoEmpresa: '',
    empresa: '',
    tipoUsuario: '',
    tarjetaCredito: '',
    cuentaFinanciera: '',
    estadoCuenta: '',

    // VER USUARIOS
    // usuariosSistema
    usuariosSistema: [],
    mostrarFiltrosUsuario: false,
    filtroNombreUsuario: '',
    filtroUsuarioInicioFecha: '',
    filtroUsuarioFinFecha: '',
    filtroUsuarioTipo: '',
    itemsUsuarioTipo: [
      'ADMINISTRACION',
      'EMPRESA'
    ],

    //
    //PORTAL PAGOS
    //datos crear usuario
    USUARIO_ADMINISTRACION: 'ADMINISTRACION',
    usuarioForm: '',
    contrasenaForm: '',
    contrasenaRepetidaForm: '',
    nombreForm: '',

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
    //tabla datos
    filtroInicioFecha: '',
    filtroFinFecha: '',
    filtroTransaccionesFinancieras: '',
    filtroTransaccionesInternas: '',
    cierreFinanciero: 0,
    cierreInterno: 0,
    cierreTotal: 0,
    impuestos: 0,

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
    salir() {
      window.location.href = './login.html'

    },
    reiniciarUsuarioFechas() {
      this.filtroUsuarioFinFecha = ''
      this.filtroUsuarioInicioFecha = ''
    },
    verDashboardUsuarios() {
      this.mostrarInicio = 6
      this.mostrarUsuarios();
    },

    crearUsuarioAdmin() {
      this.mostrarInicio = 7
    },
    registrarAdministrador() {
      this.$refs.form2.validate()
      if (this.contrasenaForm === this.contrasenaRepetidaForm) {
        let formData = new FormData()
        formData.append("tipoMetodoPago", 'NADA')
        formData.append("numeroMetodoPago", 'NADA')
        formData.append("contrasena", this.contrasenaForm)
        formData.append("nombre", this.nombreForm)
        formData.append("empresa", 'admin')
        formData.append("usuario", this.usuarioForm)
        formData.append("tipoUsuario", this.USUARIO_ADMINISTRACION)
        const url = "../php/crearUsuario.php"
        axios.post(url, formData).then((response) => {
          if (response.data.result) {
            alert(response.data.mensaje + '. TU CORREO CON EL QUE INICIARAS SESION ES: ' + response.data.correo)
            this.reset()

          } else {
            alert(response.data.mensaje)
          }
        }).catch((error) => {
          console.log(error)
          alert("Surgio un error al intentar enviar la peticion de crear usuario")
        })


      } else {
        alert("Las contrasenas no coinciden")
      }

    }, reset() {

      this.$refs.form2.reset()
    },
    filtrarTransacciones() {
      this.cierreFinanciero = 0
      this.cierreInterno = 0
      this.impuestos = 0
      this.cierreTotal = 0
      this.obtenerTransaccionesFinancieras()
      this.obtenerTransaccionesInternas()
      this.cierreTotal = parseFloat(this.cierreFinanciero)

    },

    obtenerTransaccionesInternas() {
      let formData = new FormData()
      formData.append('usuario', this.usuario)
      formData.append('fechaInicio', this.filtroInicioFecha)
      formData.append('fechaFin', this.filtroFinFecha)
      formData.append('tipo', 'GLOBAL')
      axios.post('../php/obtenerTransaccionesInternas.php', formData)
        .then((response) => {
          if (response.data.result) {
            this.datosTransaccionesInternas = response.data.datos
            for (var i = 0; i < response.data.datos.length; i += 1) {
              this.cierreInterno = parseFloat(this.cierreInterno) + parseFloat(response.data.datos[i].monto_total)

            }
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
      formData.append('tipo', 'GLOBAL')
      axios.post('../php/obtenerTransaccionesFinancieras.php', formData)
        .then((response) => {
          if (response.data.result) {
            this.datosTransaccionesFinancieras = response.data.datos
            for (var i = 0; i < response.data.datos.length; i += 1) {
              if (response.data.datos[i].tipo == 'ACREDITACION') {
                this.cierreFinanciero = parseFloat(this.cierreFinanciero) + parseFloat(response.data.datos[i].total)
              } else {
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
    reiniciarFechas: function () {
      this.filtroInicioFecha = ''
      this.filtroFinFecha = ''
    },
    reiniciarUsuarioFechas() {
      this.filtroUsuarioFinFecha = ''
      this.filtroUsuarioInicioFecha = ''
    },
    mostrarUsuarios() {
      let formData = new FormData()
      formData.append('usuario', this.usuario)
      formData.append('tipo', 'dashboardAdmin')
      axios.post('../php/mostrarUsuarios.php', formData)
        .then((response) => {
          if (!response.data.result) {
            alert(response.data.mensaje)
          } else {
            this.usuariosSistema = response.data.datos
          }
        })
        .catch((error) => {
          console.log(error);
        })
    },

    filtrarUsuarios() {

      let formData = new FormData()
      formData.append('usuario', this.usuario)
      formData.append('nombre', this.filtroNombreUsuario)
      formData.append('tipo', 'dashboardAdminFiltros')
      formData.append('fechaInicio', this.filtroUsuarioInicioFecha)
      formData.append('fechaFin', this.filtroUsuarioFinFecha)
      formData.append('usuarioTipo', this.filtroUsuarioTipo)
      axios.post('../php/mostrarUsuarios.php', formData)
        .then((response) => {
          if (!response.data.result) {
            alert(response.data.mensaje)
          } else {
            this.usuariosSistema = response.data.datos
          }

        })
        .catch((error) => {
          console.log(error);
        })
    },
    habilitarUsuario(indice) {
      let formData = new FormData()
      formData.append('usuario', this.usuario)
      formData.append('tipo', 'habilitar')
      formData.append('id', this.usuariosSistema[indice].correo)

      axios.post('../php/mostrarUsuarios.php', formData)
      .then( (response) => {
         if(!response.data.result){
            alert(response.data.mensaje)
         }else{
          alert(response.data.mensaje)
           this.usuariosSistema[indice].estado = 'ACTIVO'
         }
      })
      .catch((error) =>{
          console.log(error);
      })

    }, deshabilitarUsuario(indice) {
      if(this.usuariosSistema[indice].saldo <=100){

      
      let formData = new FormData()
      formData.append('usuario', this.usuario)
      formData.append('tipo', 'deshabilitar')
      formData.append('id', this.usuariosSistema[indice].correo)

      axios.post('../php/mostrarUsuarios.php', formData)
      .then( (response) => {
         if(!response.data.result){
            alert(response.data.mensaje)
         }else{
          alert(response.data.mensaje)
           this.usuariosSistema[indice].estado = 'INACTIVO'
         }
      })
      .catch((error) =>{
          console.log(error);
      })
    }else{
      alert('NO SE PUEDE BLOQUEAR LA CUENTA PORQUE TIENE SALDO EN ELLA')
    }
    },


  },
  vuetify: new Vuetify(),
})
//vista administrador finalizada