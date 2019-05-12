<template>
<div class="container">
	<div class="clearfix" style="padding-top: 30px; padding-bottom: 15px;">
	    <h3 class="float-left">Ventas activadas</h3>
	    <button @click="nuevaVenta()" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> Nueva Venta </button>
	</div>

  	<table class="table table-striped">
	    <thead>
	      	<tr>
		        <th>Folio venta</th>
		        <th>Clave cliente</th>
		        <th>Nombre</th>
		        <th>Total</th>
		        <th>Fecha</th>
	      	</tr>
	    </thead>
	    <tbody>
	    	<tr v-for="venta in arrayVenta" :key="venta.id">
	    		<td>{{venta.folio}}</td>
	    		<td>{{venta.id_cliente}}</td>
	    		<td>{{venta.name}}</td>
	    		<td>{{venta.total}}</td>
	    		<td>{{venta.fecha}}</td>
	    	</tr>
	    </tbody>
  	</table>
</div>
</template>
<script>
    export default {
      data(){
        return{
          arrayVenta: []
        }
      },
      methods :{
        url(){
            var url = window.location.href;
            var exceso = url.substring(url.lastIndexOf('/'));
            var home = url.replace(exceso,"");
            window.history.pushState("","",home);
        },
        listarVenta(){
          let me = this;
          axios.get('/venta').then(function (response) {
            me.arrayVenta = response.data;
          })
          .catch(function (error) {
            console.log(error);
          });
        },
        nuevaVenta(){
          let uri = '/confi';
          Axios.get(uri).then((response) => {
            // console.log(response.data);
            var respuesta = response.data;
            if(respuesta == 0){
              swal(
                '¡Error!',
                'No cuentas con las configuraciones pertinentes para continuar',
                'warning'
              );
            }else{
              this.$router.push({path: 'venta_add'});
            }
          });
        }
      },
      mounted() {
        this.url();
        this.listarVenta();
      }
    }
</script>