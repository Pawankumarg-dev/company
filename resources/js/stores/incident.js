import { defineStore } from 'pinia'
import {ref } from 'vue'

export const useIncidentStore = defineStore('incident', () => {
    const incident =ref({
        issue: '',
        description: '',
        solution: '',
        user_id: '',
        itsmincidentstatus_id: 1,
        reported_on: '',
        resolved_on: ''
    })
    return { incident}
  })