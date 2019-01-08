<template>
    <div class="row">
        <div class="col-lg-12">
            <company-selector v-model="searchData.user_id" :options="options.companies"/>
            <!-- card end -->
            <div v-if="searchData.user_id !== -1">
                <div class="card m-b-30">
                    <div class="card-header">
                        下发资讯
                    </div>
                    <div class="card-body">
                        <div class="row delivery-amount">
                            <div class="col-sm">
                                <div class="card mini-stat bg-primary" style="background-color: #fb5597 !important;">
                                    <div class="card-body mini-stat-img">
                                        <div class="mini-stat-icon">
                                            <i class="mdi mdi-cash-usd float-right"></i>
                                        </div>
                                        <div class="text-white">
                                            <h6 class="text-uppercase mb-3">申请中金额</h6>
                                            <h4>{{ count.totalApplying | numFormat('0,0.000') }}</h4>
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
                                            <h4>{{ count.totalWithdrawal | numFormat('0,0.000') }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="card mini-stat bg-primary">
                                    <div class="card-body mini-stat-img">
                                        <div class="mini-stat-icon">
                                            <i class="mdi mdi-cube-outline float-right"></i>
                                        </div>
                                        <div class="text-white">
                                            <h6 class="text-uppercase mb-3">总计</h6>
                                            <h4>{{ count.total | numFormat('0,0.000') }}</h4>
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
                            <date-time-picker v-model="searchData.start_date" placeholder="開始日期"/>
                            <date-time-picker v-model="searchData.end_date" placeholder="結束日期"/>
                            <picker-button :startTime.sync="searchData.start_date" :endTime.sync="searchData.end_date"/>
                            <div class="search-select">
                                <select class="form-control" v-model="searchData.lend_state">
                                    <option value="">下发状态</option>
                                    <option v-for="(name, val) in options.lendStatus" :key="val" :value="val">
                                        {{ name }}
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
                        <div class="row view-box m-t-15">
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
                                        <span class="badge badge-pill" :class="{
                                            'badge-warning': data.lend_state == 0,
                                            'badge-success': data.lend_state == 1,
                                            'badge-danger': data.lend_state == 2
                                        }">{{ options.lendStatus[data.lend_state] }}</span>
                                    </td>
                                    <td>{{ data.user.company_name }}</td>
                                    <td class="text-red">{{ data.record_seq }}</td>
                                    <td>{{ data.account.name }}</td>
                                    <td>{{ data.account.account }}</td>
                                    <td class="text-right">{{ (data.amount - data.fee) | numFormat('0,0.000') }}</td>
                                    <td class="width-status">
                                        <i class="mdi mdi-check-circle-outline text-green"
                                           v-if="!data.account.delete_at"></i>
                                        <i class="mdi mdi-close-circle-outline text-red" v-else></i>
                                    </td>
                                    <td>{{ data.created_at }}</td>
                                    <td class="width-control">
                                        <a @click="showInfo(data)">
                                            <i class="mdi mdi-information-outline text-blue"></i>
                                        </a>
                                        <a @click="showState(data)">
                                            <i class="mdi mdi-pencil-box-outline"></i>
                                        </a>
                                    </td>
                                </tr>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="6" class="text-right">小计</td>
                                    <td class="text-right">
                                        {{
                                        _.sumBy(datas, x => + x.amount - x.fee) | numFormat('0,0.000')
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
        </div>
        <lend-manage-info/>
        <lend-manage-state/>
    </div>
</template>

<script>
    import ListMixins from "mixins/list"

    export default {
        api: "lendManage",
        mixins: [ListMixins],
        components: {
            CompanySelector: require('@/CompanySelector'),
            LendManageInfo: require('./modal/Info'),
            LendManageState: require('./modal/State')
        },
        data: () => ({
            options: {
                companies: [],
                lendStatus: []
            },
            searchData: {
                user_id: -1,
                start_date: moment().startOf('day'),
                end_date: moment().endOf('day'),
                keyword: '',
                lend_state: ''
            },
            sort: {
                column: 'created_at'
            },
            count: {
                totalApplying: 0,
                totalWithdrawal: 0,
                total: 0
            }
        }),
        watch: {
            'searchData.user_id'() {
                if (this.searchData.user_id !== -1) {
                    this.search()
                }
            }
        },
        methods: {
            dataInit() {
                this.proccessAjax('dataInit', {}, this.onDataInit)
            },
            onDataInit(res) {
                this.options.companies = _.concat([{id: 'all', company_name: '全部'}], _.map(res.data.companies))
                this.options.lendStatus = res.data.lendStatus
            },
            onGetTotal(res) {
                const {0: totalRes, 1: applyTotalRes} = res
                this.paginate.total = totalRes.data.total
                this.count.total = applyTotalRes.data.total
                this.count.totalApplying = applyTotalRes.data.totalApplying
                this.count.totalWithdrawal = applyTotalRes.data.totalWithdrawal
            },
            onGetList(res) {
                this.datas = res.data
            },
            showInfo(data) {
                this.$root.$emit('lendManageInfo.show', data)
            },
            showState(data) {
                this.$root.$emit('lendManageState.show', data)
            }
        },
        computed: {
            customGetReqBody() {
                return {
                    user_id: this.searchData.user_id !== 'all' ? this.searchData.user_id : ''
                }
            }
        },
        mounted() {
            this.dataInit()
        }
    }
</script>
