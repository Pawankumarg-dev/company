<template>
    <div class="text-2xl text-center">
    
    </div>
    <div class="mt-2 mb-2 text-xl text-center">
    
    </div>
    <div class="p-5 m-5">
    <form @submit.prevent="validateAndLogin">
    <div class="mb-3 pt-0 text-center">
    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="grid-password">username:</label>
    <input type="text"
    v-model="username"
    :class="{ 'border-red-500': showErrorusername }"
    placeholder="username"
    class="px-2 py-1 placeholder-blueGray-300 text-blueGray-600 relative
    bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:ring w-1/2 required"/>
    </div>
    <div class=" pt-0 text-center">
    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="grid-password">Password:</label>
    <input type="text"
    v-model="password"
    :class="{ 'border-red-500': showErrorPassword }"
    placeholder="Password" class="px-2 py-1 placeholder-blueGray-300 text-blueGray-600 relative
    bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:ring w-1/2 required"/>
    </div>
    <div class="mt-3 pt-0 text-center">
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
    Login
    </button>
    </div>
    </form>
    </div>
    </template>
    <script setup>
    import { ref } from 'vue';
    import axios from 'axios';
    import { useAuthStore } from '../js/stores/auth'
    import { useRouter } from "vue-router"
    const router = useRouter()
    const auth = useAuthStore()
    const username = ref('');
    const password = ref('');
    const showErrorusername = ref(false);
    const showErrorPassword = ref(false);
    const validateAndLogin = async () => {
    showErrorusername.value = !username.value;
    showErrorPassword.value = !password.value;
    if (showErrorusername.value || showErrorPassword.value) {
    return;
    }
    try {
    const response = await axios.post('/auth/login', {
    username: username.value,
    password: password.value
    });
    console.log(response.data.authorisation.access_token); // Access token from the 'authorisation' object
    const token = response.data.authorisation.access_token; // Access token from the 'authorisation' object
    const user = response.data.user; // User object
    auth.user = user
    router.push('/home')
    if(token){
    localStorage.setItem('token', token);
    localStorage.setItem('user', JSON.stringify(user));
    } else {
    console.error('Token not received');
    }
    } catch (error) {
    console.error(error);
    }
    }
    </script>