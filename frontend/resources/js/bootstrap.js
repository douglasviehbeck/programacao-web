try {
    window.$ = window.jQuery = require('jquery');
} catch (e) {}

const axios = require('axios');

window.axios = axios.create({
    baseURL: '//pweb.local',
});

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
//
// let token = document.head.querySelector('meta[name="csrf-token"]');
//
// if (token) {
//     window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
// } else {
//     console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
// }