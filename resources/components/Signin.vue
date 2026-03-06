<template>
  <v-card
    class="mx-auto"
    max-width="344"
    style="margin:auto;margin-top:200px!important;"
  >
  <v-form>
   
    <v-card-title>
     Login
    </v-card-title>

    <v-card-subtitle>
      Enter your username and password
    </v-card-subtitle>
    <v-card-item>
        <v-text-field
            v-model="username"
            label="User name"
            required
          ></v-text-field>
          <v-text-field
          v-model="password"
          type="password"
          label="Password"
          required
        ></v-text-field>
    </v-card-item>

    <v-card-actions>
      <v-btn
        color="primary"
        text="Submit"
        @click="validateAndLogin"
        variant="elevated"
      ></v-btn>
    </v-card-actions>
  </v-form>
  </v-card>
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
      const response = await axios.post('/api/auth/login', {
        username: username.value,
        password: password.value
      });
      console.log(response.data.authorisation.access_token); // Access token from the 'authorisation' object
      const token = response.data.authorisation.access_token; // Access token from the 'authorisation' object
      const user = response.data.user; 
      if(token){
        localStorage.setItem('token', token);
        localStorage.setItem('user', JSON.stringify(user));
        auth.user = user
        auth.token = token
        auth.getUsers(token)
      } else {
        console.error('Token not received');
      }
    } catch (error) {
      console.error(error);
    }
    router.push('/incident/create')
  }
  </script>