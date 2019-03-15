import App from './App';
import Vue from 'vue';

require('./bootstrap');

Vue.prototype.$rules = require('./rules').default;

window.Vue = Vue;

const files = require.context('./components', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0].split(/(?=[A-Z])/).join('-').toLowerCase(), files(key).default));

const app = new Vue({
    el: '#app',
    router: require('./router').default,
    render: h => h(App),
});
