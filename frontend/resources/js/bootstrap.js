try {
    window.$ = window.jQuery = require('jquery');
} catch (e) {}

const axios = require('axios');

window.axios = axios.create({
    baseURL: '//pweb.local',
});