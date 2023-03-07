<template>
    <v-form ref="form">
        <v-text-field label="Name" v-model="member.memberName" :rules="member.memberNameRule" required />
        <v-text-field type="date" label="Birth Date" v-model="member.memberBirthdate" :rules="member.memberBirthdateRule"
            required />
        <v-textarea label="Address" v-model="member.memberAddress" :rules="member.memberAddressRule" required />
        <v-text-field label="City" v-model="member.memberCity" :rules="member.memberCityRule" required />
        <v-text-field label="Phone Number" v-model="member.memberPhone" :rules="member.memberPhoneRule" required />
        <v-text-field label="E-mail" v-model="member.memberEmail" :rules="member.memberEmailRule" required />
        <v-btn class="me-4" @click="validate">
            Submit
        </v-btn>
        <v-btn @click="handleReset">
            Clear
        </v-btn>
    </v-form>
</template>

<script>
import { sendRequest } from '../../utils/request'

export default {
    data: () => ({
        valid: true,
        member: {
            memberName: "",
            memberNameRule: [
                v => !!v || 'Name is required',
                v => (v && v.length >= 3) || 'Name needs to be at least 3 characters.',
            ],
            memberBirthdate: "",
            memberBirthdateRule: [
                v => !!v || 'Birth date is required',
                v => (v && v.length !== 10) || 'Birth date cannot be null.',
            ],
            memberAddress: "",
            memberAddressRule: [
                v => !!v || 'Address is required',
                v => (v && v.length >= 10) || 'Address needs to be at least 10 characters.',
            ],
            memberCity: "",
            memberCityRule: [
                v => !!v || 'City is required',
                v => (v && v.length >= 3) || 'City needs to be at least 3 characters.',
            ],
            memberPhone: "",
            memberPhoneRule: [
                v => !!v || 'Phone Number is required',
                v => (v && v.length >= 9) || 'Phone number needs to be at least 9 digits.',
            ],
            memberEmail: "",
            memberEmailRule: [
                v => !!v || 'Email is required',
                v => /^[a-z.-]+@[a-z.-]+\.[a-z]+$/i.test(v) || 'Must be a valid e-mail.'
            ]
        }
    }),
    mounted() {
        this.fetchMember(this.$route.params.id)
    },
    methods: {
        async fetchMember(id) {
            sendRequest('GET', `${import.meta.env.VITE_APP_BACKEND_HOST}/api/v1/members/${id}`)
                .then(res => {
                    if (!res.status) throw new Error(res.message)
                    this.member = res.payload[0]
                })
                .catch(err => {
                    alert(err)
                    window.location.href = '/members'
                })
        },
        async validate() {
            const { valid } = await this.$refs.form.validate()
            if (valid) {
                sendRequest('PUT', `${import.meta.env.VITE_APP_BACKEND_HOST}/api/v1/members/${this.$route.params.id}`, {
                    memberName: this.member.memberName,
                    memberBirthdate: this.member.memberBirthdate,
                    memberAddress: this.member.memberAddress,
                    memberCity: this.member.memberCity,
                    memberPhone: this.member.memberPhone,
                    memberEmail: this.member.memberEmail
                })
                    .then(res => {
                        if (!res.status) throw new Error(res.message)
                        window.location.href = "/members"
                    })
                    .catch(err => {
                        alert(err)
                    })
            }
        },
        reset() {
            this.$refs.form.reset()
        },
        resetValidation() {
            this.$refs.form.resetValidation()
        },
    }
}
</script>