const app = new Vue({
    el: '#divDelete',
    data:{
        id: null,
        nombre: null,
        activo: null,

        status: null,
        message: null
    },

    mounted: function(){
        this.getData()
    },

    methods: {
        getData: function(){
            let id = this.obtenerValorParametro('id')
            axios.get("http://localhost/finanzas/controllers/empresas.php?action=view&id=" +  id)
            .then(function(response){
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

        deleteItem: function(){
            formData = new FormData()
            formData.append('id',this.id)
            axios({
                method: 'post',
                url:'http://localhost/finanzas/controllers/empresas.php?action=delete',
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