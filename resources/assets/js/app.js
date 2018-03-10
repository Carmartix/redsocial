
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(require('vue-moment'));
Vue.use(require('vue-toastr'));


Vue.component('create-feed', require('./components/CreateFeed.vue'));
Vue.component('list-feeds', require('./components/ListFeeds.vue'));
Vue.component('profile', require('./components/Profile.vue'));
Vue.component('list-friends', require('./components/ListFriends.vue'));
Vue.component('imbox', require('./components/Imbox.vue'));

const app = new Vue({
    el: '#app'
});
