const app = new Vue({
    el: '#divLogin',
    data: {
        user: null,
        password: null,
        estado: null,
        message: null
        
    },

    methods:{
        insert: function(){
           let formData = new FormData()
           formData.append('nombre', this.nombre) 
           axios({
               method: 'post',
               url:'http://localhost/finanzas/controllers/empresas.php?action=insert',
               data: formData,
               config: {
                   headers: {'Content-Type': 'multipart/form-data'}
               }
           }).then(function (response){
                console.log(response.data.status)
                app.resetForm()
                app.estado = response.data.status
                app.message = response.data.message
           }).catch(function (response){
            app.estado = response.data.status
            app.message = response.data.message
               console.log(response)
           })
        },
        
        validate: function(){
            let formData = new FormData()
            formData.append('user', this.user)
            formData.append('password', this.password)
            axios({
                method: 'post',
                url:'http://localhost/finanzas/login.php',
                data: formData,
                config: {
                    headers: {'Content-Type': 'multipart/form-data'}
                }
            }).then(function (response){
                console.log(response.data.status)
                app.resetForm()
                app.estado = response.data.status
                app.message = response.data.message
           }).catch(function (response){
            app.estado = response.data.status
            app.message = response.data.message
               console.log(response)
           })
        },

        resetForm: function(){
            this.user = ''
            this.password = ''
        }
    }
})

