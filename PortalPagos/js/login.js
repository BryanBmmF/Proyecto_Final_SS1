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
      tituloLogin: "INICIO DE SESION",
      usuarioLogin:'',
      contrasenaLogin:'',
      usuarioForm:'',
      contrasenaForm:'',
      contrasenaRepetidaForm:'',
      nombreForm: '',
      fechaForm: '2020-01-01',
      correoElectronicoForm: '',
      email: '',
      name: '',
      usuarioRules: [
        v => !!v || 'El usuario es requerido',
      ],
  
      contrasenaRules: [
        v => !!v || 'Contrasena es requerida',
      ],
  
      usuarioFormRules: [
        v => (v && v.length <= 30) || 'El usuario tiene que tener maximo 30 caracteres',
      ],
      contrasenaFormRules: [
        v => (v && v.length <= 10) || 'La Contrasena tiene que tener maximo 10 caracteres',
      ],
      contrasenaRepetidaFormRules: [
        v => (v && v.length <= 10) || 'La Contrasena tiene que tener maximo 10 caracteres',
      ],
      nombreFormRules: [
        v => (v && v.length <= 40) || 'El nombre completo tiene que tener maximo 40 caracteres',
      ],
      correoFormRules:[
        v => /.+@.+\..+/.test(v) || 'Correo no valido',
  
      ],
  
    },
    methods: {
      iniciarSesion () {
        this.$refs.form.validate()
        let formData = new FormData()
        formData.append("usuario",this.usuarioLogin)
        formData.append("contrasena",this.contrasenaLogin)
        const url = "../php/inicioSesion.php"
        axios.post(url,formData).then(function (response) {
          if(response.data.result){
            if(response.data.Estado == 1){
              if(response.data.Tipo == 1){
                window.location.href = '../paginas/usuario.php?user='+response.data.Usuario+'&key='+response.data.Contrasena
              }else if(response.data.Tipo == 2){
                window.location.href = './administrador.php?user='+response.data.Usuario+'&key='+response.data.Contrasena
              }else{
                window.location.href = '../paginas/login.html'
              }
            }else{
              alert("Tu Cuenta de Usuario ha sido bloqueada temporalmente, ponte en contacto con nosotros al correo: jpmazate@gmail.com")
            }
  
          }else{
            alert(response.data.mensaje)
  
          }
        }).catch(function (error){
          alert("Surgio un error al intentar enviar la peticion")
          console.log(error)
        })
  
  
  
      },
      registrarUsuario () {
        this.$refs.form2.validate()
        if(this.contrasenaForm === this.contrasenaRepetidaForm){
  
        let formData = new FormData()
        formData.append("usuario",this.usuarioForm)
        formData.append("contrasena",this.contrasenaForm)
        formData.append("nombre",this.nombreForm)
        formData.append("correo",this.correoElectronicoForm)
        formData.append("fecha",this.fechaForm)
        formData.append("imagen",'NULL')
        formData.append("confianza",0)
        formData.append("tipo",1)
        const url = "../php/crearUsuario.php"
        axios.post(url,formData).then(function (response) {
                    if(response.data.result){
                      alert(response.data.mensaje)
                      window.location.href = './login.html'
                    }else{
                      alert(response.data.mensaje)
                    }
        }).catch(function (error){
          console.log(error)
          alert("Surgio un error al intentar enviar la peticion")
        })
      }else{
        alert("Las contrasenas no coinciden")
      }
      },
      reset () {
        this.$refs.form.reset()
        this.$refs.form2.reset()
      },
  
      cambiarBanderaLogin (){
          if(this.mostrarLogin){
            this.tituloLogin= "FORMULARIO DE CREACION USUARIO"
          }else {
            this.tituloLogin= "INICIO DE SESION"
          }
          this.mostrarLogin = !this.mostrarLogin
      },
      reiniciarValores(){
        this.usuarioLogin = ''
        this.contrasenaLogin =''
        this.usuarioForm=''
        this.contrasenaForm=''
        this.contrasenaRepetidaForm =''
        this.nombreForm= ''
        this.fechaForm= ''
        this.correoElectronicoFor= ''
      },
    },
    vuetify: new Vuetify(),
  })