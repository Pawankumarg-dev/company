import { defineStore } from 'pinia'
import {ref } from 'vue'

export const useAlertStore = defineStore('alert', () => {
    const error = ref('')
    const info  = ref('')
    const success = ref('')
    return { error, info, success }
  })