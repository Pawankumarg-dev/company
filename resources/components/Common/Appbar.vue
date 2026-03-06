<template>
    <v-app-bar :elevation="2" color="primary">
        <v-app-bar-nav-icon></v-app-bar-nav-icon>
        <v-toolbar-title>NBER RCI Help Desk</v-toolbar-title>
        <v-toolbar-items  v-if="auth.isAuthenticated()">
            <v-btn flat  :to="{ name: 'home' }">
            Home
            </v-btn>
            <v-btn flat  :to="{ name: 'newincident' }">
                + Incident
            </v-btn>
            <v-btn
            id="menu-activator"
            color="success"
          >
          {{  auth.user.username }}
          </v-btn>
          <v-menu activator="#menu-activator">
            <v-list>
              <v-list-item
              >
                <v-list-item-title @click="logout">Logout</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-toolbar-items>
    </v-app-bar>
</template>
<style>
button, .v-list-item-title{
    cursor: pointer;
}
</style>
<script setup>
    import { useAuthStore } from '../../js/stores/auth'
    import axios from 'axios';
    const auth = useAuthStore()
    const logout = async () => {
        try {
            const response = await axios({
                method:'POST',
                url:"/api/auth/logout",
                headers:{'Authorization':`Bearer${auth.token}`
            }});
            if(response.data.message == 'success'){
                localStorage.setItem('token', '');
                localStorage.setItem('user', 0);
                auth.user = 0
                auth.token = ''
                alert.success = "Logged out"
            }else{
                alert.error = "Could not logout"
            }
        } catch (error) {
            localStorage.setItem('token', '');
            localStorage.setItem('user', 0);
            auth.user = 0
            auth.token = ''
            console.log(error)
            alert.error = "Could not logout"
        }
    }
</script>