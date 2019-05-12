<template>
<div class="container">
	<div class="clearfix" style="padding-top: 30px; padding-bottom: 15px;">
	    <h3 class="float-left">Articulos registrados</h3>
      <router-link v-bind:to="{name: 'articulo_add'}" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> Nuevo articulo </router-link> 
	    
	</div>

  	<table class="table table-striped">
	    <thead>
	      	<tr>
		        <th>Clave articulo</th>
		        <th>Descripción</th>
		        <th></th>
	      	</tr>
	    </thead>
	    <tbody>
	    	<tr v-for="articulo in arrayArticulo" :key="articulo.id">
	    		<td>{{articulo.folio}}</td>
	    		<td>{{articulo.description}}</td>
	    		<td>
	    			<!-- EDITAR -->
            <router-link v-bind:to="{name: 'articulo_update', params: {id: articulo.folio}}" class="btn btn-info btn-xs"><i class="fas fa-edit"></i> Editar </router-link> 
	    		</td>
	    	</tr>
	    </tbody>
  	</table>
</div>
</template>
<script>
    export default {
      data(){
        return{
          arrayArticulo: []
        }
      },
      methods :{
        url(){
          var url = window.location.href;
          var exceso = url.substring(url.lastIndexOf('/'));
          var home = url.replace(exceso,"");
          window.history.pushState("","",home);
        },
        listarArticulo(){
          let me = this;
          axios.get('/articulo').then(function (response) {
            me.arrayArticulo = response.data;
          })
          .catch(function (error) {
            console.log(error);
          });
        },
        eliminarArticulo(id){
        	swal({
	            title: '¿Esta seguro de eliminar este articulo?',
	            type: 'warning',
	            showCancelButton: true,
	            confirmButtonColor: '#3085d6',
	            cancelButtonColor: '#d33',
	            confirmButtonText: 'Aceptar!',
	            cancelButtonText: 'Cancelar',
	            confirmButtonClass: 'btn btn-success',
	            cancelButtonClass: 'btn btn-danger',
	            buttonsStyling: false,
	            reverseButtons: true
          	}).then((result) => {	
            	if (result.value) {	
              		let me = this;

              		axios.delete('/articulo/'+id).then(function (response){
                		me.listarSucursal();
                		swal(
                  			'Eliminado!',
                  			'El articulo ha sido eliminado con éxito.',
                  			'success'
                		)
              		}).catch(function (error) {
                  		console.log(error);
              		});  
            	}else if(
              		result.dismiss === swal.DismissReason.cancel
            	){
          		}
          	}) 
        }
      },
      mounted() {
        //Función para eliminar texto estra en la URL incluido por Vue.Router
        this.url();
        this.listarArticulo();
      }
    }
</script>