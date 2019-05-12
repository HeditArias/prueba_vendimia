<template>
<div class="container" style="padding-top: 30px;">
<div class="card">
    <div class="card-header bg-primary text-white">
      	<h3>Registro de clientes</h3>
    </div>
    <div class="card-body">
      	<h6 class="text-right">Clave: {{folio}}</h6>

	    <div class="row">
	        <div class="col-md-6 col-sm-12 col-xs-12">
		        <div class="form-group">
		            <label for="text">Nombre</label>
		            <input class="form-control" v-model="name" onkeypress="return soloLetras(event)">
		        </div>

	            <div class="form-group">
		            <label for="text">Apellido Paterno</label>
		            <input class="form-control" v-model="last_name" onkeypress="return soloLetras(event)">
	            </div>

	            <div class="form-group">
		            <label for="text">Apellido Materno</label>
		            <input class="form-control" v-model="mother_last_name" onkeypress="return soloLetras(event)">
	            </div>

	            <div class="form-group">
		            <label for="text">RFC</label>
		            <input class="form-control" v-model="rfc">
	            </div>
	        </div>
	    </div>
    </div>
</div>
  
<div class="float-right" style="padding-top: 15px; padding-bottom: 15px;">
	<button type="button" class="btn btn-success" @click="registrarCliente()"><i class="fas fa-save"></i> Guardar</button>
  	<button type="button" class="btn btn-success" @click="cancelar()"><i class="fas fa-ban"></i> Cancelar</button>
</div>
</div>
</template>
<script>
	export default {
    data(){
      return{
        folio: 0,
        name: "",
        last_name: "",
        mother_last_name: "",
        rfc: "",
      }
    },
    created: function(){
    	Axios.get('/cliente/folio').then((response)=>{
    		this.folio = response.data;
    	});
    },
    methods :{
      url(){
        var url = window.location.href;
        var exceso = url.substring(url.lastIndexOf('/'));
        var home = url.replace(exceso,"");
        window.history.pushState("","",home);
      },
    	registrarCliente(){
        let me = this;
        if (this.validarCliente()){
          return;
        }

        axios.post('/cliente',{
        	'name': this.name,
        	'last_name': this.last_name,
        	'mother_last_name': this.mother_last_name,
        	'rfc': this.rfc,
        }).then(function (response){
          if(response.data == "existe"){
            swal(
              '¡Error!',
              'Ese cliente ya ha sido registrado',
              'warning'
            );
          }else{
            swal(
              '¡Bien hecho!',
              'El cliente ha sido registrado correctamente',
              'success'
            );
            me.cancelar();
          }
        }).catch(function (error) {
            console.log(error);
        });
      },
      validarCliente(){
      	var aux;
      	if(!this.name){ aux = " el nombre";}
      	if(!this.last_name){aux = " el apellido paterno";}
      	if(!this.mother_last_name){ aux = " el apellido materno";}
      	if(!this.rfc){ aux = " el RFC";}
      	
      	if(aux != null){
      		swal(
            '¡Error!',
            'No es posible continuar, debe ingresar'+ aux +' es obligatorio',
            'warning'
          );
      	}
      },
      cancelar(){
        this.$router.push({path: 'cliente_index'});
      }
    },
    mounted() {
      //Función para eliminar texto estra en la URL incluido por Vue.Router
      this.url();
      this.listarArticulo();
    }
  }
</script>