<template>
    <div class="c-app">
        <Sidebar />
        <div class="c-wrapper c-fixed-components">
            <Header />
            <div class="c-body">
                <main class="c-main">
                    <div class="container-fluid">
                        <div class="fade-in">
                            <div class="card">
                                <div class="card-body">
                                    <div v-if="this.$store.state.bucket !== null">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="card-title mb-0">{{this.$store.state.bucket}} content.</h4>
                                            </div>
                                            <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                                                <div class="btn-group btn-group-toggle mx-3" data-toggle="buttons">
                                                    <label class="btn btn-outline-secondary">
                                                        <input id="option1" type="radio" name="options" autocomplete="off" @click="viewMode('icons')"> Icons
                                                    </label>
                                                    <label class="btn btn-outline-secondary active">
                                                        <input id="option2" type="radio" name="options" autocomplete="off" checked="" @click="viewMode('list')"> List
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="c-chart-wrapper" style="height:300px;margin-top:40px;">
                                            <!-- Le contenido -->
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div class="d-flex justify-content-between">
                                            <h4 class="card-title mb-0">Please select a bucket for checking its content.</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <Footer/>
        </div>
    </div>
</template>
<script>
import Vue from 'vue'
import axios from 'axios'

import Sidebar from '../components/Sidebar.vue'
import Header from '../components/Header.vue'
import Footer from '../components/Footer.vue'

Vue.component('Sidebar', Sidebar)
Vue.component('Header', Header)
Vue.component('Footer', Footer)

export default {
    mounted() {
        this.$store.watch((state) => {
            return this.$store.state.bucket
        }, (newVal) => {
            axios.get(process.env.MIX_API_URL + "s3/buckets/" + newVal).then((response) => {
                console.log(response);
            });
        }, {
            deep: true
        })
    }
}
</script>