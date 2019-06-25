import App from './App';
import Vue from 'vue';

require('./bootstrap');

import 'toastr/toastr.scss';

var toastr = require('toastr');

Vue.prototype.$rules = require('./rules').default;
Vue.prototype.$flashMessages = {messages: []};
Vue.prototype.$flash = function (type, message, title) {
    return new Promise((resolve) => {
        toastr.options = {
            progressBar: true,
            positionClass: 'toast-top-right',
            onclick: resolve,
            showDuration: '300',
            hideDuration: '1000',
            timeOut: '5000',
            extendedTimeOut: '1000',
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut',
        };

        toastr[type](message, title);
    });
};

Vue.prototype.$global = require('./state').default;

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
