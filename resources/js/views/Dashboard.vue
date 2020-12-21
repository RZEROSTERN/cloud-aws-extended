<template>
    <div class="c-app">
        <Sidebar />
        <div class="c-wrapper c-fixed-components">
            <Header />
            <div class="c-body">
                <main class="c-main">

                </main>
            </div>
        </div>
    </div>
</template>
<script>
import Vue from 'vue'
import firebase from "firebase/app";
import 'firebase/app';
import 'firebase/auth';
import Sidebar from '../components/Sidebar.vue'
import Header from '../components/Header.vue'

Vue.component('Sidebar', Sidebar)
Vue.component('Header', Header)

export default {
    methods: {
        logout() {
            firebase.auth()
            .signOut()
                .then( () => {
                this.$router.replace('/login')
                })
        }        
    }
}
</script>