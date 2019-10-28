const app = new Vue({
    el: '#divUpdate',
    data: {
        id: null,
        nombre: null,
        activo: null,

        status: null,
        message: null,
    },

    mounted: function(){
        this.getData()
    },



    methods: {
        update: function(){
            let formData = new FormData()
            formData.append('id', this.id)
            formData.append('nombre',this.nombre)
            formData.append('activo',this.activo)
            axios({
                method: 'post',
                url:'http://localhost/finanzas/controllers/empresas.php?action=update',
                data: formData,
                config: {
                    headers: {'Content-Type': 'multipart/form-data'}
                }
            }).then(function(response){
                console.log(response.data.status)
                app.estado = response.data.status
                app.message = response.data.message
            }).catch(function(response){
                console.log(response.data.message)
                app.estado = response.data.status
                app.message = response.data.message
            })
        },

        getData: function(){

            let id = this.obtenerValorParametro('id')

            axios.get("http://localhost/finanzas/controllers/empresas.php?action=view&id=" + id)
            .then(function(response){
                console.log('then:')
                console.log(response)
                app.id = response.data.result.id
                app.nombre = response.data.result.nombre
                app.activo = response.data.result.activo
                app.status = response.data.status
                app.message = response.data.message
            }).catch(function (response){
                console.log('catch')
                console.log(response)
                app.status = response.data.status
                app.message = response.data.message
            })
        },

        obtenerValorParametro: function(sParametroNombre) {
            var sPaginaURL = window.location.search.substring(1);
             var sURLVariables = sPaginaURL.split('&');
              for (var i = 0; i < sURLVariables.length; i++) {
                var sParametro = sURLVariables[i].split('=');
                if (sParametro[0] == sParametroNombre) {
                  return sParametro[1];
                }
              }
             return null;
            }
        
    }
})