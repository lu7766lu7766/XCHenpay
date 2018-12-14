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
                                <td class="text-red">
                                    <div>
                                        {{
                                        _.sumBy(data.trade_logs, x => x.pay_state == payState.apply ? x.amount : 0 ) |
                                        numFormat('0,0.000')
                                        }}
                                    </div>
                                    <div>
                                        {{
                                        _.sumBy(data.trade_logs, x => x.pay_state == payState.apply ? x.count : 0 ) |
                                        numFormat('0,0')
                                        }}
                                    </div>
                                </td>
                                <td class="text-red">
                                    <div>
                                        {{
                                        _.sumBy(data.trade_logs, x => x.pay_state == payState.trading ? x.amount : 0 ) |
                                        numFormat('0,0.000')
                                        }}
                                    </div>
                                    <div>
                                        {{
                                        _.sumBy(data.trade_logs, x => x.pay_state == payState.trading ? x.count : 0 ) |
                                        numFormat('0,0')
                                        }}
                                    </div>
                                </td>
                                <td class="text-red">
                                    <div>
                                        {{
                                        _.sumBy(data.trade_logs, x => x.pay_state == payState.success ? x.amount : 0 ) |
                                        numFormat('0,0.000')
                                        }}
                                    </div>
                                    <div>
                                        {{
                                        _.sumBy(data.trade_logs, x => x.pay_state == payState.success ? x.count : 0 ) |
                                        numFormat('0,0')
                                        }}
                                    </div>
                                </td>
                                <td class="text-red">
                                    <div>
                                        {{
                                        _.sumBy(data.trade_logs, x => x.pay_state == payState.fail ? x.amount : 0 ) |
                                        numFormat('0,0.000')
                                        }}
                                    </div>
                                    <div>
                                        {{
                                        _.sumBy(data.trade_logs, x => x.pay_state == payState.fail ? x.count : 0 ) |
                                        numFormat('0,0')
                                        }}
                                    </div>
                                </td>
                                <td class="text-green">
                                    <div>
                                        {{
                                        _.sumBy(data.trade_logs, x => x.pay_state == payState.done ? x.amount : 0 ) |
                                        numFormat('0,0.000')
                                        }}
                                    </div>
                                    <div>
                                        {{
                                        _.sumBy(data.trade_logs, x => x.pay_state == payState.done ? x.count : 0 ) |
                                        numFormat('0,0')
                                        }}
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        {{
                                        _.sumBy(data.trade_logs, x => x.pay_state == payState.done ? x.fee : 0 ) |
                                        numFormat('0,0.000')
                                        }}
                                    </div>
                                    <div>
                                        {{
                                        _.sumBy(data.trade_logs, x => x.pay_state == payState.done ? x.count : 0 ) |
                                        numFormat('0,0')
                                        }}
                                    </div>
                                </td>
                                <td class="aisle-total">
                                    <div>
                                        {{
                                        _.sumBy(data.trade_logs, x => x.amount) |
                                        numFormat('0,0.000')
                                        }}
                                    </div>
                                    <div>
                                        {{
                                        _.sumBy(data.trade_logs, x => x.count) |
                                        numFormat('0,0')
                                        }}
                                    </div>
                                </td>
                            </tr>
                            <tr class="aisle-box"
                                v-show="data.isShowDetail"
                                v-for="(details, payment_type) in _.groupBy(data.trade_logs, 'payment_type')"
                                :key="payment_type">
                                <td class="width-40"></td>
                                <td>{{ details[0].payment.name }}</td>
                                <td class="text-red">
                                    <div>
                                        {{
                                        _.sumBy(details, x => x.pay_state == payState.apply ? x.amount : 0 ) |
                                        numFormat('0,0.000')
                                        }}
                                    </div>
                                    <div>
                                        {{
                                        _.sumBy(details, x => x.pay_state == payState.apply ? x.count : 0 ) |
                                        numFormat('0,0')
                                        }}
                                    </div>
                                </td>
                                <td class="text-red">
                                    <div>
                                        {{
                                        _.sumBy(details, x => x.pay_state == payState.trading ? x.amount : 0 ) |
                                        numFormat('0,0.000')
                                        }}
                                    </div>
                                    <div>
                                        {{
                                        _.sumBy(details, x => x.pay_state == payState.trading ? x.count : 0 ) |
                                        numFormat('0,0')
                                        }}
                                    </div>
                                </td>
                                <td class="text-red">
                                    <div>
                                        {{
                                        _.sumBy(details, x => x.pay_state == payState.success ? x.amount : 0 ) |
                                        numFormat('0,0.000')
                                        }}
                                    </div>
                                    <div>
                                        {{
                                        _.sumBy(details, x => x.pay_state == payState.success ? x.count : 0 ) |
                                        numFormat('0,0')
                                        }}
                                    </div>
                                </td>
                                <td class="text-red">
                                    <div>
                                        {{
                                        _.sumBy(details, x => x.pay_state == payState.fail ? x.amount : 0 ) |
                                        numFormat('0,0.000')
                                        }}
                                    </div>
                                    <div>
                                        {{
                                        _.sumBy(details, x => x.pay_state == payState.fail ? x.count : 0 ) |
                                        numFormat('0,0')
                                        }}
                                    </div>
                                </td>
                                <td class="text-green">
                                    <div>
                                        {{
                                        _.sumBy(details, x => x.pay_state == payState.done ? x.amount : 0 ) |
                                        numFormat('0,0.000')
                                        }}
                                    </div>
                                    <div>
                                        {{
                                        _.sumBy(details, x => x.pay_state == payState.done ? x.count : 0 ) |
                                        numFormat('0,0')
                                        }}
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        {{
                                        _.sumBy(details, x => x.pay_state == payState.done ? x.fee : 0 ) |
                                        numFormat('0,0.000')
                                        }}
                                    </div>
                                    <div>
                                        {{
                                        _.sumBy(details, x => x.pay_state == payState.done ? x.count : 0 ) |
                                        numFormat('0,0')
                                        }}
                                    </div>
                                </td>
                                <td class="aisle-total">
                                    <div>
                                        {{
                                        _.sumBy(details, x => x.amount ) |
                                        numFormat('0,0.000')
                                        }}
                                    </div>
                                    <div>
                                        {{
                                        _.sumBy(details, x => x.count ) |
                                        numFormat('0,0')
                                        }}
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="2">总额</td>
                                <td>
                                    {{
                                    _.sumBy(datas, data =>
                                    _.sumBy(data.trade_logs, x => x.pay_state == payState.apply ? x.amount : 0 )) |
                                    numFormat('0,0.000')
                                    }}
                                </td>
                                <td>
                                    {{
                                    _.sumBy(datas, data =>
                                    _.sumBy(data.trade_logs, x => x.pay_state == payState.trading ? x.amount : 0 )) |
                                    numFormat('0,0.000')
                                    }}
                                </td>
                                <td>
                                    {{
                                    _.sumBy(datas, data =>
                                    _.sumBy(data.trade_logs, x => x.pay_state == payState.success ? x.amount : 0 )) |
                                    numFormat('0,0.000')
                                    }}
                                </td>
                                <td>
                                    {{
                                    _.sumBy(datas, data =>
                                    _.sumBy(data.trade_logs, x => x.pay_state == payState.fail ? x.amount : 0 )) |
                                    numFormat('0,0.000')
                                    }}
                                </td>
                                <td>
                                    {{
                                    _.sumBy(datas, data =>
                                    _.sumBy(data.trade_logs, x => x.pay_state == payState.done ? x.amount : 0 )) |
                                    numFormat('0,0.000')
                                    }}
                                </td>
                                <td>
                                    {{
                                    _.sumBy(datas, data =>
                                    _.sumBy(data.trade_logs, x => x.pay_state == payState.done ? x.fee : 0)) |
                                    numFormat('0,0.000')
                                    }}
                                </td>
                                <td>
                                    {{
                                    _.sumBy(datas, data =>
                                    _.sumBy(data.trade_logs, x => x.amount)) |
                                    numFormat('0,0.000')
                                    }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">笔数</td>
                                <td>
                                    {{
                                    _.sumBy(datas, data =>
                                    _.sumBy(data.trade_logs, x => x.pay_state == payState.apply ? x.count : 0 )) |
                                    numFormat('0,0')
                                    }}
                                </td>
                                <td>
                                    {{
                                    _.sumBy(datas, data =>
                                    _.sumBy(data.trade_logs, x => x.pay_state == payState.trading ? x.count : 0 )) |
                                    numFormat('0,0')
                                    }}
                                </td>
                                <td>
                                    {{
                                    _.sumBy(datas, data =>
                                    _.sumBy(data.trade_logs, x => x.pay_state == payState.success ? x.count : 0 )) |
                                    numFormat('0,0')
                                    }}
                                </td>
                                <td>
                                    {{
                                    _.sumBy(datas, data =>
                                    _.sumBy(data.trade_logs, x => x.pay_state == payState.fail ? x.count : 0 )) |
                                    numFormat('0,0')
                                    }}
                                </td>
                                <td>
                                    {{
                                    _.sumBy(datas, data =>
                                    _.sumBy(data.trade_logs, x => x.pay_state == payState.done ? x.count : 0 )) |
                                    numFormat('0,0')
                                    }}
                                </td>
                                <td>
                                    {{
                                    _.sumBy(datas, data =>
                                    _.sumBy(data.trade_logs, x => x.pay_state == payState.done ? x.count : 0 )) |
                                    numFormat('0,0')
                                    }}
                                </td>
                                <td>
                                    {{
                                    _.sumBy(datas, data =>
                                    _.sumBy(data.trade_logs, x => x.count)) |
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

    export default {
        api: "",
        mixins: [ListMixins],
        data: () => ({
            payState: {
                apply: 0,
                trading: 1,
                success: 2,
                done: 3,
                fail: 4
            },
            searchData: {
                startDate: moment().startOf('day'),
                endDate: moment().endOf('day')
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
            }
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
