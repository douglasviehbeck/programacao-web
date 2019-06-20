const axios = require('axios');

axios.defaults.headers.post['Access-Control-Allow-Origin'] = '*';

window.axios = axios.create({
    baseURL: '//pweb.local:' + require('./.env.json').port,
});