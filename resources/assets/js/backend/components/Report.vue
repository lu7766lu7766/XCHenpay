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
                <span v-if="isLoading">Loading...</span>
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
                        <div>{{ data.success_amount | numFormat('0,0.00') }}</div>
                        <div>{{ data.success_count | numFormat }}</div>
                    </td>
                    <td class="text-red">
                        <div>{{ data.fail_amount | numFormat('0,0.00') }}</div>
                        <div>{{ data.fail_count | numFormat }}</div>
                    </td>
                    <td>
                        <div>{{ data.success_fee | numFormat('0,0.00') }}</div>
                        <div>{{ data.success_count | numFormat }}</div>
                    </td>
                    <td>
                        <div>{{ data.success_amount + data.fail_amount | numFormat('0,0.00') }}</div>
                        <div>{{ parseInt(data.success_count)+ parseInt(data.fail_count) | numFormat }}</div>
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
    import TimeMixins from '../mixins/time'
    import FetchMixins from '../mixins/fetch'

    export default {
        mixins: [TimeMixins, FetchMixins],
        computed: {
            success_count_sum() {
                return _.sumBy(this.datas, data => +data.success_count);
            },
            success_amount_sum: function () {
                return _.sumBy(this.datas, 'success_amount');
            },
            fail_count_sum: function () {
                return _.sumBy(this.datas, data => +data.fail_count);
            },
            fail_amount_sum: function () {
                return _.sumBy(this.datas, 'fail_amount');
            },
            fee_sum: function () {
                return _.sumBy(this.datas, 'success_fee');
            },
            count_sum: function () {
                return _.sumBy(this.datas, function (data) {
                    return parseInt(data.success_count) + parseInt(data.fail_count)
                });
            },
            amount_sum: function () {
                return _.sumBy(this.datas, function (data) {
                    return data.success_amount + data.fail_amount;
                });
            }
        },
        methods: {
            async fetch() {
                var res = await this.post('/admin/search/reportQuery', {
                    "startDate": this.startTime.startOf('day').format('YYYY-MM-DD HH:mm:ss'),
                    "endDate": this.endTime.endOf('day').format('YYYY-MM-DD HH:mm:ss')
                })
                if (res.ok) {
                    this.isLoading = false
                    this.datas = res.body.data
                }
            }
        }
    }
</script>
