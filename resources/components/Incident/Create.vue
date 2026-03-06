<template>
    <v-form >
        <v-container>
        <v-row>
            <v-col
            cols="12"
            md="12"
            >
            <h3>Create new Incident</h3>
            {{ auth.users }}
            <v-autocomplete
            label="Autocomplete"
            :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
          ></v-autocomplete>
            <v-text-field
                v-model="store.incident.issue"
                label="Issue"
                required
            ></v-text-field>
            <v-textarea
            v-model="store.incident.description"
            label="Descriptions"
            required
        ></v-textarea>
            <v-btn
                color="primary"
                @click="submitForm"
            >
                Add
            </v-btn>
            </v-col>
        </v-row>
        </v-container>
    </v-form>
</template>
<script setup>
import { useIncidentStore } from '../../js/stores/incident'
import axios from 'axios';
import { useAuthStore } from '../../js/stores/auth'


const auth = useAuthStore()

const store = useIncidentStore()



const submitForm = async () => {
    var formData = new FormData();
    console.log(store.incident)
    formData.append('incident',JSON.stringify(store.incident))
    try {
        const response = await axios({
            method:'POST',
            url:"/api/incident",
            data: formData,
            headers:{'Authorization':`Bearer${auth.token}`,
        }});
        if(response.data.message == 'success'){
            alert.success = "Success"
        }else{
            alert.error = "Error" . response.data
        }
    } catch (error) {
        alert.error = error
    }
}
</script>