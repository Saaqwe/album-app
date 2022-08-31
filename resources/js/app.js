require('./bootstrap');
// window.bootstrap = require('bootstrap');
window.bootstrap = require('bootstrap/dist/js/bootstrap.bundle.js');

require('vue')
import { createApp } from 'vue'
import Login from "./components/Login";

const header = createApp({
    data() {
        return {
            count: 0
        }
    },
    components: {
        'login' : Login,

    },
    mounted() {
    }
}).mount('#header');


