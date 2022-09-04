import Registration from "./components/Registration";

require('./bootstrap');
// window.bootstrap = require('bootstrap');
window.bootstrap = require('bootstrap/dist/js/bootstrap.bundle.js');

require('vue')
import { createApp } from 'vue'
import Login from "./components/Login";
import ArticleAddModal from "./components/ArticleAddModal";

const header = createApp({
    data() {
        return {
            count: 0
        }
    },
    components: {
        'login' : Login,
        'registration' : Registration,
        'article-add-modal' : ArticleAddModal

    },
    mounted() {
    }
}).mount('#header');


