<template>
    
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