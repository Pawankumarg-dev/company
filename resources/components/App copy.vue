<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <nav>
                <ul class="list-inline">
                    <li>
                        <router-link :to="{ name: 'home' }">Home</router-link>
                    </li>
                    <li class="pull-right" v-if="auth.user==0">
                        <router-link :to="{ name: 'signin' }">Signin</router-link>
                    </li>
                    <li class="pull-right" v-else>
                            {{ auth.user.username }}
                    </li>
                </ul>
            </nav>
        </div>
        <div class="panel-body" v-if="auth.user==0" >
            <Signin />
        </div>
        <div class="panel-body" v-else>
            <router-link></router-link>
        </div>
    </div>
</template>
<script setup>
import { useAuthStore } from '../js/stores/auth'
import Signin from './Signin.vue';
import { useRouter } from "vue-router"
const router = useRouter()
const auth = useAuthStore()
if(auth.user!=0){
    router.push('/')
}
</script>