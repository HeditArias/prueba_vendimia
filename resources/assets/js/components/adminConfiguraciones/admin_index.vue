<template>
<div class="container" style="padding-top: 30px;">
<div class="card">
	<div class="card-header bg-primary text-white">
	  	<h3>Configuración general</h3>
	</div>

	<div class="card-body">
	  	<div class="row">
		    <div class="col-md-6 col-sm-12 col-xs-12">
			    <div class="form-group">
			        <label>Tasa Financiamiento</label>
			        <input type="text" class="form-control" v-model="config.financing_rate" onkeypress="return justNumbers(event)">
			    </div>

			    <div class="form-group">
			        <label>% Enganche</label>
			        <input type="text" class="form-control" v-model="config.percentage_hitch" onkeypress="return justNumbers(event)">
			    </div>

			    <div class="form-group">
			        <label for="text">Plazo Máximo</label>
			        <select class="form-control" v-model="config.maximum_term">
			        	<option value="3">3 meses</option>
						    <option value="6">6 meses</option>
						    <option value="9">9 meses</option>
						    <option value="12">12 meses</option>
			        </select>
			    </div>
		    </div>
	  	</div>
	</div>
</div>

<div class="float-right" style="padding-top: 15px; padding-bottom: 15px;">
	<button type="button" class="btn btn-success" @click="configuracion()"><i class="fas fa-save"></i> Guardar</button>
  <button type="button" class="btn btn-success" @click="cancelar()"><i class="fas fa-ban"></i> Cancelar</button>
</div>
</div>
</template>
<script>
	export default {
    data(){
      return{
      	config: {
      		financing_rate: "",
      		percentage_hitch: "",
      		maximum_term: 3
      	},
      	opc: 0
      }
    },
    created: function(){
	    let uri = '/confi';
	    Axios.get(uri).then((response) => {
	    	// console.log(response.data);
	    	var respuesta = response.data;
	    	if(respuesta == 0){
	    		this.opc = 1;
	    	}else{
	    		this.config = response.data;
	    		this.opc = 2;
	    	}
	    });
		},
    methods :{
      url(){
          var url = window.location.href;
          var exceso = url.substring(url.lastIndexOf('/'));
          var home = url.replace(exceso,"");
          window.history.pushState("","",home);
      },
    	configuracion(){
        let me = this;
        if (this.validarArticulo()){
          return;
        }

        if(this.opc == 1){
        	me.agregarConfi();
        }

        if(this.opc ==2){
        	me.editarConfi();
        }
      },
      agregarConfi(){
      	axios.post('/confi',this.config).then(function (response){
          swal(
              '¡Bien hecho!',
              'La configuración ha sido registrada',
              'success'
            );
        }).catch(function (error) {
            console.log(error);
        });
        this.cancelar();
      },
      editarConfi(){
      	var id = 1;
      	let uri = '/confi/'+id+'/edit';
        Axios.patch(uri, this.config).then((response) => {
      		swal(
            '¡Bien hecho!',
            'La configuración ha sido registrada',
            'success'
          );
        });
        this.cancelar();
      },
      validarArticulo(){
      	var aux;

      	if(this.financing_rate = ''){ aux = " tasa de financiamiento";}
      	if(this.percentage_hitch = ''){aux = " el porcentaje de enganche";}
      	if(this.maximum_term = ''){ aux = " la plazo máximo";}
      	
      	if(aux != null){
      		swal(
            '¡Error!',
            'No es posible continuar, debe ingresar'+ aux +' es obligatorio',
            'warning'
          );
      	}
      },
      cancelar(){
        this.$router.push({path: '/'});
      }
    },
    mounted() {
      this.url();
    }
  }
</script>