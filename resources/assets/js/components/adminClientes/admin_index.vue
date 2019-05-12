<template>
<div class="container">
	<div class="clearfix" style="padding-top: 30px; padding-bottom: 15px;">
	    <h3 class="float-left">Clientes registrados</h3>
	    <router-link v-bind:to="{name: 'cliente_add'}" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> Nuevo cliente </router-link>
	</div>

  	<table class="table table-striped">
	    <thead>
	      	<tr>
		        <th>Clave Cliente</th>
		        <th>Nombre</th>
		        <th></th>
	      	</tr>
	    </thead>
	    <tbody>
	    	<tr v-for="cliente in arrayCliente" :key="cliente.id">
	    		<td>{{cliente.folio}}</td>
	    		<td>{{cliente.name}}</td>
	    		<td>
	    			<!-- EDITAR -->
            <router-link v-bind:to="{name: 'cliente_update', params: {id: cliente.folio}}" class="btn btn-info btn-xs"><i class="fas fa-edit"></i> Editar </router-link> 
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
          arrayCliente: []
        }
      },
      methods :{
        url(){
            var url = window.location.href;
            var exceso = url.substring(url.lastIndexOf('/'));
            var home = url.replace(exceso,"");
            window.history.pushState("","",home);
        },
        listarCliente(){
          let me = this;
          axios.get('/cliente').then(function (response) {
            me.arrayCliente = response.data;
          })
          .catch(function (error) {
            console.log(error);
          });
        }
      },
      mounted() {
        this.url();
        this.listarCliente();
      }
    }
</script>