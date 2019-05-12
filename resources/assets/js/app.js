
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.VueRouter=require('vue-router').default;
window.Axios=require('axios').default;

Vue.use(VueRouter, Axios);

const routes = [
	{
		path: '/',
		component: require('./components/index.vue')
	},
	// Articulos
	{
		path: '/articulo_index',
		name: 'articulo_index',
		component: require('./components/adminArticulos/admin_index.vue')
	},
	{
		path: '/articulo_add',
		name: 'articulo_add',
		component: require('./components/adminArticulos/admin_add.vue')
	},
	{
		path: '/articulo_update',
		name: 'articulo_update',
		component: require('./components/adminArticulos/admin_update.vue')
	},

	// Clientes
	{
		path: '/cliente_index',
		name: 'cliente_index',
		component: require('./components/adminClientes/admin_index.vue')
	},
	{
		path: '/cliente_add',
		name: 'cliente_add',
		component: require('./components/adminClientes/admin_add.vue')
	},
	{
		path: '/cliente_update',
		name: 'cliente_update',
		component: require('./components/adminClientes/admin_update.vue')
	},

	// Configuraciones
	{
		path: '/configuracion_index',
		name: 'configuracion_index',
		component: require('./components/adminConfiguraciones/admin_index.vue')
	},

	// Ventas
	{
		path: '/venta_index',
		name: 'venta_index',
		component: require('./components/adminVentas/admin_index.vue')
	},
	{
		path: '/venta_add',
		name: 'venta_add',
		component: require('./components/adminVentas/admin_add.vue')
	}
];

const router = new VueRouter({ 
	mode: 'history', 
	routes: routes
});

new Vue(
	Vue.util.extend({ 
		router}
	)
).$mount('#app');


// const app = new Vue({
//     el: '#app'
// });
