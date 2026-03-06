<template>
    <v-responsive fluid class="border rounded" max-height="100vh">
        <v-app>
            <Appbar />
            <v-navigation-drawer v-if="auth.isAuthenticated()">
                <v-list>
                    <v-list-item title="Navigation drawer"></v-list-item>
                </v-list>
            </v-navigation-drawer>
            <v-main >
                <Alerts />
                <v-container v-if="!auth.isAuthenticated()">
                    <Signin />
                </v-container>
                <router-view v-if="auth.isAuthenticated()" v-slot="{ Component, route }">
                    <transition name="slide">
                    <component :is="Component" :key="route.path" />
                    </transition>
                </router-view>
            </v-main>
        </v-app>
    </v-responsive>
</template>
<style>
.v-field__input{
    min-height: 0!important;
}
input, textarea{
    border:0!important;
}
</style>
<script setup>
import { useAuthStore } from '../js/stores/auth'
import { useAlertStore } from '../js/stores/alert'
import { useRouter } from "vue-router"

import Signin from './Signin.vue';
import Alerts from './Common/Alerts.vue';
import Appbar from './Common/Appbar.vue';

const router = useRouter()
const auth = useAuthStore()
const alert = useAlertStore()

if(auth.user!=0){
    router.push('/')
}

</script>