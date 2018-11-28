<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="search-box">
                        <date-time-picker placeholder="開始日期" v-model="searchData.startDate"/>
                        <date-time-picker placeholder="結束日期" v-model="searchData.endDate"/>
                        <picker-button :startTime.sync="searchData.startDate" :endTime.sync="searchData.endDate"/>
                        <div>
                            <button type="button" class="btn btn-search" data-toggle="button" @click="search">搜寻
                            </button>
                        </div>
                    </div>
                    <!-- search-box end -->
                    <div class="table-responsive m-t-15">
                        <table class="table table-hover text-center table-bordered table-box report-table">
                            <thead>
                            <tr>
                                <th class="width-40">#</th>
                                <th>商户</th>
                                <th>交易成功</th>
                                <th>交易失败</th>
                                <th>手续费</th>
                                <th>总计</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(data, index) in datas" :key="index">
                                <td>{{ startIndex + index }}</td>
                                <td>{{ data.company_name }}</td>
                                <td class="text-green">
                                    <div>
                                        {{
                                        data.trade_logs[0]
                                        ? (data.trade_logs[0].success_amount )
                                        : 0 | numFormat('0,0.00')
                                        }}
                                    </div>
                                    <div>
                                        {{
                                        data.trade_logs[0]
                                        ? (data.trade_logs[0].success_count )
                                        : 0 | numFormat
                                        }}
                                    </div>
                                </td>
                                <td class="text-red">
                                    <div>
                                        {{
                                        data.trade_logs[0]
                                        ? (data.trade_logs[0].fail_amount )
                                        : 0 | numFormat('0,0.00')
                                        }}
                                    </div>
                                    <div>
                                        {{
                                        data.trade_logs[0]
                                        ? (data.trade_logs[0].fail_count )
                                        : 0 | numFormat
                                        }}
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        {{
                                        data.trade_logs[0]
                                        ? (data.trade_logs[0].success_fee )
                                        : 0 | numFormat('0,0.00')
                                        }}
                                    </div>
                                    <div>
                                        {{
                                        data.trade_logs[0]
                                        ? (data.trade_logs[0].success_count )
                                        : 0 | numFormat
                                        }}
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        {{
                                        data.trade_logs[0]
                                        ? parseInt(data.trade_logs[0].success_amount) +
                                        parseInt(data.trade_logs[0].fail_amount)
                                        : 0| numFormat('0,0.00')
                                        }}
                                    </div>
                                    <div>
                                        {{
                                        data.trade_logs[0]
                                        ? parseInt(data.trade_logs[0].success_count)+
                                        parseInt(data.trade_logs[0].fail_count)
                                        : 0| numFormat
                                        }}
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="2">總額</td>
                                <td>{{ this.success_amount_sum | numFormat('0,0.00') }}</td>
                                <td>{{ this.fail_amount_sum | numFormat('0,0.00') }}</td>
                                <td>{{ this.fee_sum | numFormat('0,0.00') }}</td>
                                <td>{{ this.amount_sum | numFormat('0,0.00') }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">筆數</td>
                                <td>{{ this.success_count_sum | numFormat }}</td>
                                <td>{{ this.fail_count_sum | numFormat }}</td>
                                <td>{{ this.count_sum | numFormat }}</td>
                                <td>{{ this.count_sum | numFormat }}</td>
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
        api: "reportStatistics",
        mixins: [ListMixins],
        data: () => ({
            searchData: {
                startDate: moment().startOf('day'),
                endDate: moment().endOf('day')
            }
        }),
        methods: {
            onGetList(res) {
                this.datas = res.data
            },
            getTotal() {
            }
        },
        computed: {
            success_count_sum() {
                return _.sumBy(this.datas, data =>
                    data.trade_logs[0]
                        ? (+data.trade_logs[0].success_count)
                        : 0)
            },
            success_amount_sum: function () {
                return _.sumBy(this.datas, data =>
                    data.trade_logs[0]
                        ? (+data.trade_logs[0].success_amount)
                        : 0)
            },
            fail_count_sum: function () {
                return _.sumBy(this.datas, data =>
                    data.trade_logs[0]
                        ? (+data.trade_logs[0].fail_count)
                        : 0)
            },
            fail_amount_sum: function () {
                return _.sumBy(this.datas, data =>
                    data.trade_logs[0]
                        ? (+data.trade_logs[0].fail_amount)
                        : 0)
            },
            fee_sum: function () {
                return _.sumBy(this.datas, data =>
                    data.trade_logs[0]
                        ? (+data.trade_logs[0].success_fee)
                        : 0)
            },
            count_sum: function () {
                return _.sumBy(this.datas, function (data) {
                    return data.trade_logs[0]
                        ? parseInt(data.trade_logs[0].success_count) + parseInt(data.trade_logs[0].fail_count)
                        : 0
                })
            },
            amount_sum: function () {
                return _.sumBy(this.datas, function (data) {
                    return data.trade_logs[0]
                        ? parseInt(data.trade_logs[0].success_amount) + parseInt(data.trade_logs[0].fail_amount)
                        : 0
                })
            }
        }
    }
</script>
