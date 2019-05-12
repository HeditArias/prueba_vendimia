<template>
<div class="container" style="padding-top: 30px;">
<div class="card">
	<div class="card-header bg-primary text-white">
	  	<h3>Registro de ventas</h3>
	</div>
	
	<div class="card-body">
	  	<h6 class="text-right">Folio venta: {{folio}}</h6>

		<form class="form-inline" style="padding-bottom: 15px;">
			<label for="email2" class="mb-2 mr-sm-2">Cliente:</label>
			<v-select
	            @search="selectCliente"
	            label="cliente"
	            :options="arrayCliente"
	            placeholder="Buscar Clientes..."
	            @input="getDatosCliente"  
	            class="w-50"                  
	        >
	        <span slot="no-options" @click="$refs.select.open = false">
    			¡Sin resultados, no hay opciones coincidentes!
  			</span>
	        </v-select> 
			<label for="pwd2" class="mb-2 mr-sm-2 p-2"> {{rfc}}</label>
		</form>

		<form class="form-inline" style="padding-bottom: 15px;">
			<label for="email2" class="mb-2 mr-sm-2">Articulo:</label>
			<v-select
	            @search="selectArticulo"
	            label="description"
	            :options="arrayArticulo"
	            placeholder="Buscar Articulo..."
	            @input="getDatosArticulo"  
	            class="w-50"    
	            v-model="codigo"              
	        > 
	        <span slot="no-options" @click="$refs.select.open = false">
    			¡Sin resultados, no hay opciones coincidentes!
  			</span>
	        </v-select> 
	        <button @click="agregarDetalle()" type="button" class="btn btn-secondary btn-sm" style="margin-left: 10px;">
                <i class="fas fa-plus"></i>
            </button>
		</form>


	  	<table class="table">
		    <thead style="background-color: #CEECF5;">
		      	<tr>
		      		<th></th>
			        <th>Descripción Articulo</th>
			        <th>Modelo</th>
			        <th>Cantidad</th>
			        <th>Precio</th>
			        <th>Importe</th>
			        
		      	</tr>
		    </thead>
		    <tbody v-if="arrayDetalle.length">
		    	<tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
		    		<td>
                    	<button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
		    		<td>{{detalle.descripcion}}</td>
		    		<td>{{detalle.modelo}}</td>
		    		<td>
                        <input v-model="detalle.cantidad" type="number" class="form-control">
                        <span style="color:red;" v-show="detalle.cantidad>detalle.stock">Cantidad insuficiente</span>
                    </td>
                    <td>${{detalle.precio_articulo = (detalle.precio*detalle.aux).toFixed(2)}}</td>
                    <td>${{detalle.importe = (detalle.precio_articulo*detalle.cantidad).toFixed(2)}}</td>
                    
		    	</tr>
		    	<tr style="background-color: #CEECF5;">
                    <td colspan="5" align="right"><strong>Enganche:</strong></td>
                    <td>${{total_enganche=(calcularTotalEnganche).toFixed(2)}}</td>
                </tr>
                <tr style="background-color: #CEECF5;">
                    <td colspan="5" align="right"><strong>Bonificación Enganche:</strong></td>
                    <td>${{total_bonificacion=(calcularTotalBonificacion).toFixed(2)}}</td>
                </tr>
                <tr style="background-color: #CEECF5;">
                    <td colspan="5" align="right"><strong>Total:</strong></td>
                    <td>${{total=(calcularTotal).toFixed(2)}}</td>
                </tr>
		    </tbody>
	  	</table>

	  	<template v-if="arrayMens !=0">
			<table class="table">
				<thead>
					<tr style="background-color: #CEECF5;">
					<th colspan="5" style="text-align: center;">Abonos mensuales</th>
					</tr>
				</thead>
				<tbody style="background-color: #f2f2f2;">
					<tr class="" v-for="mensu in arrayMens" :key="mensu.id">
					<td>{{mensu.plazo}} Abonos de </td>
				    <td>${{mensu.importe_abono}}</td>
				    <td>Total a pagar $ {{mensu.total_pago}}</td>
				    <td>Se ahorra ${{mensu.importe_ahorro}}</td>
				    <td><input type="radio" :value="mensu.id" v-model="radio"></td>
					</tr>
				</tbody>
			</table>
		</template>
	</div>
</div>

<template v-if="arrayMens != 0">
	<div class="float-right" style="padding-top: 15px; padding-bottom: 15px;">
		<button type="button" class="btn btn-success" @click="cancelar()"><i class="fas fa-ban"></i> Cancelar</button>
		<button type="button" class="btn btn-success" @click="registrarVenta()"><i class="fas fa-save"></i> Guardar</button>
	</div>
</template>

