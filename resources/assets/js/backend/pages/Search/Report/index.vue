<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="search-box">
                        <date-time-picker v-model="searchData.startDate" placeholder="開始日期"/>
                        <date-time-picker v-model="searchData.endDate" placeholder="結束日期"/>
                        <picker-button :startTime.sync="searchData.startDate" :endTime.sync="searchData.endDate"/>
                        <div>
                            <button type="button" class="btn btn-search" data-toggle="button" @click="getList">搜寻
                            </button>
                        </div>
                    </div>
                    <!-- search-box end -->
                    <div class="table-responsive m-t-15">
                        <table class="table table-condensed table table-hover text-center table-bordered table-box report-table accordion-table"
                               style="border-collapse:collapse;">
                            <thead>
                            <tr>
                                <th class="width-40">#</th>
                                <th>商户</th>
                                <th>申請成功</th>
                                <th>交易中</th>
                                <th>交易成功(未回調)</th>
                                <th>交易成功(金额不符)</th>
                                <th>交易失败</th>
                                <th>交易成功</th>
                                <th>手续费</th>
                                <th>总计</th>
                            </tr>
                            </thead>
                            <tbody v-for="(data, index) in datas" :key="index">
                            <tr @click="data.isShowDetail = !data.isShowDetail">
                                <td>{{ startIndex + index }}</td>
                                <td class="aisle-name">
                                    <a>{{ data.company_name }}</a>
                                </td>
                                <td alt="申請成功" class="text-red">
                                    <div>
                                        {{
                                        getAmountSumByState(data.trade_logs, config.PayState.PREPARE_CODE)
                                        | numFormat('0,0.000')}}
                                    </div>
                                    <div>
                                        {{
                                        getCountSumByState(data.trade_logs, config.PayState.PREPARE_CODE)
                                        | numFormat('0,0')}}
                                    </div>
                                </td>
                                <td alt="交易中" class="text-red">
                                    <div>
                                        {{
                                        getAmountSumByState(data.trade_logs, config.PayState.OPERATING_CODE)
                                        | numFormat('0,0.000')}}
                                    </div>
                                    <div>
                                        {{
                                        getCountSumByState(data.trade_logs, config.PayState.OPERATING_CODE)
                                        | numFormat('0,0')}}
                                    </div>
                                </td>
                                <td alt="交易成功(未回調)" class="text-red">
                                    <div>
                                        {{
                                        getAmountSumByState(data.trade_logs, config.PayState.SUCCESS_CODE)
                                        | numFormat('0,0.000')}}
                                    </div>
                                    <div>
                                        {{
                                        getCountSumByState(data.trade_logs, config.PayState.SUCCESS_CODE)
                                        | numFormat('0,0')}}
                                    </div>
                                </td>
                                <td alt="交易成功(金额不符)" class="text-red">
                                    <div>
                                        {{
                                        getAmountSumByState(data.trade_logs, config.PayState.AMOUNT_NOT_MATCH_CODE)
                                        | numFormat('0,0.000')
                                        }}
                                    </div>
                                    <div>
                                        {{
                                        getCountSumByState(data.trade_logs, config.PayState.AMOUNT_NOT_MATCH_CODE)
                                        | numFormat('0,0')}}
                                    </div>
                                </td>
                                <td alt="交易失败" class="text-red">
                                    <div>
                                        {{
                                        getAmountSumByState(data.trade_logs, config.PayState.FAILED_CODE)
                                        | numFormat('0,0.000')}}
                                    </div>
                                    <div>
                                        {{
                                        getCountSumByState(data.trade_logs, config.PayState.FAILED_CODE)
                                        | numFormat('0,0')}}
                                    </div>
                                </td>
                                <td alt="交易成功" class="text-green">
                                    <div>
                                        {{
                                        getAmountSumByState(data.trade_logs, config.PayState.ALL_DONE_CODE)
                                        | numFormat('0,0.000')}}
                                    </div>
                                    <div>
                                        {{
                                        getCountSumByState(data.trade_logs, config.PayState.ALL_DONE_CODE)
                                        | numFormat('0,0')}}
                                    </div>
                                </td>
                                <td alt="手续费">
                                    <div>
                                        {{
                                        getFeeSumByState(data.trade_logs, config.PayState.ALL_DONE_CODE)
                                        | numFormat('0,0.000')}}
                                    </div>
                                    <div>
                                        {{
                                        getCountSumByState(data.trade_logs, config.PayState.ALL_DONE_CODE)
                                        | numFormat('0,0')}}
                                    </div>
                                </td>
                                <td alt="总计" class="aisle-total">
                                    <div>
                                        {{ getTotalAmount(data.trade_logs) | numFormat('0,0.000') }}
                                    </div>
                                    <div>
                                        {{ getTotalCount(data.trade_logs) | numFormat('0,0') }}
                                    </div>
                                </td>
                            </tr>
                            <tr class="aisle-box"
                                v-show="data.isShowDetail"
                                v-for="(details, payment_type) in _.groupBy(data.trade_logs, 'payment_type')"
                                :key="payment_type">
                                <td class="width-40"></td>
                                <td>
                                    <span v-if="details[0].payment">{{ details[0].payment.name }}</span>
                                </td>
                                <td alt="申請成功" class="text-red">
                                    <div>
                                        {{
                                        getAmountSumByState(details, config.PayState.PREPARE_CODE)
                                        | numFormat('0,0.000') }}
                                    </div>
                                    <div>
                                        {{
                                        getCountSumByState(details, config.PayState.PREPARE_CODE)
                                        | numFormat('0,0') }}
                                    </div>
                                </td>
                                <td alt="交易中" class="text-red">
                                    <div>
                                        {{
                                        getAmountSumByState(details, config.PayState.OPERATING_CODE)
                                        | numFormat('0,0.000') }}
                                    </div>
                                    <div>
                                        {{
                                        getCountSumByState(details, config.PayState.OPERATING_CODE)
                                        | numFormat('0,0') }}
                                    </div>
                                </td>
                                <td alt="交易成功(未回調)" class="text-red">
                                    <div>
                                        {{
                                        getAmountSumByState(details, config.PayState.SUCCESS_CODE)
                                        | numFormat('0,0.000') }}
                                    </div>
                                    <div>
                                        {{ getCountSumByState(details, config.PayState.SUCCESS_CODE)
                                        | numFormat('0,0') }}
                                    </div>
                                </td>
                                <td alt="交易成功(金额不符)" class="text-red">
                                    <div>
                                        {{
                                        getAmountSumByState(details, config.PayState.AMOUNT_NOT_MATCH_CODE)
                                        | numFormat('0,0.000')}}
                                    </div>
                                    <div>
                                        {{ getCountSumByState(details, config.PayState.AMOUNT_NOT_MATCH_CODE)
                                        | numFormat('0,0') }}
                                    </div>
                                </td>
                                <td alt="交易失败" class="text-red">
                                    <div>
                                        {{
                                        getAmountSumByState(details, config.PayState.FAILED_CODE)
                                        | numFormat('0,0.000') }}
                                    </div>
                                    <div>
                                        {{ getCountSumByState(details, config.PayState.FAILED_CODE)
                                        | numFormat('0,0') }}
                                    </div>
                                </td>
                                <td alt="交易成功" class="text-green">
                                    <div>
                                        {{ getAmountSumByState(details, config.PayState.ALL_DONE_CODE)
                                        | numFormat('0,0.000') }}
                                    </div>
                                    <div>
                                        {{ getCountSumByState(details, config.PayState.ALL_DONE_CODE)
                                        | numFormat('0,0') }}
                                    </div>
                                </td>
                                <td alt="手续费">
                                    <div>
                                        {{ getFeeSumByState(details, config.PayState.ALL_DONE_CODE)
                                        | numFormat('0,0.000') }}
                                    </div>
                                    <div>
                                        {{ getCountSumByState(details, config.PayState.ALL_DONE_CODE)
                                        | numFormat('0,0') }}
                                    </div>
                                </td>
                                <td alt="总计" class="aisle-total">
                                    <div>
                                        {{ getTotalAmountFormat(details) | numFormat('0,0.000') }}
                                    </div>
                                    <div>
                                        {{ getTotalCountFormat(details) | numFormat('0,0') }}
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr alt="总额">
                                <td colspan="2">总额</td>
                                <td alt="申請成功">
                                    {{
                                    _.sumBy(datas, data =>
                                    getAmountSumByState(data.trade_logs, config.PayState.PREPARE_CODE)) |
                                    numFormat('0,0.000')
                                    }}
                                </td>
                                <td alt="交易中">
                                    {{
                                    _.sumBy(datas, data =>
                                    getAmountSumByState(data.trade_logs, config.PayState.OPERATING_CODE)) |
                                    numFormat('0,0.000')
                                    }}
                                </td>
                                <td alt="交易成功(未回調)">
                                    {{
                                    _.sumBy(datas, data =>
                                    getAmountSumByState(data.trade_logs, config.PayState.SUCCESS_CODE)) |
                                    numFormat('0,0.000')
                                    }}
                                </td>
                                <td alt="交易成功(金额不符)">
                                    {{
                                    _.sumBy(datas, data =>
                                    getAmountSumByState(data.trade_logs, config.PayState.AMOUNT_NOT_MATCH_CODE)) |
                                    numFormat('0,0.000')
                                    }}
                                </td>
                                <td alt="交易失败">
                                    {{
                                    _.sumBy(datas, data =>
                                    getAmountSumByState(data.trade_logs, config.PayState.FAILED_CODE)) |
                                    numFormat('0,0.000')
                                    }}
                                </td>
                                <td alt="交易成功">
                                    {{
                                    _.sumBy(datas, data =>
                                    getAmountSumByState(data.trade_logs, config.PayState.ALL_DONE_CODE)) |
                                    numFormat('0,0.000')
                                    }}
                                </td>
                                <td alt="手续费">
                                    {{
                                    _.sumBy(datas, data =>
                                    getFeeSumByState(data.trade_logs, config.PayState.ALL_DONE_CODE)) |
                                    numFormat('0,0.000')
                                    }}
                                </td>
                                <td alt="总计">
                                    {{
                                    _.sumBy(datas, data =>
                                    getTotalAmount(data.trade_logs)) |
                                    numFormat('0,0.000')
                                    }}
                                </td>
                            </tr>
                            <tr alt="笔数">
                                <td colspan="2">笔数</td>
                                <td alt="申請成功">
                                    {{
                                    _.sumBy(datas, data =>
                                    getCountSumByState(data.trade_logs, config.PayState.PREPARE_CODE)) |
                                    numFormat('0,0')
                                    }}
                                </td>
                                <td alt="交易中">
                                    {{
                                    _.sumBy(datas, data =>
                                    getCountSumByState(data.trade_logs, config.PayState.OPERATING_CODE)) |
                                    numFormat('0,0')
                                    }}
                                </td>
                                <td alt="交易成功(未回調)">
                                    {{
                                    _.sumBy(datas, data =>
                                    getCountSumByState(data.trade_logs, config.PayState.SUCCESS_CODE)) |
                                    numFormat('0,0')
                                    }}
                                </td>
                                <td alt="交易成功(金额不符)">
                                    {{
                                    _.sumBy(datas, data =>
                                    getCountSumByState(data.trade_logs, config.PayState.AMOUNT_NOT_MATCH_CODE)) |
                                    numFormat('0,0')
                                    }}
                                </td>
                                <td alt="交易失败">
                                    {{
                                    _.sumBy(datas, data =>
                                    getCountSumByState(data.trade_logs, config.PayState.FAILED_CODE)) |
                                    numFormat('0,0')
                                    }}
                                </td>
                                <td alt="交易成功">
                                    {{
                                    _.sumBy(datas, data =>
                                    getCountSumByState(data.trade_logs, config.PayState.ALL_DONE_CODE)) |
                                    numFormat('0,0')
                                    }}
                                </td>
                                <td alt="手续费">
                                    {{
                                    _.sumBy(datas, data =>
                                    getCountSumByState(data.trade_logs, config.PayState.ALL_DONE_CODE)) |
                                    numFormat('0,0')
                                    }}
                                </td>
                                <td alt="总计">
                                    {{
                                    _.sumBy(datas, data =>
                                    getTotalCount(data.trade_logs)) |
                                    numFormat('0,0')
                                    }}
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- table-responsive end -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ListMixins from "mixins/list"
    import PayState from 'config/PayState'
    import numFormat from 'vue-filter-number-format'

    export default {
        api: "",
        mixins: [ListMixins],
        data: () => ({
            searchData: {
                startDate: moment().startOf('day'),
                endDate: moment().endOf('day')
            },
            config: {
                PayState
            }
        }),
        methods: {
            getTotal() {
            },
            onGetList(res) {
                _.forEach(res.data, data => {
                    data.isShowDetail = false
                })
                this.datas = res.data
            },
            ////
            getCurrentPropByState(state) {
                return state == PayState.ALL_DONE_CODE ? 'real_paid_amount' : 'amount'
            },
            getAmountSumByState(datas, state) {
                return this.getSumByState(datas, state, this.getCurrentPropByState(state))
            },
            getFeeSumByState(datas, state) {
                return this.getSumByState(datas, state, 'fee')
            },
            getCountSumByState(datas, state) {
                return this.getSumByState(datas, state, 'count')
            },
            getSumByState(datas, state, prop) {
                return _.sumBy(datas, x => x.pay_state == state ? +x[prop] : 0)
            },
            ////
            getTotalAmount(datas) {
                return _.sumBy(datas, x => +x[this.getCurrentPropByState(x.pay_state)])
            },
            getTotalAmountFormat(datas) {
                return numFormat(this.getTotalAmount(datas), '0,0.000')
            },
            getTotalCount(datas) {
                return _.sumBy(datas, x => +x.count)
            },
            getTotalCountFormat(datas) {
                return numFormat(this.getTotalCount(datas), '0,0')
            },
        },
        mounted() {
            this.search()
        }
    }
</script>

<style scoped>
    .accordion-table th,
    .accordion-table td {
        min-width: 120px;
    }

    .accordion-table th.width-40,
    .accordion-table td {
        min-width: 40px;
    }

    .accordion-table td.aisle-total {
        min-width: 200px;
    }

    .aisle-name {
        cursor: pointer;
        position: relative;
    }

    .aisle-box {
        background-color: #f5f5f5;
    }
</style>
