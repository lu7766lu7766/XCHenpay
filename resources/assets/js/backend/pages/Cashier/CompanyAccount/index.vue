<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    公司帐户
                </div>
                <div class="card-body">
                    <div class="search-box">
                        <div class="search-select">
                            <select class="form-control" v-model="searchData.status">
                                <option value="">状态</option>
                                <option v-for="(name, val) in options.status" :key="val" :value="val">{{ name }}
                                </option>
                            </select>
                        </div>
                        <div class="search-input">
                            <input type="text" class="form-control" placeholder="关键字" v-model="searchData.keyword">
                        </div>
                        <div>
                            <button type="button" class="btn btn-search" data-toggle="button" @click="search">搜寻
                            </button>
                        </div>
                    </div>
                    <!-- search-box end -->
                    <div class="row view-btn-box">
                        <div class="col-sm-6 view-btn">
                            <button class="btn btn-add btn-half"
                                    @click="$root.$emit('companyAccountAdd.show')">新增
                            </button>
                        </div>
                        <per-page-selector v-model="paginate.perpage"/>
                    </div>
                    <!-- view-box end -->
                    <div class="table-responsive m-t-15">
                        <table class="table table-hover text-center table-bordered table-box">
                            <thead>
                            <tr>
                                <th class="width-40">#</th>
                                <th>开户名</th>
                                <th>银行卡号</th>
                                <th>银行名</th>
                                <th>通道类型</th>
                                <th class="width-status">状态</th>
                                <th class="width-control">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(data, index) in datas" :key="index">
                                <td>{{ startIndex + index }}</td>
                                <td>{{ data.user_name }}</td>
                                <td>{{ data.card_no }}</td>
                                <td>{{ data.bank_name }}</td>
                                <td>
                                    {{ getPaymentName(data.payment) }}
                                </td>
                                <td>
                                    <i class="mdi mdi-check-circle-outline text-green"
                                       v-if="data.status == 'Y'"></i>
                                    <i class="mdi mdi-close-circle-outline text-red" v-else></i>
                                </td>
                                <td>
                                    <a @click="$root.$emit('companyAccountInfo.show', data)">
                                        <i class="mdi mdi-information-outline text-blue"></i></a>
                                    <a @click="$root.$emit('companyAccountEdit.show', data)">
                                        <i class="mdi mdi-pencil-box-outline"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- table-responsive end -->
                    <paginate :page="paginate.page" :lastPage="lastPage" @pageChange="pageChange"/>
                    <!-- <nav aria-label="Page navigation" class="page-bar"> end -->
                </div>
            </div>
        </div>
        <info/>
        <add/>
        <edit/>
    </div>
</template>

<script>
    import ListMixins from 'mixins/list'
    import PaymentMixins from 'mixins/payment'
    import CashierStatisticsType from 'config/CashierStatisticsType'

    export default {
        mixins: [ListMixins, PaymentMixins],
        components: {
            Info: require('./modal/Info'),
            Add: require('./modal/Add'),
            Edit: require('./modal/Edit'),
        },
        data: () => ({
            options: {
                status: {
                    'Y': '开启',
                    'N': '关闭'
                },
                channel: [],
                bank: [],
                CashierStatisticsTypeSummary: CashierStatisticsType.summaryMap()
            },
            searchData: {
                status: '',
                apply_status: '',
                keyword: ''
            },
            config: {
                CashierStatisticsType
            }
        }),
        methods: {
            async dataInit() {
                const res = await this.$api.cashier.companyAccount.getOptions()
                this.options.channel = res[0].data
                this.options.bank = res[1].data
            },
            getList() {
                this.callApi(async () => {
                    await this.$api.cashier.companyAccount.getList(this.getReqBody, {
                        s: res => {
                            this.datas = res.data
                        }
                    })
                })
            },
            getTotal() {
                this.$api.cashier.companyAccount.getListTotal(this.getReqBody, {
                    s: res => {
                        this.paginate.total = res.data
                    }
                })
            }
        },
        mounted() {
            this.dataInit()
            this.search()
        }
    }
</script>
