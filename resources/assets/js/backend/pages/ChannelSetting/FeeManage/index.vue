<template>
    <div class="row">
        <div class="col-lg-12">
            <company-selector v-model="company_id" :options="companies"/>
            <div class="card m-b-30" v-if="company_id !== -1">
                <div class="card-header">
                    通道列表
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-center table-bordered table-box">
                            <thead>
                            <tr>
                                <th class="width-40">#</th>
                                <th>API代码</th>
                                <th>通道名称</th>
                                <th>手续费</th>
                                <th class="width-status">状态</th>
                                <th class="width-control">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(data, index) in datas" :key="index">
                                <td>{{ startIndex + index }}</td>
                                <td>{{ data.i6pay_id }}</td>
                                <td>{{ data.name }}</td>
                                <td>
                                    <span>{{ getFee(data) | numFormat('0,0.00') }}%</span>
                                </td>
                                <td>
                                    <i class="mdi mdi-check-circle-outline text-green" v-if="getStatus(data)"></i>
                                    <i class="mdi mdi-close-circle-outline text-red" v-else></i>
                                </td>
                                <td class="width-control">
                                    <a @click="$root.$emit('feeManageDetail.show', data)">
                                        <i class="mdi mdi-information-outline text-blue"></i>
                                    </a>
                                    <a @click="$root.$emit('feeManageEdit.show', data)">
                                        <i class="mdi mdi-pencil-box-outline"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- card end -->
        </div>
        <detail/>
        <edit/>
    </div>
</template>

<script>
    import ListMixins from 'mixins/list'
    import FeeMixins from '../FeeMixins'

    export default {
        api: "feeManage",
        mixins: [ListMixins, FeeMixins],
        components: {
            CompanySelector: require('@/CompanySelector'),
            Detail: require('./modal/Detail'),
            Edit: require('./modal/Edit')
        },
        data: () => ({
            options: {
                status: [
                    {val: '1', name: '开启'},
                    {val: '0', name: '取消'}
                ]
            },
            company_id: -1,
            companies: []
        }),
        watch: {
            company_id(nValue) {
                if (nValue !== -1) {
                    this.search()
                }
            }
        },
        methods: {
            dataInit() {
                this.callApi(async () => {
                    await this.$api.channel.manage.getOptions({
                        s: res => this.companies = res.data
                    })
                })
            },
            getList() {
                this.callApi(async () => {
                    await this.$api.channel.manage.getList(this.customGetReqBody, {
                        s: res => this.datas = _.orderBy(res.data, x => +x.i6pay_id, 'asc')
                    })
                })
            },
            getTotal() {
            }
        },
        computed: {
            customGetReqBody() {
                return {
                    merchant_id: this.company_id
                }
            }
        },
        mounted() {
            this.dataInit()
        }
    }
</script>
