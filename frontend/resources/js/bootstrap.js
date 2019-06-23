const axios = require('axios');

axios.defaults.headers.post['Access-Control-Allow-Origin'] = '*';

window.axios = axios.create({
    baseURL: '//' + window.location.hostname + ':81',
});