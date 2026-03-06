<template>
    <v-alert
    v-if="alert.error!=''"
    color="error"
    icon="$danger"
    :text="alert.error"
    style="display:none"
    ></v-alert>
    <v-alert
    v-if="alert.success!=''"
    color="success"
    icon="$success"
    :text="alert.success"
    style="display:none;"
    ></v-alert>
</template>
<script setup>
import { useAlertStore } from '../../js/stores/alert'
const alert = useAlertStore()
</script>