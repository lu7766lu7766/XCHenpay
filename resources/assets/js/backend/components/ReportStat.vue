<template>
    <div class="panel-body">
        <div class="search-box">
            <div class="col-sm-6 col-md-2">
                <date-time-picker v-model="startTime"/>
            </div>
            <div class="col-sm-6 col-md-2">
                <date-time-picker v-model="endTime"/>
            </div>
            <div class="col-sm-12 col-md-8">
                <button type="button" class="btn btn-orange-lighter" data-toggle="button"
                        @click="timeContainer = yesterday()">昨日
                </button>
                <button type="button" class="btn btn-orange-lighter" data-toggle="button"
                        @click="timeContainer = today()">今日
                </button>
                <button type="button" class="btn btn-orange-lighter" data-toggle="button"
                        @click="timeContainer = lastWeek()">上周
                </button>
                <button type="button" class="btn btn-orange-lighter" data-toggle="button"
                        @click="timeContainer = thisWeek()">本周
                </button>
                <button type="button" class="btn btn-green-lighter" data-toggle="button"
                        @click="timeContainer = lastMonth()">上月
                </button>
                <button type="button" class="btn btn-green-lighter" data-toggle="button"
                        @click="timeContainer = thisMonth()">本月
                </button>
                <button type="button" class="btn btn-search" data-toggle="button"
                        @click="fetch()">搜寻
                </button>
            </div>
        </div>
        <!-- end of search-box -->
        <div class="table-scrollable">
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
                <tr v-for="(data,index) in datas">
                    <td>{{ index + 1 }}</td>
                    <td>{{ data.company_name }}</td>
                    <td class="text-green">
                        <div>{{
                            data.trade_logs[0]
                            ? (data.trade_logs[0].success_amount )
                            : 0 | numFormat('0,0.00')}}
                        </div>
                        <div>{{
                            data.trade_logs[0]
                            ? (data.trade_logs[0].success_count )
                            : 0 | numFormat}}
                        </div>
                    </td>
                    <td class="text-red">
                        <div>{{
                            data.trade_logs[0]
                            ? (data.trade_logs[0].fail_amount )
                            : 0 | numFormat('0,0.00')}}
                        </div>
                        <div>{{
                            data.trade_logs[0]
                            ? (data.trade_logs[0].fail_count )
                            : 0 | numFormat}}
                        </div>
                    </td>
                    <td>
                        <div>{{
                            data.trade_logs[0]
                            ? (data.trade_logs[0].success_fee )
                            : 0 | numFormat('0,0.00')}}
                        </div>
                        <div>{{
                            data.trade_logs[0]
                            ? (data.trade_logs[0].success_count )
                            : 0 | numFormat }}
                        </div>
                    </td>
                    <td>
                        <div>{{
                            data.trade_logs[0]
                            ? parseInt(data.trade_logs[0].success_amount) + parseInt(data.trade_logs[0].fail_amount)
                            : 0| numFormat('0,0.00') }}
                        </div>
                        <div>{{
                            data.trade_logs[0]
                            ? parseInt(data.trade_logs[0].success_count)+ parseInt(data.trade_logs[0].fail_count)
                            : 0| numFormat }}
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
        <!-- end of table-scrollable -->
    </div>


</template>

<script>
    import ReportMixins from 'mixins/report'

    export default {
        mixins: [ReportMixins],
        computed: {
            success_count_sum() {
                return _.sumBy(this.datas, data =>
                    data.trade_logs[0]
                        ? (+data.trade_logs[0].success_count)
                        : 0);
            },
            success_amount_sum: function () {
                return _.sumBy(this.datas, data =>
                    data.trade_logs[0]
                        ? (+data.trade_logs[0].success_amount)
                        : 0);
            },
            fail_count_sum: function () {
                return _.sumBy(this.datas, data =>
                    data.trade_logs[0]
                        ? (+data.trade_logs[0].fail_count)
                        : 0);
            },
            fail_amount_sum: function () {
                return _.sumBy(this.datas, data =>
                    data.trade_logs[0]
                        ? (+data.trade_logs[0].fail_amount)
                        : 0);
            },
            fee_sum: function () {
                return _.sumBy(this.datas, data =>
                    data.trade_logs[0]
                        ? (+data.trade_logs[0].success_fee)
                        : 0);
            },
            count_sum: function () {
                return _.sumBy(this.datas, function (data) {
                    return data.trade_logs[0]
                        ? parseInt(data.trade_logs[0].success_count) + parseInt(data.trade_logs[0].fail_count)
                        : 0
                });
            },
            amount_sum: function () {
                return _.sumBy(this.datas, function (data) {
                    return data.trade_logs[0]
                        ? parseInt(data.trade_logs[0].success_amount) + parseInt(data.trade_logs[0].fail_amount)
                        : 0;
                });
            }
        },
        methods: {
            async fetch() {
                var res = await this.post('/admin/search/reportStatQuery', {
                    "startDate": this.startTime.format('YYYY-MM-DD HH:mm:ss'),
                    "endDate": this.endTime.format('YYYY-MM-DD HH:mm:ss')
                })
                if (res.ok && res.body.code == 200) {
                    this.datas = res.body.data
                } else {
                    var err_msg = '与伺服器沟通错误';
                    if (Object.keys(res.body.data).length || res.body.data.length) {
                        var err_list = [];
                        for (var val in res.body.data) {
                            err_list.push(res.body.data[val].join('\n'))
                        }
                        err_msg = err_list.join('\n')
                    }
                    this.datas = [];
                    alert(err_msg)
                }
            }
        }
    }
</script>
