new Vue({
    el: '#app',
    data: {
      valorN: 1
  
    },
    methods: {
      cambiar(){
        window.location.href = './paginas/login.html'
  
      }
    },
    vuetify: new Vuetify(),
  })