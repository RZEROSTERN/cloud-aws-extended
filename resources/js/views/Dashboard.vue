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
                                                        <input id="option1" type="radio" name="options" autocomplete="off" checked="" @click="viewMode('icons')"> Icons
                                                    </label>
                                                    <label class="btn btn-outline-secondary active">
                                                        <input id="option2" type="radio" name="options" autocomplete="off" @click="viewMode('list')"> List
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="c-chart-wrapper">
                                            <div class="row">
                                                <ItemCard v-for="item in items" v-bind:key="item" :itemName="item"/>
                                            </div>
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
import ItemCard from '../components/ItemCard.vue'

Vue.component('Sidebar', Sidebar)
Vue.component('Header', Header)
Vue.component('Footer', Footer)
Vue.component('ItemCard', ItemCard)

export default {
    data() {
        return {
            items: null
        }
    },
    mounted() {
        this.$store.watch((state) => {
            return this.$store.state.bucket
        }, (newVal) => {
            this.items = null
            axios.get(process.env.MIX_API_URL + "s3/buckets/" + newVal).then((response) => {
                this.items = response.data.data
            });
        }, {
            deep: true
        })
    }
}
</script>