import { defineStore } from 'pinia'
import {ref } from 'vue'
import axios from 'axios';

export const useAuthStore = defineStore('auth', () => {
    const user = ref(localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : 0);
    const token  = ref(localStorage.getItem('token')? localStorage.getItem('token') : '' );
    const users = ref(0);
    function isAuthenticated(){
      return user.value === 0 ? false : true;
    }
    async  function getUsers(tkn){
      try{
          console.log(token.value);
          const response = await axios({
              method:'GET',
              url:"/api/common/getusers",
              headers:{'Authorization':`Bearer${token.value}`,
          }});
          console.log(response.data);
          if(response.data.message == 'success'){
              alert.success = "Success"
              users.value =  JSON.parse(response.data.users);
              console.log(users.value);
          }else{
              alert.error = "Error" . response.data
          }
      } catch (error) {
          alert.error = error
      }
    }
    return { user, token, isAuthenticated, getUsers, users }
  })