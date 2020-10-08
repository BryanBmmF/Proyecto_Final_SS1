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
      mostrar:1,
      mostrarInicio:3,
      estado : 0,
      offsetTop: 0,
      selectedFile:null,
      foto:null,
      foto2: null,
      foto3:null,
      perfilImagen: "",
      correo:'',
      nombreCompleto:'',
      confianza:0,
      valid2: true,
      valid4: true,

      //anuncios
      titulo:'',
      categoria:'',
      caracGenerales:'',
      caracEspecificas:'',
      lugar:'',
      vare: 'dede',
      vareAux: 'hola',

      //hitos
      hitoTitulo:'',
      hitoCategoria:'',
      hitoDetalle:'',
      hitoFecha:'2000-01-01',
      hitoFuente:'',
      hitoComentario:'',


      //verHitos

      hitosArreglo:[],

      //ver anuncios
      verPublicacion:0,
      anunciosArreglo:[],

      //DASHBOARD
      mostrarDashboard:0,
      anunciosDashboard:[],
      hitosDashboard:[],
      comentariosHitos:[],
      escribirComentarioHitos:[],
      botonesMostrarComentarios:[],
      variableAuxiliarIdHito:'',

      //filtro anuncios
      filtroLugar:'',
      filtroCategoria:'',
      filtroUsuario:'',
      filtroInicioFecha:'',
      filtroFinFecha:'',
      mostrarFiltrosAnuncios:false,

      //filtro hitos
      filtroHitoCategoria:'',
      filtroHitoUsuario:'',
      filtroHitoInicioFecha:'',
      filtroHitoFinFecha:'',
      filtroHitoPopularidad:'',
      filtroHitoAprobado:'',
      mostrarFiltrosHitos:false,

      hitoItemsAprobados: [
          'Aprobado',
          'No Aprobados'
        ],

      hitoItemsPopularidad: [
          'Likes',
          'Dislikes'
        ],
      hitoItemsCategoria: [
          'Peligroso',
          'Impactante',
          'Testimonio',
          'Otros',
        ],

        //vista informacion general
        imagenesInfoGeneral:[],
        carrousel:0,
        filtroCategoriaInformacion:'',
        mostrarFiltrosInformacionGeneral:false,
        hitoDetalleRules: [
          v => (v && v.length <= 200) || 'El maximo es de 200 caracteres',
        ],

        hitoTituloRules: [
          v => (v && v.length <= 40) || 'El titulo tiene que tener maximo 40 caracteres',
        ],

        hitoFuenteRules: [
          v => (v && v.length >0)  || 'Debe de tener fuente del hito',
        ],
        hitoComentarioRules: [
          v => (v && v.length <= 200) || 'El maximo es de 200 caracteres',
        ],
      itemsCategoria: [
          'Juegos',
          'Vehiculos',
          'Comida',
          'Otros',
        ],
        tituloRules: [
          v => (v && v.length <= 40) || 'El titulo tiene que tener maximo 40 caracteres',
        ],
        caracGeneralesRules: [
          v => (v && v.length <= 200) || 'El maximo es de 200 caracteres',
        ],
        caracEspecificasRules: [
          v => (v && v.length <= 200) || 'El maximo es de 200 caracteres',
        ],
        lugarRules: [
          v => (v && v.length <= 50) || 'El maximo es de 50 caracteres',
        ],

      icons: ['mdi-rewind', 'mdi-play', 'mdi-fast-forward'],

      //cosas del portal de pagos
      saldo:0,
      nombreCompleto:'',
      codigoEmpresa:'',
      empresa:'',
      tipoUsuario: '',
      tarjetaCredito: '',
      cuentaFinanciera: '',
      estadoCuenta:'',


  },
  mounted: function(){


  },
  methods:{
    validarDatos () {
      if(this.usuario==='USUARIO' && this.contrasena===''){
        window.location.href = './login.html'
      }else{
      let formData = new FormData()
      formData.append("usuario",this.usuario)
      formData.append("contrasena",this.contrasena)
      const url = "../php/validacionInicioSesion.php"
      axios.post(url,formData).then((response) => {
        if(response.data.result === false){
          window.location.href = './login.html'
        }else{
          if(response.data.datos[0].estado === 'ACTIVO'){
            this.saldo = response.data.datos[0].saldo
            this.nombreCompleto = response.data.datos[0].nombre_completo
            this.codigoEmpresa = response.data.datos[0].codigo_empresa
            this.empresa = response.data.datos[0].empresa
            this.tipoUsuario = response.data.datos[0].tipo
            this.tarjetaCredito = response.data.datos[0].tarjeta_credito
            this.cuentaFinanciera = response.data.datos[0].cuenta_financiera
            this.estadoCuenta = response.data.datos[0].estado
          }else{            
            window.location.href = './login.html'

          }
        }



      }).catch( (error)=>{
        alert("Surgio un error al intentar enviar la peticion")
        console.log(error)
      })
    }



    },
    hug: function(){
      this.vare='9'
    },
    onFileSelected(event){
      this.selectedFile = event
    },

    uploadFile: function(){

      this.file = this.foto
      //this.file = this.$refs.file.files[0];
      let formData = new FormData()
      formData.append('file', this.file)
      formData.append('usuario', this.usuario)
      axios.post('../php/subirImagenPerfil.php', formData,
      {
         headers: {
           'Content-Type': 'multipart/form-data'
         }
      })
      .then( (response) => {
         if(!response.data.result){
            console.log('File not uploaded.')
         }else{
            console.log("estoy cambiando una imagen correctamente")
            this.perfilImagen = response.data.path
         }

      })
      .catch((error) =>{
          console.log(error);
      })


    },

    registrarAnuncio: function(){
      this.file = this.foto2
      //this.file = this.$refs.file.files[0];
      let formData = new FormData()
      formData.append('file', this.file)
      formData.append('titulo', this.titulo)
      formData.append('usuario', this.usuario)
      formData.append('generales', this.caracGenerales)
      formData.append('especificas', this.caracEspecificas)
      formData.append('categoria', this.categoria)
      formData.append('lugar', this.lugar)

      axios.post('../php/registrarAnuncio.php', formData,
      {
         headers: {
           'Content-Type': 'multipart/form-data'
         }
      })
      .then( (response) => {
         if(!response.data.result){
            alert(response.data.mensaje)
         }else{
           alert(response.data.mensaje)
           this.mostrar=1
         }

      })
      .catch((error) =>{
          console.log(error);
      })
    },

      registrarHito: function(){
      this.file = this.foto3
      let formData = new FormData()
      formData.append('file', this.file)
      formData.append('titulo', this.hitoTitulo)
      formData.append('categoria', this.hitoCategoria)
      formData.append('usuario', this.usuario)
      formData.append('detalle', this.hitoDetalle)
      formData.append('fecha', this.hitoFecha)
      formData.append('fuente', this.hitoFuente)
      formData.append('comentario', this.hitoComentario)
      axios.post('../php/registrarHito.php', formData,
      {
         headers: {
           'Content-Type': 'multipart/form-data'
         }
      })
      .then( (response) => {
         if(!response.data.result){
            alert(response.data.mensaje)
         }else{
           alert(response.data.mensaje)
           this.mostrar=1
         }

      })
      .catch((error) =>{
          console.log(error);
      })
    },

     mostrarAnuncios(){
       let formData = new FormData()
       formData.append('usuario', this.usuario)
       formData.append('tipo', 'perfil')
       axios.post('../php/mostrarAnuncios.php', formData)
       .then( (response) => {
          if(!response.data.result){
             alert(response.data.mensaje)
          }else{
            this.anunciosArreglo = response.data.datos
            console.log(this.anunciosArreglo)
          }

       })
       .catch((error) =>{
           console.log(error);
       })
     },
     mostrarHitos(){
       let formData = new FormData()
       formData.append('usuario', this.usuario)
       formData.append('tipo', 'perfil')
       axios.post('../php/mostrarHitos.php', formData)
       .then( (response) => {
          if(!response.data.result){
             alert(response.data.mensaje)
          }else{
            this.hitosArreglo = response.data.datos
            console.log(this.hitosArreglo)
          }

       })
       .catch((error) =>{
           console.log(error);
       })
     },
     verAnuncios: function(){
       this.verPublicacion = 1
       this.mostrarAnuncios()
     },
     verHitos: function(){
       this.verPublicacion = 2
       this.mostrarHitos()
     },
     verDashboardAnuncios: function(){
       this.mostrarDashboard = 1;
       this.mostrarAnunciosGenerales()
     },

     mostrarAnunciosGenerales(){
       let formData = new FormData()
       formData.append('usuario', this.usuario)
       formData.append('tipo', 'dashboard')
       axios.post('../php/mostrarAnuncios.php', formData)
       .then( (response) => {
          if(!response.data.result){
             alert(response.data.mensaje)
          }else{
            this.anunciosDashboard = response.data.datos
            console.log(this.anunciosDashboard)
          }

       })
       .catch((error) =>{
           console.log(error);
       })
     },
     filtrarAnuncios(){
       console.log('categoria: '+this.filtroCategoria)
       console.log('vendedor: '+this.filtroUsuario)
       console.log('iniciofecha: '+this.filtroInicioFecha)
       console.log('finFecha: '+this.filtroFinFecha)


       let formData = new FormData()
       formData.append('usuario', this.usuario)
       formData.append('tipo', 'dashboardFiltros')
       formData.append('categoria', this.filtroCategoria)
       formData.append('lugar', this.filtroLugar)
       formData.append('vendedor', this.filtroUsuario )
       formData.append('fechaInicio', this.filtroInicioFecha )
       formData.append('fechaFin', this.filtroFinFecha )
       axios.post('../php/mostrarAnuncios.php', formData)
       .then( (response) => {
          if(!response.data.result){
             alert(response.data.mensaje)
          }else{
            this.anunciosDashboard = response.data.datos
            console.log(this.anunciosDashboard)
          }

       })
       .catch((error) =>{
           console.log(error);
       })
     }, filtrarHitos(){
       console.log('categoria: '+this.filtroHitoCategoria)
       console.log('vendedor: '+this.filtroHitoUsuario)
       console.log('iniciofecha: '+this.filtroHitoInicioFecha)
       console.log('finFecha: '+this.filtroHitoFinFecha)
       console.log('Popularidad: '+this.filtroHitoPopularidad)
       console.log('Aprobado: '+this.filtroHitoAprobado)



       let formData = new FormData()
       formData.append('usuario', this.usuario)
       formData.append('tipo', 'dashboardFiltros')
       formData.append('categoria', this.filtroHitoCategoria)
       formData.append('vendedor', this.filtroHitoUsuario )
       formData.append('fechaInicio', this.filtroHitoInicioFecha )
       formData.append('fechaFin', this.filtroHitoFinFecha )
       formData.append('popularidad', this.filtroHitoPopularidad )
       formData.append('aprobado', this.filtroHitoAprobado)
       axios.post('../php/mostrarHitos.php', formData)
       .then( (response) => {
          if(!response.data.result){
             alert(response.data.mensaje)
          }else{
            this.hitosDashboard = response.data.datos
            var i=0
            this.comentariosHitos=[]
            for (i = 0; i < response.data.datos.length; i++) {
              this.escribirComentarioHitos.push({ 'IdHito': response.data.datos[i].Id , 'Comentario':'','Imagen':''});
              this.botonesMostrarComentarios.push({ 'Mostrar':false});
              this.mostrarComentariosHitos(response.data.datos[i].Id)
            }

            console.log(this.hitosDashboard)
            console.log(this.escribirComentarioHitos)
            console.log(this.comentariosHitos)
          }

       })
       .catch((error) =>{
           console.log(error);
       })
     },
     mostrarHitosGenerales(){
       let formData = new FormData()
       formData.append('usuario', this.usuario)
       formData.append('tipo', 'dashboard')
       axios.post('../php/mostrarHitos.php', formData)
       .then( (response) => {
          if(!response.data.result){
             alert(response.data.mensaje)
          }else{
            this.hitosDashboard = response.data.datos
            var i=0
            this.comentariosHitos=[]
            for (i = 0; i < response.data.datos.length; i++) {
              this.escribirComentarioHitos.push({ 'IdHito': response.data.datos[i].Id , 'Comentario':'','Imagen':''});
              this.botonesMostrarComentarios.push({ 'Mostrar':false});
              this.mostrarComentariosHitos(response.data.datos[i].Id)
            }

            console.log(this.hitosDashboard)
            console.log(this.escribirComentarioHitos)
            console.log(this.comentariosHitos)
          }
       })
       .catch((error) =>{
           console.log(error);
       })
     },
     mostrarComentariosHitos(parametro){
       let formData = new FormData()
       formData.append('usuario', this.usuario)
       formData.append('tipo', 'dashboard')
       formData.append('idHito', parametro)
       axios.post('../php/mostrarComentarios.php', formData)
       .then( (response) => {
          if(!response.data.result){
             alert(response.data.mensaje)
          }else{
            if(response.data.datos.length>0){
                this.comentariosHitos.push(response.data.datos)
            }

          }
       })
       .catch((error) =>{
           console.log(error);
       })
     },
     crearComentario(indice){


       this.file = this.escribirComentarioHitos[indice].Imagen
       let formData = new FormData()
       formData.append('file', this.file)
       formData.append('comentario', this.escribirComentarioHitos[indice].Comentario)
       formData.append('idHito', this.escribirComentarioHitos[indice].IdHito)
       formData.append('usuario', this.usuario)
       formData.append('tipo', 'crearComentario')

       axios.post('../php/crearComentario.php', formData,
       {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
       })
       .then( (response) => {
          if(!response.data.result){
             alert(response.data.mensaje)
          }else{
            alert(response.data.mensaje)
            this.mostrar=1
          }

       })
       .catch((error) =>{
           console.log(error);
       })

     },


     verDashboardHitos: function(){
       this.mostrarDashboard = 2;
       this.mostrarHitosGenerales()
     },

     verAnalisisDatos:function(){
       this.mostrarDashboard = 3;
     },
     reiniciarFechas:function(){
       this.filtroInicioFecha = ''
       this.filtroFinFecha = ''
     },
     reiniciarFiltrosHitos:function(){
       this.filtroHitoInicioFecha = ''
       this.filtroHitoFinFecha = ''
       this.filtroHitoUsuario=''
       this.filtroHitoCategoria=''
       this.filtroHitoPopularidad=''
     },
     reiniciarFechasHitos:function(){
       this.filtroHitoInicioFecha = ''
       this.filtroHitoFinFecha = ''

     },
     interaccionHito(valor, tipo){

       if(tipo == '1'){
         let formData = new FormData()
         formData.append('usuario', this.usuario)
         formData.append('idHito',this.hitosDashboard[valor].Id)
         formData.append('tipo', 'like')
         axios.post('../php/interaccionesHitos.php', formData)
         .then( (response) => {
            if(!response.data.result){
               alert(response.data.mensaje)
            }else{
              if(response.data.accion=='like'){
                this.hitosDashboard[valor].Likes = String(parseInt(this.hitosDashboard[valor].Likes,10)+1)
              }else if(response.data.accion=='likeCambiado'){
                this.hitosDashboard[valor].Likes = String(parseInt(this.hitosDashboard[valor].Likes,10)+1)
                this.hitosDashboard[valor].Dislikes = String(parseInt(this.hitosDashboard[valor].Dislikes,10)-1)

              }else if(response.data.accion=='igualLike'){
                alert(response.data.mensaje)
              }

            }
         })
         .catch((error) =>{
             console.log(error);
         })

       }else{
         let formData = new FormData()
         formData.append('usuario', this.usuario)
         formData.append('idHito',this.hitosDashboard[valor].Id)
         formData.append('tipo', 'dislike')
         axios.post('../php/interaccionesHitos.php', formData)
         .then( (response) => {
            if(!response.data.result){
               alert(response.data.mensaje)
            }else{
              if(response.data.accion=='dislike'){
                  this.hitosDashboard[valor].Dislikes = String(parseInt(this.hitosDashboard[valor].Dislikes,10)+1)
              }else if(response.data.accion=='dislikeCambiado'){
                this.hitosDashboard[valor].Likes = String(parseInt(this.hitosDashboard[valor].Likes,10)-1)
                this.hitosDashboard[valor].Dislikes = String(parseInt(this.hitosDashboard[valor].Dislikes,10)+1)
              }else if(response.data.accion=='igualDislike'){
                alert(response.data.mensaje)
              }

            }
         })
         .catch((error) =>{
             console.log(error);
         })
       }

     },
     redireccionarLogin(){
       window.location.href = './login.html'
     },
     cerrarSesion(){
       window.location.href = './login.html'
     },
     verPublicaciones(){
       let formData = new FormData()
       formData.append('usuario', this.usuario)
       formData.append('tipo', 'dashboard')
       axios.post('../php/mostrarInformacionGeneral.php', formData)
       .then( (response) => {
          if(!response.data.result){
             alert(response.data.mensaje)
          }else{
            console.log(response.data.datos)
            this.imagenesInfoGeneral = response.data.datos
          }
       })
       .catch((error) =>{
           console.log(error);
       })
       this.mostrar= 4
       this.mostrarInicio=4


     },
     despublicarAnuncio(indice){
       let formData = new FormData()
       formData.append('usuario', this.usuario)
       formData.append('tipo', 'despublicar')
       formData.append('id', this.anunciosArreglo[indice].Id)
       axios.post('../php/mostrarAnuncios.php', formData)
       .then( (response) => {
          if(!response.data.result){
             alert(response.data.mensaje)
          }else{
            this.anunciosArreglo[indice].Estado = 2
            console.log(response.data.mensaje)
          }

       })
       .catch((error) =>{
           console.log(error);
       })
     },
     despublicarHito(indice){
       let formData = new FormData()
       formData.append('usuario', this.usuario)
       formData.append('tipo', 'despublicar')
       formData.append('id', this.hitosArreglo[indice].Id)
       axios.post('../php/mostrarHitos.php', formData)
       .then( (response) => {
          if(!response.data.result){
             alert(response.data.mensaje)
          }else{

            this.hitosArreglo[indice].Estado = 2
            console.log(response.data.mensaje)
          }

       })
       .catch((error) =>{
           console.log(error);
       })
     },





  },

  vuetify: new Vuetify(),
})
