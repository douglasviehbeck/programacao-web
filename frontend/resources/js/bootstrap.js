const axios = require('axios');

window.axios = axios.create({
    baseURL: '//pweb.local:' + require('.env.json').port,
});