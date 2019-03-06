<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="search-box">
                        <date-time-picker v-model="searchData.start" placeholder="開始日期"/>
                        <date-time-picker v-model="searchData.end" placeholder="結束日期"/>
                        <picker-button :startTime.sync="searchData.start" :endTime.sync="searchData.end"/>
                        <div class="search-select">
                            <select class="form-control" v-model="searchData.company_service_id">
                                <option value="">请选择商户</option>
                                <option v-for="company in options.companies" :key="company.id"
                                        :value="company.company_service_id">
                                    {{ company.company_name }}
                                </option>
                            </select>
                        </div>
                        <div class="search-select">
                            <select class="form-control" v-model="searchData.pay_state">
                                <option value="">交易状态</option>
                                <option v-for="val in options.payState" :key="val" :value="val">
                                    {{ config.PayState[val] }}
                                </option>
                            </select>
                        </div>
                        <div class="search-select">
                            <select class="form-control" v-model="searchData.payment">
                                <option value="">支付方式</option>
                                <option v-for="type in options.paymentType" :key="type.id" :value="type.i6pay_id">
                                    {{ type.name }}
                                </option>
                            </select>
                        </div>
                        <div class="search-input">
                            <input type="text"  class="form-control" placeholder="关键字" v-model="searchData.keyword">
                        </div>
                        <div>
                            <button type="button" class="btn btn-search" data-toggle="button" @click="search">搜寻</button>
                        </div>
                    </div>
                    <!-- search-box end -->
                    <div class="row view-btn-box">
                        <div class="col-sm-6 view-btn">
                            <button class="btn btn-application btn-full" @click="showEdit()">补单</button>
                        </div>
                        <per-page-selector v-model="paginate.perpage"/>
                    </div>
                    <!-- view-box end -->
                    <div class="table-responsive m-t-15">
                        <table class="table table-condensed table table-hover text-center table-bordered table-box">
                            <thead>
                            <tr>
                                <th class="width-40">#</th>
                                <th>交易状态</th>
                                <th>商户名称</th>
                                <th>系统交易号</th>
                                <th>商户交易号</th>
                                <th>金额</th>
                                <th>支付方式</th>
                                <th>手续费</th>
                                <th class="width-date">申请时间</th>
                                <th class="width-control">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(data, index) in datas" :key="index">
                                <td>{{ startIndex + index }}</td>
                                <td>
                                    <span class="badge badge-primary badge-pill" v-if="data.pay_state == 0">申请成功</span>
                                    <span class="badge badge-warning badge-pill" v-else-if="data.pay_state == 1">交易中</span>
                                    <span class="badge badge-info badge-pill" v-else-if="data.pay_state == 2">交易成功,未回调</span>
                                    <span class="badge badge-success badge-pill" v-else-if="data.pay_state == 3">交易结束</span>
                                    <span class="badge badge-danger badge-pill" v-else>交易失败</span>
                                </td>
                                <td>{{ data.company.company_name}}</td>
                                <td>{{ data.trade_seq }}</td>
                                <td>{{ data.trade_service_id }}</td>
                                <td class="text-right">{{ data.amount | numFormat('0,0.000') }}</td>
                                <td>{{ data.payment.name }}</td>
                                <td class="text-right">{{ data.fee | numFormat('0,0.000') }}</td>
                                <td>{{ data.pay_end_time }}</td>
                                <td><a @click="showEdit(data)"><i class="mdi mdi-pencil-box-outline"></i></a></td>
                            </tr>

                            </tbody>
                            <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-right">小计</td>
                                <td class="text-right">
                                    {{
                                        _.sumBy(this.datas, x => +x.amount) | numFormat('0,0.000')
                                    }}
                                </td>
                                <td></td>
                                <td class="text-right">
                                    {{
                                        _.sumBy(this.datas, x => +x.fee) | numFormat('0,0.000')
                                    }}
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <paginate :page="paginate.page" :last-page="lastPage" @pageChange="pageChange"/>
                </div>
            </div>
        </div>
        <edit/>
    </div>
</template>

<script>
    import ListMixins from 'mixins/list'
    import PayState from 'config/PayState'

    export default {
        api: "replenishment",
        mixins: [ListMixins],
        components: {
            Edit: require('./modal/Edit')
        },
        data: () => ({
            config: {
                PayState: PayState.summaryMap()
            },
            options: {
                payState: {},
                paymentType: {},
                companies: []
            },
            searchData: {
                start: moment().startOf('day'),
                end: moment().endOf('day'),
                company_service_id: '',
                payment: '',
                pay_state: '',
                keyword: ''
            }
        }),
        methods: {
            dataInit() {
                this.proccessAjax('dataInit', {}, res => {
                    this.options.companies = res.data.merchants
                    this.options.payState = res.data.pay_states
                    this.options.paymentType = res.data.payment
                }, false)
            },
            onGetTotal(res) {
                this.paginate.total = res.data
            },
            onGetList(res) {
                this.datas = res.data
            },
            showEdit(data) {
                this.$root.$emit('replenishmentEdit.show', data)
            }
        },
        mounted() {
            this.dataInit()
            this.search()
        }
    }
</script>

<style>
    .accordion-table th,
    .accordion-table td{
        min-width: 120px;
    }
    .accordion-table th.width-40,
    .accordion-table td{
        min-width: 40px;
    }
    .accordion-table td.aisle-total{
        min-width: 200px;
    }
    .aisle-name{
        cursor: pointer;
        position: relative;
    }
    .aisle-box{
        background-color: #f5f5f5;
    }
</style>
