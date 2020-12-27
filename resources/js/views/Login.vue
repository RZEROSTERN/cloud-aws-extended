<template>
    <div class="c-app flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card-group">
                        <div class="card p-4">
                            <div class="card-body">
                                <h1>Login</h1>
                                <p class="text-muted">Please insert your login credentials</p>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend"><span class="input-group-text">
                                    <svg class="c-icon">
                                        <use xlink:href="../../../node_modules/@coreui/icons/sprites/free.svg#cil-user"></use>
                                    </svg></span></div>
                                    <input class="form-control" type="email" placeholder="Email" v-model="email">
                                </div>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend"><span class="input-group-text">
                                        <svg class="c-icon">
                                            <use xlink:href="../../../node_modules/@coreui/icons/sprites/free.svg#cil-lock-locked"></use>
                                        </svg></span></div>
                                    <input class="form-control" type="password" placeholder="Password"  v-model="password">
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-primary btn-block" type="button" @click="logIn">Login</button>
                                    </div>
                                    <!--<div class="col-6 text-right">
                                        <button class="btn btn-link px-0" type="button">Forgot password?</button>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                            <div class="card-body text-center">
                                <div>
                                    <h2>Cloud AWS</h2>
                                    <p>Handle your S3 buckets from a friendly UI.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import firebase from "firebase/app"
import 'firebase/app'
import 'firebase/auth'

export default {
    data() {
        return {
            email: '',
            password: ''
        }
    },
    methods: {
        logIn() {
            firebase.auth()
                .signInWithEmailAndPassword(this.email, this.password)
                .then( () =>  {
                    this.$router.replace('/')
                })
                .catch(function(error) {
                    console.log(error.message)
                });
        }
    }
}
</script>