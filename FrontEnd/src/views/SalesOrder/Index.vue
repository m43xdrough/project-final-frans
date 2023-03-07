<template>
    <v-table>
        <thead>
            <tr>
                <th class="text-left">Transaction Number</th>
                <th class="text-left">Transaction Date</th>
                <th class="text-left">Customer</th>
                <th class="text-left">Grand Total</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="salesOrder in salesOrders" :key="salesOrder.soTransNo">
                <td>{{ salesOrder.soTransNo }}</td>
                <td>{{ salesOrder.soTransDate }}</td>
                <td>{{ salesOrder.receipt.member.memberCode }} - {{ salesOrder.receipt.member.memberName }}</td>
                <td>{{ salesOrder.soGrandTotal }}</td>
            </tr>
        </tbody>
    </v-table>
</template>

<script lang="js">
import { sendRequest } from '../../utils/request'

export default {
    mounted() {
        this.handleSalesOrder()
    },
    data() {
        return {
            salesOrders: []
        }
    },
    methods: {
        handleSalesOrder() {
            sendRequest('GET', `${import.meta.env.VITE_APP_BACKEND_HOST}/api/v1/transso`)
                .then(res => {
                    this.salesOrders = res.payload
                })
                .catch(err => {
                    console.log(err)
                })
        }
    }
}
</script>