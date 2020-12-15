<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8 ">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Emails({{data.length}})
                        <a href="/send-email" class="btn btn-primary">Send Email</a>
                    </div>
                    <div class="card-body">

                        <label>Filter:</label>
                        <input class="form-control" v-model="filters.data.value"/>
                        <hr>
                        <v-table class="table table-striped table-hover" :data="data"
                                 :filters="filters"
                                 :currentPage.sync="currentPage"
                                 :pageSize="5"
                                 @totalPagesChanged="totalPages = $event">
                            <thead slot="head">
                                <th >Id</th>
                                <th>Sender</th>
                                <th>Recipient</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </thead>
                            <tbody slot="body" slot-scope="{displayData}">
                                <tr v-for="row in displayData" :key="row.id">
                                    <td> {{ row.id }}</td>
                                    <td> {{ row.from }}</td>
                                    <td><a :href="'/'+row.to+'/emails'">{{row.to}}</a></td>
                                    <td> {{ row.subject }}</td>
                                    <td> {{ row.status }}</td>
                                    <td><a :href="'/'+row.id+'/view'" class="m-2">View Email</a>|<a class="m-2" :href="'/'+row.id+'/attachments'">View Attachments</a></td>
                                </tr>
                                <tr v-if="displayData.length==0" class="text-center"><td  colspan="6">No emails matching your filter.</td></tr>
                            </tbody>
                        </v-table>
                        <smart-pagination
                            :currentPage.sync="currentPage"
                            :totalPages="totalPages"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    import SmartTable from 'vuejs-smart-table';
    import axios from 'axios';

    Vue.use(SmartTable);
    export default {

        data() {
            return {
                data: [],
                filters: {
                    data: {value: '', keys: ['from', 'to', 'subject']}
                },
                currentPage: 1,
                totalPages: 0
            }
        },
        mounted() {
            axios.get('/api/get-emails').then(response => {
                this.data = response.data.emails;
            });
        }
    };
</script>
