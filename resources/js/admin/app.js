/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import '../bootstrap';

import NotyfPlugin from './plugins/notyf';
import Vue from 'vue';

Vue.use(NotyfPlugin);
window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('propiedad', require('./views/Propiedades/Propiedad.vue').default);
Vue.component('atributo_adicional', require('./views/AtributosAdicionales/AtributoAdicional.vue').default);
Vue.component('categoria_secundaria', require('./views/CategoriasSecundarias/CategoriaSecundaria.vue').default);
Vue.component('ubicacion', require('./views/Ubicaciones/Ubicacion.vue').default);
Vue.component('formato_negocio', require('./views/FormatosNegocios/FormatoNegocio.vue').default);
Vue.component('tipo_propiedad', require('./views/TiposPropiedades/TipoPropiedad.vue').default);
Vue.component('roles', require('./views/Roles/Roles.vue').default);
Vue.component('usuarios', require('./views/Usuarios/Usuarios.vue').default);
Vue.component('configuraciones', require('./views/Configuraciones/Configuracion.vue').default);
Vue.component('clientes', require('./views/Clientes/Cliente.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
