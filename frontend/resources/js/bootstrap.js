const axios = require('axios');

axios.defaults.headers.post['Access-Control-Allow-Origin'] = '*';

console.log('//' + window.location.hostname + ':' + require('./.env.json').port);

window.axios = axios.create({
    baseURL: '//' + window.location.hostname + ':' + require('./.env.json').port,
});