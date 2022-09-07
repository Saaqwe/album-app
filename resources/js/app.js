import Registration from "./components/Registration";

require('./bootstrap');
// window.bootstrap = require('bootstrap');
window.bootstrap = require('bootstrap/dist/js/bootstrap.bundle.js');

require('vue')
import { createApp } from 'vue'
import Login from "./components/Login";
import AlbumCreateForm from "./components/AlbumCreateForm";
import AlbumList from "./components/AlbumList";
import AlbumEditModal from "./components/AlbumEditModal";
import LoginPage from "./components/LoginPage";

const header = createApp({
    data() {
        return {
            count: 0
        }
    },
    components: {
        'login' : Login,
        'registration' : Registration,
    },
    mounted() {
    }
}).mount('#header');

const mainContent = createApp({
    data() {
        return {

        }
    },
    components: {
        'album-create-form' : AlbumCreateForm,
        'album-list' : AlbumList,
        'album-edit-modal' : AlbumEditModal,
        'login-page': LoginPage
    },
}).mount("#app");
