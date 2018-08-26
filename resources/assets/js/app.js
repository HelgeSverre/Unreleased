/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import vSelect from 'vue-select'

Vue.component('v-select', vSelect);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('artist-selector', require('./components/ArtistSelector'));
Vue.component('genre-selector', require('./components/GenreSelector'));
Vue.component('search-field', require('./components/SearchField'));
Vue.component('artist-index', require('./components/ArtistIndex'));
Vue.component('genre-index', require('./components/GenreIndex'));

const app = new Vue({
    el: '#app'
});
