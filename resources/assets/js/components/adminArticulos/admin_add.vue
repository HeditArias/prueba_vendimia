<template>
<div class="container" style="padding-top: 30px;">
<div class="card">
  <div class="card-header bg-primary text-white">
    <h3>Registro de articulo</h3>
  </div>
  <div class="card-body">
    <h6 class="text-right">Clave: {{folio}}</h6>

    <div class="row">
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
          <label for="text">Descrippción</label>
          <input class="form-control" v-model="description">
        </div>

        <div class="form-group">
          <label for="text">Modelo</label>
          <input class="form-control" v-model="model">
        </div>

        <div class="form-group">
          <label for="text">Precio</label>
          <input class="form-control" v-model="price" onkeypress="return justNumbers(event)">
        </div>

        <div class="form-group">
          <label for="text">Existencia</label>
          <input type="number" class="form-control" v-model="existence">
        </div>
      </div>
    </div>
  </div>
</div>
  
<div class="float-right" style="padding-top: 15px; padding-bottom: 15px;">
	<button type="button" class="btn btn-success" @click="registrarArticulo()"><i class="fas fa-save"></i> Guardar</button>
  <button type="button" class="btn btn-success" @click="cancelar()"><i class="fas fa-ban"></i> Cancelar</button>
</div>
</div>
</template>

<script>
	export default {
    data(){
      return{
        folio: 0,
        description: "",
        model: "",
        price: "",
        existence: 0,
      }
    },
    created: function(){
    	Axios.get('/articulo/folio').then((response)=>{
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
    	registrarArticulo(){
        let me = this;
        if (this.validarArticulo()){
          return;
        }

        axios.post('/articulo',{
        	'description': this.description,
        	'model': this.model,
        	'price': this.price,
        	'existence': this.existence,
        }).then(function (response){
          if(response.data == "existe"){
            swal(
              '¡Error!',
              'Ese articulo ya ha sido registrado',
              'warning'
            );
          }else{
            swal(
              '¡Bien hecho!',
              'El articulo ha sido registrado correctamente',
              'success'
            );
            me.cancelar();
          }
        }).catch(function (error) {
            console.log(error);
        });
      },
      validarArticulo(){
      	var aux;
      	if(!this.price){ aux = " el precio";}
      	if(!this.model){aux = " el modelo";}
      	if(!this.description){ aux = " la descrippción";}
      	
      	if(aux != null){
      		swal(
            '¡Error!',
            'No es posible continuar, debe ingresar'+ aux +' es obligatorio',
            'warning'
          );
      	}
      },
      cancelar(){
        this.$router.push({path: 'articulo_index'});
      }
    },
    mounted() {
      //Función para eliminar texto estra en la URL incluido por Vue.Router
      this.url();
    }
  }
</script>