<template>
    <div class="d-flex justify-space-between flex-wrap">
        <div>
    <v-btn color="info" style="margin-bottom: 10px;" to="/members/create">
        Add Member
    </v-btn>
    <v-btn color="success" style="margin-left: 10px; margin-bottom: 10px;" @click="handldExportXls()">
        Export to Xls
    </v-btn>
    <v-btn color="primary" style="margin-left: 10px; margin-bottom: 10px;" @click="dialog = true">
        Import Member
    </v-btn>
    </div>
        <v-card
            color="grey-lighten-3"
        >
            <v-card-text style="width: 400px;">
                <v-text-field
                    density="compact"
                    variant="solo"
                    label="Search customers"
                    append-inner-icon="mdi-magnify"
                    single-line
                    hide-details
                    v-on:keyup="handleSearch"
                ></v-text-field>
            </v-card-text>
        </v-card>
    </div>
    <v-table>
        <thead>
            <tr>
                <th class="text-left">Name</th>
                <th class="text-left">Code</th>
                <th class="text-left">Address</th>
                <th class="text-left">Email</th>
                <th class="text-left">Birth Date</th>
                <th class="text-left">Mobile Phone</th>
                <th class="text-left">Total Receipts</th>
                <th class="text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="member in members" :key="member.memberCode">
                <td>{{ member.memberName }}</td>
                <td>{{ member.memberCode }}</td>
                <td>{{ member.memberAddress }}</td>
                <td>{{ member.memberEmail }}</td>
                <td>{{ member.memberBirthdate }}</td>
                <td>{{ member.memberPhone }}</td>
                <td>{{ member.memberProvince }}</td>
                <td>
                    <v-btn color="warning" icon="mdi-pencil" size="small"
                        @click="$router.push(`/members/${member.memberID}/edit`)" />
                    &nbsp;
                    <v-btn color="error" icon="mdi-delete" size="small" @click="handleDestroyMember(member.memberID)" />
                </td>
            </tr>
        </tbody>
    </v-table>
    <v-row justify="center">
        <v-dialog v-model="dialog" persistent width="1024">
            <v-card>
                <v-card-title>
                    <span class="text-h5">Import Member</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-file-input label="File Input" id="import-member"></v-file-input>
                        <a class="v-btn v-btn--elevated v-theme--light bg-primary v-btn--density-default v-btn--size-default v-btn--variant-elevated ml-10"
                            href="/Template Member.xlsx">Template Excel</a>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue-darken-1" variant="text" @click="dialog = false">
                        Close
                    </v-btn>
                    <v-btn color="blue-darken-1" variant="text" @click="handleImport">
                        Import
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script lang="js">
import xlsx from 'json-as-xlsx'
import readXlsxFile from 'read-excel-file'
import { sendRequest } from '../../utils/request'

export default {

    mounted() {
        this.handleMembers()
    },
    data: () => ({
        dialog: false,
        members: []
    }),
    methods: {
        handleMembers(url = `${import.meta.env.VITE_APP_BACKEND_HOST}/api/v1/members`) {
            sendRequest('GET', url)
                .then(res => {

                    this.members = res.payload
                })
                .catch(err => {
                    console.log(err)
                })
        },
        handleDestroyMember(id) {
            if (confirm("Are you sure ?")) {
                sendRequest('DELETE', `${import.meta.env.VITE_APP_BACKEND_HOST}/api/v1/members/${id}`)
                    .then(res => {
                        if (!res.status) {
                            if (!res.status) throw new Error(res.message)
                        }
                        this.handleMembers()
                        alert('Member deleted')
                    })
                    .catch(err => {
                        alert(err)
                    })
            }
        },
        handldExportXls() {
            const contents = []
            this.members?.forEach((member, i) => {
                contents.push({
                    name: member.memberName,
                    code: member.memberCode,
                    address: member.memberAddress,
                    email: member.memberEmail,
                    birthdate: member.memberBirthdate,
                    mobile: member.memberPhone,
                })
            })

            const exportData = [{
                sheet: "Members",
                columns: [
                    { label: "Name", value: "name" },
                    { label: "Code", value: "code" },
                    { label: "Address", value: "address" },
                    { label: "Email", value: "email" },
                    { label: "Birthdate", value: "birthdate" },
                    { label: "Mobile Phone", value: "mobile" },
                ],
                content: contents
            }]

            const settings = {
                fileName: "Members CRM - Melawai", // Name of the resulting spreadsheet
                extraLength: 3, // A bigger number means that columns will be wider
                writeMode: "writeFile", // The available parameters are 'WriteFile' and 'write'. This setting is optional. Useful in such cases https://docs.sheetjs.com/docs/solutions/output#example-remote-file
                writeOptions: {}, // Style options from https://docs.sheetjs.com/docs/api/write-options
                RTL: false, // Display the columns from right-to-left (the default value is false)
            }

            xlsx(exportData, settings)
        },
        async handleImport() {
            const input = document.getElementById('import-member')
            if (input.files.length < 1) {
                return alert('File is required')
            }

            await readXlsxFile(input.files[0]).then(rows => {
                for (let i = 0; i < rows.length; i++) {
                    if (i === 0) {
                        const headers = ["Name", "BirthDate", "Address", "MemberCity", "MobilePhone", "Email"]
                        const result = rows[0]?.filter((header, i) => header === headers[i] ? true : false)
                        if (result.length !== 6) {
                            
                            alert('Template excel tidak sesuai, mohon download template excel terlebih dahulu')
                            break
                        }
                        continue
                    }

                    sendRequest('POST', `${import.meta.env.VITE_APP_BACKEND_HOST}/api/v1/members`, {
                        "memberName": rows[i][0],
                        "memberBirthdate": rows[i][1],
                        "memberAddress": rows[i][2],
                        "memberCity": rows[i][3],
                        "memberPhone": rows[i][4],
                        "memberEmail": rows[i][5]
                    })
                        .then(res => {
                            console.log(res)
                            if (res.status == 200) {
                                alert('Import Member success')
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
                }

            })

            this.handleMembers()
            this.dialog = false
        },
        handleSearch(e) {
            if (e.keyCode === 13) {
                this.handleMembers(`${import.meta.env.VITE_APP_BACKEND_HOST}/api/v1/members?search=${e.target.value}`)
            } 
        }
    }
}
</script>
