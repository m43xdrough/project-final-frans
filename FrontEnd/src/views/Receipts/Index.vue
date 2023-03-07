<template>
    <v-table>
        <thead>
            <tr style="white-space: nowrap;">
                <th class="text-left">Receipt Number</th>
                <th class="text-left">Receipt Date</th>
                <th class="text-left">Customer</th>
                <th class="text-left">Spheris</th>
                <th class="text-left">Cylinder</th>
                <th class="text-left">Addition</th>
                <th class="text-left">Axis</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="receipt in receipts" :key="receipt.receiptNumber" style="white-space: nowrap;">
                <td>{{ receipt.receiptNumber }}</td>
                <td>{{ receipt.receiptDate }}</td>
                <td>{{ receipt.member.memberCode }} - {{ receipt.member.memberName }}</td>
                <td>
                    {{ `R ${receipt.receiptSpherisr}` }}
                    <br />
                    {{ `L ${receipt.receiptSpherisl}` }}
                </td>
                <td>
                    {{ `R ${receipt.receiptCylinderr}` }}
                    <br />
                    {{ `L ${receipt.receiptCylinderl}` }}
                </td>
                <td>
                    {{ `R ${receipt.receiptAdditionr}` }}
                    <br />
                    {{ `L ${receipt.receiptAdditionl}` }}
                </td>
                <td>
                    {{ `R ${receipt.receiptAxisr}` }}
                    <br />
                    {{ `L ${receipt.receiptAxisl}` }}
                </td>
            </tr>
        </tbody>
    </v-table>
</template>

<script lang="js">
import { sendRequest } from '../../utils/request';

export default {
    mounted() {
        this.handleReceipts()
    },
    data() {
        return {
            receipts: []
        }
    },
    methods: {
        handleReceipts() {
            sendRequest('GET', `${import.meta.env.VITE_APP_BACKEND_HOST}/api/v1/treceipts`)
                .then(res => {
                    this.receipts = res.payload
                })
                .catch(err => {
                    console.log(err)
                })
        }
    }
}
</script>