<template>
    <form @submit.prevent="submit">
        <v-text-field v-model="memberName.value.value" :error-messages="memberName.errorMessage.value" label="Name" />
        <v-text-field v-model="memberBirthdate.value.value" :error-messages="memberBirthdate.errorMessage.value"
            label="Birth Date" type="date" />
        <v-textarea label="Address" v-model="memberAddress.value.value"
            :error-messages="memberAddress.errorMessage.value" />
        <v-text-field v-model="memberCity.value.value" :error-messages="memberCity.errorMessage.value" label="City" />
        <v-text-field v-model="memberPhone.value.value" :error-messages="memberPhone.errorMessage.value"
            label="Phone Number" />
        <v-text-field v-model="memberEmail.value.value" :error-messages="memberEmail.errorMessage.value" label="E-mail" />
        <v-btn class="me-4" type="submit">
            Submit
        </v-btn>
        <v-btn @click="handleReset">
            Clear
        </v-btn>
    </form>
</template>

<script>
import { ref } from 'vue'
import { useField, useForm } from 'vee-validate'
import { sendRequest } from '../../utils/request'

export default {
    mounted() {
    },
    setup() {
        const { handleSubmit, handleReset } = useForm({
            validationSchema: {
                memberName(value) {
                    if (value?.length >= 3) return true
                    return 'Name needs to be at least 3 characters.'
                },
                memberBirthdate(value) {
                    if (value?.length === 10) return true
                    return 'Birth date cannot be null.'
                },
                memberAddress(value) {
                    if (value?.length >= 10) return true
                    return 'Address needs to be at least 10 characters.'
                },
                memberCity(value) {
                    if (value?.length >= 3) return true
                    return 'City needs to be at least 3 characters.'
                },
                memberPhone(value) {
                    if (value?.length > 9 && /[0-9-]+/.test(value)) return true

                    return 'Phone number needs to be at least 9 digits.'
                },
                memberEmail(value) {
                    if (/^[a-z1-9.-]+@[a-z.-]+\.[a-z]+$/i.test(value)) return true

                    return 'Must be a valid e-mail.'
                },
            },
        })

        const memberName = useField('memberName')
        const memberBirthdate = useField('memberBirthdate')
        const memberAddress = useField('memberAddress')
        const memberCity = useField('memberCity')
        const memberPhone = useField('memberPhone')
        const memberEmail = useField('memberEmail')

        const items = ref([
            'Item 1',
            'Item 2',
            'Item 3',
            'Item 4',
            'Item 5',
            'Item 6',
        ])

        const submit = handleSubmit(values => {
            sendRequest('POST', `${import.meta.env.VITE_APP_BACKEND_HOST}/api/v1/members`, values)
                .then(res => {
                    //console.log(res[0].messages)

                    if (res.status == 200) {
                        window.location.href = "/members"
                    } else {
                        for (var message in res.messages) {
                            //console.log(res[0].messages[message])
                            alert(res.messages[message])
                        }
                    }
                })
                .catch(err => {
                    console.log(err)
                })
        })

        return { memberName, memberBirthdate, memberAddress, memberCity, memberPhone, memberEmail, items, submit, handleReset }
    },
}
</script>