<template>
    <div class="card m-b-30">
        <div class="card-header">
            手续费列表
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover text-center table-bordered table-box">
                    <thead>
                    <tr>
                        <th class="width-40">#</th>
                        <th>API代号</th>
                        <th>通道名称</th>
                        <th>手续费</th>
                        <th class="width-status">状态</th>
                        <th class="width-control">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(data, index) in datas" :key="index">
                        <td>{{ index }}</td>
                        <td>{{ data.i6pay_id }}</td>
                        <td>{{ data.name }}</td>
                        <td>{{ data.fee }}</td>
                        <td>
                            <i class="mdi mdi-check-circle-outline text-green" v-if="data.status == '开启'"></i>
                            <i class="mdi mdi-close-circle-outline text-red" v-else></i>
                        </td>
                        <td class="width-control">
                            <a @click="showInfo(data.id)">
                                <i class="mdi mdi-information-outline text-blue"></i>
                            </a>
                            <a @click="showState(data.id)" v-if="isAdmin">
                                <i class="mdi mdi-pencil-box-outline"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <fee-info/>
        <fee-state/>
    </div>
</template>

<script>
    import ListMixins from 'mixins/list'

    export default {
        api: "fee",
        mixins: [ListMixins],
        components: {
            FeeInfo: require('./modal/FeeInfo'),
            FeeState: require('./modal/FeeState')
        },
        watch: {
            company_id() {
                this.getList()
            }
        },
        methods: {
            getTotal() {
            },
            onGetList(res) {
                this.datas = res.data
            },
            showInfo(id) {
                this.$root.$emit('feeInfo.show', id)
            },
            showState(id) {
                this.$root.$emit('feeState.show', id)
            }
        },
        computed: {
            isAdmin() {
                return this.$parent.isAdmin
            },
            company_id() {
                return this.$parent.company_id
            },
            customGetReqBody() {
                return {
                    company: this.company_id
                }
            }
        },
        mounted() {
            if (this.company_id) {
                this.getList()
            }
        }
    }
</script>

<style scoped>

</style>