<template v-if="arrayMens == 0">
	<div class="float-right" style="padding-top: 15px; padding-bottom: 15px;">
		<button type="button" class="btn btn-success" @click="cancelar()"><i class="fas fa-ban"></i> Cancelar</button>
		<button type="button" class="btn btn-success" @click="validarVenta()"><i class="fas fa-sign-in-alt"></i> Siguiente</button>
	</div>
</template>







</div>

</template>


<script>
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';
    export default {
        props : ['ruta'],
        data (){

            return {
            	folio: "",
            	arrayCliente: [],
            	id_cliente:0,
            	rfc: "",
            	arrayArticulo: [],
            	id_articulo: 0,
            	descripcion: "",
            	modelo: "",
            	stock: 0,
            	precio: 0.0,
            	precio_articulo: 0.0,
            	importe: 0.0,

            	cantidad: 1,

            	tasa_financiamiento: 0,
            	porcentaje_enganche: 0,
            	plazo_maximo: 0,

            	arrayDetalle : [],
            	aux: 0.0,

            	total: 0.0,
            	total_enganche: 0.0,
            	total_bonificacion: 0.0,
            	total_pagar: 0.0,
                codigo: '',

                arrayMens: [],
                radio: 0,          
            }
        },
        components: {
            vSelect
        },
        created: function(){
		    let uri = '/confi/listar';
		    Axios.get(uri).then((response) => {
		    	console.log(response);
		    	var respuesta = response.data;
		    	this.tasa_financiamiento = respuesta.financing_rate;
            	this.porcentaje_enganche = respuesta.percentage_hitch;
            	this.plazo_maximo = respuesta.maximum_term;

            	var result = this.tasa_financiamiento * this.plazo_maximo;
            	result = result/100;
            	result = result + 1;

            	this.aux = result;
		    });
		},
        computed:{
			calcularTotalEnganche: function(){
                var resultado = 0.0;

                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado = resultado + this.arrayDetalle[i].importe;
                }

                var porc_enganche = this.porcentaje_enganche/100;

                resultado = porc_enganche * resultado;

                return resultado;
            },
            calcularTotalBonificacion: function(){
            	var fina = this.tasa_financiamiento * this.plazo_maximo;
            	var fina = fina/100;

            	var resultado = this.total_enganche * fina;

            	return resultado;
            },
            calcularTotal: function(){
            	var enga = 0.0;
            	var resultado = 0.0;

                for(var i=0;i<this.arrayDetalle.length;i++){
                    enga = enga + this.arrayDetalle[i].importe;
                }

                resultado = enga - this.total_enganche - this.total_bonificacion;

                return resultado; 
            }
        },
        methods : {
            url(){
                var url = window.location.href;
                var exceso = url.substring(url.lastIndexOf('/'));
                var home = url.replace(exceso,"");
                window.history.pushState("","",home);
            },
        	listarFolio(){
        		Axios.get('/venta/folio').then((response)=>{
    				this.folio = response.data;
    			});
        	},
            selectCliente(search,loading){
                let me=this;
                loading(true)

                var url= '/cliente/selectCliente?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayCliente=respuesta.clientes;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            }, 
            getDatosCliente(val1){
            	// console.log('sdf');
                let me = this;
                me.loading = true;
                me.id_cliente = val1.folio;
                me.rfc = val1.rfc;
            },
            selectArticulo(search,loading){
                let me=this;
                loading(true)

                var url= '/articulo/buscarArticulo?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayArticulo=respuesta.articulos;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            }, 
            getDatosArticulo(val1){
            	console.log('dsfdsfa');
                let me = this;
                me.loading = true;

                me.id_articulo = val1.id;
            	me.descripcion = val1.description;
            	me.modelo = val1.model;
            	me.stock = val1.existence;
            	me.precio = val1.price;
            },
            encuentra(id){
                var sw=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].id_articulo==id){
                        sw=true;
                    }
                }
                return sw;
            },
            agregarDetalle(){
                let me=this;
                if(me.id_articulo == 0 || me.descripcion == 0 || me.modelo == 0 || me.stock == 0 || me.precio == 0){
                	console.log('entraaa');
                    swal(
                        '¡Error!',
                        'Por favor, agregar un articulo',
                        'warning'
                    );
                }
                else{
                    if(me.encuentra(me.id_articulo)){
                        swal(
                            '¡Error!',
              				'Ese artículo ya se encuentra agregado',
              				'warning'
                        );
                    }
                    else{
                       if(me.cantidad>me.stock){
                           swal(
                            '¡Error!',
				            'El articulo seleccionado no cuenta con existencia, favor de verificar',
				            'warning'
                            );
                       } 
                       else{
                       		me.cantidad = 1;

                           	me.arrayDetalle.push({
                                id_articulo: me.id_articulo,
                                descripcion: me.descripcion,
                                cantidad: me.cantidad,
                                precio: me.precio,
                                modelo: me.modelo,
                                stock: me.stock,
                                tasa_financiamiento: me.tasa_financiamiento,
            					porcentaje_enganche: me.porcentaje_enganche,
            					plazo_maximo: me.plazo_maximo,
            					
            					aux: me.aux,

            					importe: me.importe,
            					precio_articulo: me.precio_articulo,
                            });
                           	console.log('entraaa');


                            me.codigo = "";
                            me.id_articulo = 0;
                            me.descripcion = "";
                            me.cantidad = 0;
                            me.precio = 0;
                            me.modelo = "";
                            me.stock = 0;
                       }
                    }   
                }
            },
            eliminarDetalle(index){
                let me = this;
                me.arrayDetalle.splice(index, 1);
                me.calcularTotal = 0.0;
                me.calcularTotalBonificacion = 0.0;
                me.calcularTotalEnganche = 0.0;
                me.arrayMens = [];
            },
            validarVenta(){
                let me=this;

                me.arrayDetalle.map(function(x){
                    if (x.cantidad>x.stock){
                        swal(
	                    '¡Error!',
			            'Los datos ingresados no son correctos, favor de verificar',
			            'warning'
                    );
                    }
                });

                if (me.id_cliente == 0) {
                	swal(
	                    '¡Error!',
			            'Los datos ingresados no son correctos, favor de verificar',
			            'warning'
                    );
                }
     
                else if (me.arrayDetalle.length==0) {
                	swal(
	                    '¡Error!',
			            'Los datos ingresados no son correctos, favor de verificar',
			            'warning'
                    );
                }

                else{
                	this.prueba();
                }
            },
            prueba(){



    	 		var plazo = this.plazo_maximo;
    	 		
    	 		var id = 1;
            	var limit = plazo/3;
            	var plazo_mensu = plazo/limit;
            	var tot = this.total; //Total adeudo
            	
            	var aux = this.aux;
            	
            	var miArray = [];
            	var precio_contado = 0.0;
            	var aux1 = 0.0,

            	precio_contado = tot/aux;
            	precio_contado = Number(precio_contado.toFixed(3));
            	

            	for(var i=1;i<=limit;i++)
			    {

					// Parte de la operacion para precio del articulo
					
	            	var aux2 = this.tasa_financiamiento*plazo_mensu;
	            	aux2 = Number(aux2.toFixed(3));
	            	aux2 = aux2/100;
	            	aux2 = aux2+1;			    	

	            	var total_pag = precio_contado*aux2;
	            	total_pag = Number(total_pag.toFixed(2));
	            	var abono = total_pag/plazo_mensu;
	            	abono = Number(abono.toFixed(2));
	            	var ahorro = tot-total_pag;
	            	ahorro = Number(ahorro.toFixed(2));

			        this.arrayMens.push({
			        	id: id,
			        	plazo: plazo_mensu,
			        	importe_abono: abono,
			        	total_pago: total_pag,
			        	importe_ahorro: ahorro,

			        });

			        id = id + 1;
			        plazo_mensu = plazo_mensu + 3;
			    }

			    var i = this.radio;
			    i = i -1; 

			    console.log(i);
            },
            registrarVenta(){
                let me = this;

                if(this.radio == 0){
                	swal(
	                    '¡Error!',
			            'Debe seleccionar un plazo para realizar el pago de su compra',
			            'warning'
                    );
                }

                var i = this.radio;
			    i = i -1; 

                axios.post('/venta/registrar',{
                    'id_cliente': this.id_cliente,
                    'enganche': this.total_enganche,
                    'bonificacion_enganche': this.total_bonificacion,
                    'total': this.arrayMens[i].total_pago,
                    'ahorro': this.arrayMens[i].importe_ahorro,
                    'pago_mensual': this.arrayMens[i].importe_abono,
                    'plazo': this.arrayMens[i].plazo,
                    

                    'data': this.arrayDetalle,

                }).then(function (response) {
                    swal(
		              '¡Bien hecho!',
		              'Tu venta ha sido registrada correctamente',
		              'success'
		            );

                    me.arrayCliente = [];
	            	me.id_cliente =0;
	            	me.rfc = "";
	            	me.arrayArticulo = [];
	            	me.id_articulo = 0;
	            	me.descripcion = "";
	            	me.modelo ="";
	            	me.stock = 0;
	            	me.precio = 0.0;
	            	me.precio_articulo = 0.0;
	            	me.importe = 0.0;

	            	me.arrayDetalle  = [];
	            	me.aux = 0.0;

	            	me.total = 0.0;
	            	me.total_enganche = 0.0;
	            	me.total_bonificacion = 0.0;
	            	me.total_pagar = 0.0;
	                me.codigo = '';

	                me.arrayMens = [];

	                me.cancelar();



                }).catch(function (error) {
                    console.log(error);
                });
            },
            cancelar(){
		        this.$router.push({path: 'venta_index'});
		    }
        },
        mounted() {
            this.url();
            this.listarFolio();
      	}
    }
</script>