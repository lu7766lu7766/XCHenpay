<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    下发资讯
                </div>
                <div class="card-body">
                    <div class="row delivery-amount">
                        <div class="col-sm">
                            <div class="card mini-stat bg-primary">
                                <div class="card-body mini-stat-img">
                                    <div class="mini-stat-icon">
                                        <i class="mdi mdi-cube-outline float-right"></i>
                                    </div>
                                    <div class="text-white">
                                        <h6 class="text-uppercase mb-3">总交易金额</h6>
                                        <h4>{{ count.totalMoney | numFormat('0,0.000')}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="card mini-stat bg-primary" style="background-color: #ffb000 !important;">
                                <div class="card-body mini-stat-img">
                                    <div class="mini-stat-icon">
                                        <i class="mdi mdi-clock-fast float-right"></i>
                                    </div>
                                    <div class="text-white">
                                        <h6 class="text-uppercase mb-3">总通道手续费</h6>
                                        <h4>{{ count.totalFee | numFormat('0,0.000')}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="card mini-stat bg-primary" style="background-color: #fb5597 !important;">
                                <div class="card-body mini-stat-img">
                                    <div class="mini-stat-icon">
                                        <i class="mdi mdi-cash-usd float-right"></i>
                                    </div>
                                    <div class="text-white">
                                        <h6 class="text-uppercase mb-3">申请中金额</h6>
                                        <h4>{{ count.applying | numFormat('0,0.000')}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="card mini-stat bg-primary" style="background-color: #5271af !important;">
                                <div class="card-body mini-stat-img">
                                    <div class="mini-stat-icon">
                                        <i class="mdi mdi-credit-card float-right"></i>
                                    </div>
                                    <div class="text-white">
                                        <h6 class="text-uppercase mb-3">已提现金额</h6>
                                        <h4>{{ count.accepted | numFormat('0,0.000')}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="card mini-stat bg-primary" style="background-color: #7d6cc4 !important;">
                                <div class="card-body mini-stat-img">
                                    <div class="mini-stat-icon">
                                        <i class="mdi mdi-cash-multiple float-right"></i>
                                    </div>
                                    <div class="text-white">
                                        <h6 class="text-uppercase mb-3">可提领金额</h6>
                                        <h4>{{ count.withdrawal | numFormat('0,0.000')}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card end -->
            <div class="card m-b-30">
                <div class="card-header">
                    下发列表
                    <span class="refresh" @click="refresh">
                        <i class="mdi mdi-refresh"></i>刷新
                    </span>
                </div>
                <div class="card-body">
                    <div class="search-box">
                        <date-time-picker v-model="searchData.start_time" placeholder="開始日期"/>
                        <date-time-picker v-model="searchData.end_time" placeholder="結束日期"/>
                        <picker-button :startTime.sync="searchData.start_time" :endTime.sync="searchData.end_time"/>

                        <div class="search-select">
                            <select class="form-control" v-model="searchData.status">
                                <option value="">下发状态</option>
                                <option v-for="(name, val) in options.lendStatus" :key="val" :value="val">
                                    {{ name }}
                                </option>
                            </select>
                        </div>
                        <div class="search-input">
                            <input type="text" class="form-control" placeholder="关键字" v-model="searchData.number">
                        </div>
                        <div>
                            <button type="button" class="btn btn-search" data-toggle="button" @click="search">搜寻
                            </button>
                        </div>
                    </div>
                    <!-- search-box end -->
                    <div class="row view-btn-box">
                        <div class="col-sm-6 view-btn">
                            <button class="btn btn-application btn-full" v-if="canApply"
                                    @click="$root.$emit('lendListApply.show')">
                                申请
                            </button>
                        </div>
                        <per-page-selector v-model="paginate.perpage"/>
                    </div>
                    <!-- view-box end -->
                    <div class="table-responsive m-t-15">
                        <table class="table table-hover text-center table-bordered table-box table-sort">
                            <thead>
                            <tr>
                                <th class="width-40">#</th>
                                <th>下发状态</th>
                                <th>商户名称</th>
                                <th>单号</th>
                                <th>户名</th>
                                <th>银行卡号</th>
                                <th>下发金额</th>
                                <th class="width-status">银行卡状态</th>
                                <th class="width-date sorting" @click="changeSort('created_at')" :class="{
                                    'sort-asc': this.sort.column == 'created_at' && this.sort.direction == 'asc',
                                    'sort-desc': this.sort.column == 'created_at' && this.sort.direction == 'desc'
                                }">申请时间
                                </th>
                                <th class="width-control">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(data, index) in datas" :key="index">
                                <td>{{ startIndex + index }}</td>
                                <td>
                                    <span class="badge badge-warning badge-pill"
                                          v-if="data.lend_state == 0">下发中
                                    </span>
                                    <span class="badge badge-success badge-pill"
                                          v-else-if="data.lend_state == 1">完成下发
                                    </span>
                                    <span class="badge badge-danger badge-pill"
                                          v-else-if="data.lend_state == 2">拒绝下发
                                    </span>
                                    <span class="badge badge-info badge-pill"
                                          v-else>{{ options.lendStatus[data.lend_state] }}
                                    </span>
                                </td>
                                <td>{{ UserInfo.this().getCompanyName() }}</td>
                                <td class="text-red">{{ data.record_seq }}</td>
                                <td>{{ data.account.name }}</td>
                                <td>{{ data.account.account }}</td>
                                <td class="text-right">{{ (data.amount - data.fee) | numFormat('0,0.000') }}</td>
                                <td class="width-status">
                                    <i class="mdi mdi-check-circle-outline text-green"
                                       v-if="!data.account.deleted_at"></i>
                                    <i class="mdi mdi-close-circle-outline text-red"
                                       v-else></i>
                                </td>
                                <td>{{ data.created_at }}</td>
                                <td class="width-control">
                                    <a data-toggle="modal" data-target="#info">
                                        <i class="mdi mdi-information-outline text-blue"
                                           @click="$root.$emit('lendListInfo.show', data.id)"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="6" class="text-right">小计</td>
                                <td class="text-right">
                                    {{
                                    _.sumBy(datas, x => x.amount - x.fee) | numFormat('0,0.000')
                                    }}
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- table-responsive end -->
                    <paginate :page="paginate.page" :last-page="lastPage" @pageChange="pageChange"/>
                    <!-- <nav aria-label="Page navigation" class="page-bar"> end -->
                </div>
            </div>
            <!-- card end -->
        </div>
        <lend-list-apply/>
        <lend-list-info/>
    </div>

</template>

<script>
    import ListMixins from 'mixins/list'

    export default {
        api: "lendList",
        mixins: [ListMixins],
        components: {
            LendListApply: require('./modal/Apply'),
            LendListInfo: require('./modal/Info')
        },
        data: () => ({
            options: {
                lendStatus: {},
                bankAccount: []
            },
            sort: {
                column: 'created_at'
            },
            searchData: {
                start_time: moment().startOf('day'),
                end_time: moment().endOf('day'),
                number: '',
                status: ''
            },
            count: {
                accepted: 0,
                applying: 0,
                totalFee: 0,
                totalMoney: 0,
                withdrawal: 0
            }
        }),
        methods: {
            dataInit() {
                this.amountInit()
                this.statusInit()
                this.bankAccountInit()
            },
            amountInit() {
                this.proccessAjax('amountInfo', {}, res => {
                    this.count.accepted = res.data.accepted
                    this.count.applying = res.data.applying
                    this.count.totalFee = res.data.totalFee
                    this.count.totalMoney = res.data.totalMoney
                    this.count.withdrawal = res.data.withdrawal
                })
            },
            statusInit() {
                this.proccessAjax('lendStatus', {}, res => {
                    this.options.lendStatus = res.data
                }, false)
            },
            bankAccountInit() {
                this.proccessAjax('bankAccountInfo', {}, res => {
                    this.options.bankAccount = res.data
                }, false)
            },
            onGetTotal(res) {
                this.paginate.total = res.data.count
            },
            onGetList(res) {
                this.datas = res.data
            }
        },
        computed: {
            customGetReqBody() {
                return {
                    sort: this.sort.direction.toUpperCase()
                }
            },
            canApply() {
                return UserInfo.this().getApplyStatus() === 'on'
            }
        },
        mounted() {
            this.dataInit()
            this.search()
        }
    }
</script>
