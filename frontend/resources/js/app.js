import App from './App';
import Vue from 'vue';

require('./bootstrap');

Vue.prototype.$rules = require('./rules').default;
Vue.prototype.$flashMessages = {messages: []};
Vue.prototype.$flash = function (type, message) {
    Vue.prototype.$flashMessages.messages.push({
        type,
        message,
    });
};

window.Vue = Vue;

const files = require.context('./components', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0].split(/(?=[A-Z])/).join('-').toLowerCase(), files(key).default));

const plugins = require.context('./plugins', true, /\.js/i);
plugins.keys().map(key => Vue.use(plugins(key).default));

const app = new Vue({
    el: '#app',
    router: require('./router').default,
    render: h => h(App),
});
