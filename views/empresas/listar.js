var app=new Vue({
    el: "#lista",
    data: {
        id: null,
        nombre: null,
        lista: []

    },
    mounted:function() {
        this.listar()
    },
    methods:{
        listar:function(){
        axios.get("http://localhost/finanzas/controllers/empresas.php?action=list")
        .then(function(response){
            app.lista = response.data
            })
        }
    }

})