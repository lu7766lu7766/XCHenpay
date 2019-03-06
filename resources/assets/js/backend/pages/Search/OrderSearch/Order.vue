<template>
    <div>
        <div class="card m-b-30">
            <div class="card-header">
                订单资讯
            </div>
            <div class="card-body">
                <div class="row delivery-amount">
                    <div class="col-sm">
                        <div class="card mini-stat bg-primary" style="background-color: #58db83 !important;">
                            <div class="card-body mini-stat-img">
                                <div class="mini-stat-icon">
                                    <i class="mdi mdi-cube-outline float-right"></i>
                                </div>
                                <div class="text-white">
                                    <h6 class="text-uppercase mb-3">交易成功</h6>
                                    <h4>{{ count.successful_deal | numFormat('0,0.000') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="card mini-stat bg-primary" style="background-color: #ff426a !important;">
                            <div class="card-body mini-stat-img">
                                <div class="mini-stat-icon">
                                    <i class="mdi mdi-cube-outline float-right"></i>
                                </div>
                                <div class="text-white">
                                    <h6 class="text-uppercase mb-3">交易失敗</h6>
                                    <h4>{{ count.failure_deal | numFormat('0,0.000') }}</h4>
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
                                    <h6 class="text-uppercase mb-3">总手续费</h6>
                                    <h4>{{ count.fee | numFormat('0,0.000') }}</h4>
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
                                    <h6 class="text-uppercase mb-3">总金额</h6>
                                    <h4>{{ count.amount | numFormat('0,0.00') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card m-b-30">
            <div class="card-header">
                订单查询
                <span class="refresh" @click="refresh">
                    <i class="mdi mdi-refresh"></i>刷新
                </span>
            </div>
            <div class="card-body">
                <div class="search-box">
                    <date-time-picker v-model="searchData.start" placeholder="開始日期"/>
                    <date-time-picker v-model="searchData.end" placeholder="結束日期"/>
                    <picker-button :startTime.sync="searchData.start" :endTime.sync="searchData.end"/>
                    <div class="search-select">
                        <select class="form-control" v-model="searchData.pay_state">
                            <option value="">交易状态</option>
                            <option v-for="code in options.payState"
                                    :key="code"
                                    :value="code">{{ config.payState[code] }}
                            </option>
                        </select>
                    </div>
                    <div class="search-select">
                        <select class="form-control" v-model="searchData.payment_type">
                            <option v-for="(payment, val) in options.paymentType"
                                    :key="val"
                                    :value="val">{{ payment.name }}
                            </option>
                        </select>
                    </div>
                    <div class="search-input">
                        <input type="text" class="form-control" placeholder="关键字" v-model="searchData.keyword">
                    </div>
                    <div>
                        <button type="button" class="btn btn-search" data-toggle="button" @click="search()">搜寻</button>
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
                            <th>交易状态</th>
                            <th>商户名称</th>
                            <th>系统交易号</th>
                            <th>商户交易号</th>
                            <th class="sorting sorting" @click="changeSort('amount')" :class="{
                                'sort-asc': this.sort.column == 'amount' && this.sort.direction == 'asc',
                                'sort-desc': this.sort.column == 'amount' && this.sort.direction == 'desc'
                            }">金额
                            </th>
                            <th>支付方式</th>
                            <th>手续费</th>
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
                                <span class="badge badge-warning badge-pill" v-if="data.pay_state == 1">交易中</span>
                                <span class="badge badge-danger badge-pill" v-else-if="data.pay_state == 4">交易失敗</span>
                                <span class="badge badge-success badge-pill" v-else-if="data.pay_state == 3">交易结束</span>
                                <span class="badge badge-info badge-pill"
                                      v-else>{{ config.payState[data.pay_state] }}
                                </span>
                            </td>
                            <td>{{ data.company.company_name }}</td>
                            <td>{{ data.trade_seq }}</td>
                            <td>{{ data.trade_service_id }}</td>
                            <td class="text-right">{{ data.amount | numFormat('0,0.00') }}</td>
                            <td>
                                {{
                                data.payment_type == 0
                                ? '-'
                                : options.paymentType[data.payment_type]
                                ? options.paymentType[data.payment_type].name
                                : ''
                                }}
                            </td>
                            <td class="text-right">{{ data.fee | numFormat('0,0.000') }}</td>
                            <td>{{ data.created_at }}</td>
                            <td class="width-control">
                                <a @click="showInfo(data.id)">
                                    <i class="mdi mdi-information-outline text-blue"></i>
                                </a>
                                <a v-if="UserInfo.this().has(Permission.OrderEdit) || UserInfo.this().has(Permission.OrderSearch)"
                                   @click="showState(data.id)">
                                    <i class="mdi mdi-pencil-box-outline"></i>
                                </a>
                                <a class="back">
                                    <i v-if="needNotify(data.pay_state) && UserInfo.this().has(Permission.OrderNotify)"
                                       @click="confirmNotify(data.id)"
                                       class="far fa-caret-square-down text-orange"></i>
                                    <i v-else
                                       class="far fa-caret-square-down text-uncontrol"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2" class="text-right">小计</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right">
                                {{
                                _.sumBy(datas, x => + x.amount) | numFormat('0,0.00')
                                }}
                            </td>
                            <td></td>
                            <td class="text-right">
                                {{
                                _.sumBy(datas, x => + x.fee) | numFormat('0,0.000')
                                }}
                            </td>
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
        <order-info/>
        <order-state/>
    </div>
</template>

<script>
    import ListMixins from 'mixins/list'
    import PayState from 'config/PayState'

    export default {
        api: "order",
        mixins: [ListMixins],
        components: {
            OrderInfo: require('./modal/OrderInfo'),
            OrderState: require('./modal/OrderState')
        },
        data: () => ({
            options: {
                payState: PayState.enum(),
                paymentType: {}
            },
            sort: {
                column: 'created_at'
            },
            searchData: {
                start: moment().startOf('day'),
                end: moment().endOf('day'),
                keyword: '',
                pay_state: '',
                payment_type: 0,
            },
            count: {
                amount: 0,
                fee: 0,
                successful_deal: 0,
                failure_deal: 0
            },
            config: {
                payState: PayState.summaryMap(),
                notify: {
                    title: '是否确认回调',
                    text: '',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'm-l-10',
                    confirmButtonColor: '#3eb7ba',
                    cancelButtonColor: '#6c757d',
                    cancelButtonText: '取消',
                    confirmButtonText: '确认'
                },
                success: {
                    title: '已回调',
                    text: '',
                    type: 'success',
                },
                fail: {
                    title: '回调失败',
                    text: '',
                    type: 'error',
                },
                notifyState: [2, 3]
            }
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
                this.proccessAjax('dataInit', {}, res => {
                    this.options.paymentType = _.assign(_.keyBy(res.data, 'i6pay_id'), {0: {name: '支付方式'}})
                })
            },
            onGetList(res) {
                this.datas = res[0].data

                this.count.successful_deal = res[1].data.successful_deal
                this.count.failure_deal = res[1].data.failure_deal
                this.count.amount = res[1].data.amount
                this.count.fee = res[1].data.fee
            },
            onGetTotal(res) {
                this.paginate.total = res.data
            },
            showInfo(id) {
                this.$root.$emit('orderInfo.show', id)
            },
            showState(id) {
                this.$root.$emit('orderState.show', id)
            },
            confirmNotify(id) {
                swal(this.config.notify).then(() => {
                    this.proccessAjax('notify', {id}, res => {
                        swal(res.data ? this.config.success : this.config.fail)
                    })
                }).catch(_ => {})
            },
            needNotify(state) {
                return this.config.notifyState.indexOf(state) > -1
            }
        },
        computed: {
            company_id() {
                return this.$parent.company_id
            },
            customGetReqBody() {
                return {
                    company: this.company_id,
                    sort: this.sort.column,
                    direction: this.sort.direction
                }
            }
        },
        mounted() {
            this.dataInit()
            this.search()
        }
    }
</script>
