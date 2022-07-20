require('./bootstrap');
require('bootstrap');
require('vue')
import { createApp } from 'vue'
import Login from "./components/Login";

const app = createApp({
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
}).mount('#app');


