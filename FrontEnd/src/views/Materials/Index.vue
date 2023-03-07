<template>
    <v-table>
        <thead>
            <tr>
                <th class="text-left">Name</th>
                <th class="text-left">Code</th>
                <th class="text-left">Price</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="material in materials" :key="material.materialCode">
                <td>{{ material.materialCode }}</td>
                <td>{{ material.materialDescription }}</td>
                <td>{{ material.materialPrice }}</td>
            </tr>
        </tbody>
    </v-table>
</template>

<script lang="js">
import { sendRequest } from '../../utils/request'

export default {
    mounted() {
        this.handleMaterials()
    },
    data() {
        return {
            materials: []
        }
    },
    methods: {
        handleMaterials() {
            sendRequest('GET', `${import.meta.env.VITE_APP_BACKEND_HOST}/api/v1/materials`)
                .then(res => {
                    this.materials = res.payload
                })
                .catch(err => {
                    console.log(err)
                })
        }
    }
}
</script>