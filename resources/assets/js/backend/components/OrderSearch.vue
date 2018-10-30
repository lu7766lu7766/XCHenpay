<template>
    <div class="panel-body">
        <div class="search-box">
            <div class="clearfix">
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

                </div>
            </div>
            <div class="clearfix">
                <div class="col-sm-3 col-md-2">
                    <select class="form-control" v-model="pay_state">
                        <option value="">交易狀態</option>
                        <option v-for="(name, val) in options.payState"
                                :key="val"
                                :value="val">{{ name }}
                        </option>
                    </select>
                </div>
                <div class="col-sm-3 col-md-2">
                    <select class="form-control" v-model="payment_type">
                        <option v-for="(name, val) in options.paymentType"
                                :key="val"
                                :value="val">{{ name }}
                        </option>
                    </select>
                </div>
                <div class="col-sm-3 col-md-2">
                    <input type="text" class="form-control" placeholder="关键字" v-model="searchData.keyword">
                </div>
                <div class="col-sm-1">
                    <button type="button" class="btn btn-search" data-toggle="button"
                            @click="search()">搜寻
                    </button>
                    <span v-if="isLoading">Loading...</span>
                </div>
            </div>
        </div>
        <template v-if="datas.length">
            <div class="row view-box">
                <div class="col-sm-6 view-page">
                    每页显示
                    <select class="form-control" v-model="paginate.perpage">
                        <option :value="10">10</option>
                        <option :value="25">25</option>
                        <option :value="50">50</option>
                        <option :value="100">100</option>
                    </select>
                    笔资料
                </div>
                <div class="col-sm-6 view-info">
                    <span><b>总金额:</b>{{ amount | numFormat('0.00') }}</span>
                    <span><b>总手续费:</b>{{ fee | numFormat('0.00') }}</span>
                </div>
            </div>
            <!-- end of search-box -->
            <div class="table-scrollable">
                <div id="order-sort_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-hover text-center table-bordered table-box dataTable"
                                   id="order-sort"
                                   role="grid">
                                <thead>
                                <tr role="row">
                                    <th class="width-40 sorting_asc" rowspan="1" colspan="1" aria-label="#"
                                        style="width: 23px;">#
                                    </th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="交易状态"
                                        style="width: 145px;">交易状态
                                    </th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="系统交易号"
                                        style="width: 176px;">系统交易号
                                    </th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="商户交易号"
                                        style="width: 176px;">商户交易号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="order-sort" rowspan="1" colspan="1"
                                        aria-label="金额: activate to sort column ascending" style="width: 117px;"
                                        @click="changeSort('amount')">金额
                                    </th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="支付方式"
                                        style="width: 188px;">支付方式
                                    </th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="手续费"
                                        style="width: 119px;">手续费
                                    </th>
                                    <th class="date sorting" tabindex="0" aria-controls="order-sort" rowspan="1"
                                        colspan="1"
                                        aria-label="申请时间: activate to sort column ascending" style="width: 170px;"
                                        @click="changeSort('created_at')">申请时间
                                    </th>
                                    <th class="control sorting_disabled" rowspan="1" colspan="1" aria-label="操作"
                                        style="width: 80px;">操作
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr role="row" class="odd" v-for="(data, index) in datas" :key="index">
                                    <td class="sorting_1">{{ startIndex + index }}</td>
                                    <td>{{ data.pay_summary }}</td>
                                    <td>{{ data.trade_seq }}</td>
                                    <td>{{ data.trade_service_id }}</td>
                                    <td class="text-right">{{ data.amount | numFormat('0.00') }}</td>
                                    <td>{{ options.paymentType[data.payment_type] }}</td>
                                    <td class="text-right">{{ data.fee | numFormat('0.00') }}</td>
                                    <td>{{ data.created_at }}</td>
                                    <td class="control">
                                        <a @click="showInfo(data.id)">
                                            <i class="livicon" data-name="info" data-size="18" data-c="#428BCA"
                                               data-hc="#428BCA" data-loop="true" data-toggle="modal"
                                               data-target="#order-info" id="livicon-29"
                                               style="width: 18px; height: 18px;">
                                                <svg height="18" version="1.1" width="18"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                     style="overflow: hidden; position: relative; left: -0.75px;"
                                                     id="canvas-for-livicon-29">
                                                    <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created
                                                        with
                                                        Raphaël 2.1.2
                                                    </desc>
                                                    <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>
                                                    <path fill="#428bca" stroke="none"
                                                          d="M16,3C8.82,3,3,8.82,3,16S8.82,29,16,29C23.179000000000002,29,29,23.18,29,16S23.179,3,16,3ZM15.899,7.7C17.06,7.7,18,8.639,18,9.8C18,10.958,17.06,11.9,15.899000000000001,11.9S13.799000000000001,10.959,13.799000000000001,9.8C13.8,8.639,14.739,7.7,15.899,7.7ZM18.698,24.5H16.198C15.198,24.5,14.198,23.5,14.198,22.5V15.7C14.198,15.2,12.598,14.7,12.598,14.2C12.598,13.799999999999999,13.198,13.5,13.697000000000001,13.5H16.198C17.198,13.5,18.198,14.2,18.198,15.2V22.5C18.198,23,19.8,23.4,19.8,23.9C19.8,24.301,19.2,24.5,18.698,24.5Z"
                                                          stroke-width="0" transform="matrix(0.5625,0,0,0.5625,0,0)"
                                                          style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                                </svg>
                                            </i>
                                        </a>
                                        <a @click="showEdit(data.id)">
                                            <i class="livicon" data-name="edit" data-size="18" data-c="#f56954"
                                               data-hc="#f56954" data-loop="true" data-toggle="modal"
                                               data-target="#order-edit" id="livicon-30"
                                               style="width: 18px; height: 18px;">
                                                <svg height="18" version="1.1" width="18"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                     style="overflow: hidden; position: relative; left: -0.25px;"
                                                     id="canvas-for-livicon-30">
                                                    <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created
                                                        with
                                                        Raphaël 2.1.2
                                                    </desc>
                                                    <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>
                                                    <path fill="#f56954" stroke="none"
                                                          d="M24,20V24H8V8H20L24,4H7C5.343,4,4,5.343,4,7V25C4,26.656,5.343,28,7,28H25C26.656,28,28,26.656,28,25V16L24,20Z"
                                                          stroke-width="0" transform="matrix(0.5625,0,0,0.5625,0,0)"
                                                          style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                                    <path fill="#f56954" stroke="none"
                                                          d="M27.105,5.369L29.651,7.914999999999999C30.114,8.380999999999998,30.118,9.143999999999998,29.651,9.610999999999999L27.671,11.591L23.429,7.347999999999999L25.409,5.3679999999999986C25.877,4.9,26.637,4.9,27.105,5.369ZM12.817,20.788C12.817,20.788,12.817,17.959,15.646,15.131L22.722,8.055L26.964000000000002,12.298L19.888,19.373C17.060000000000002,22.201,14.232000000000003,22.202,14.232000000000003,22.202S12.524000000000003,23.322000000000003,12.111000000000002,22.908C11.668,22.468,12.817,20.788,12.817,20.788ZM17.202,18.1L23.57,11.733L22.72,10.884L16.351999999999997,17.252000000000002L17.202,18.1Z"
                                                          transform="matrix(0.5625,0,0,0.5625,0,0)" stroke-width="0"
                                                          style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                                </svg>
                                            </i></a>
                                    </td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right" rowspan="1">小计</td>
                                    <td rowspan="1" colspan="1"></td>
                                    <td class="text-right" rowspan="1" colspan="1">
                                        {{
                                        _.sumBy(datas, x => + x.amount) | numFormat('0.00')
                                        }}
                                    </td>
                                    <td rowspan="1" colspan="1"></td>
                                    <td class="text-right" rowspan="1" colspan="1">
                                        {{
                                        _.sumBy(datas, x => + x.fee) | numFormat('0.00')
                                        }}
                                    </td>
                                    <td rowspan="1" colspan="1"></td>
                                    <td rowspan="1" colspan="1"></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5"></div>
                        <div class="col-sm-7"></div>
                    </div>
                </div>
            </div>
            <!-- end of table-scrollable -->
            <paginate :lastPage="lastPage" :page="paginate.page" @pageChange="pageChange"/>
        </template>
    </div>
</template>

<script>
    import ReportMixins from 'mixins/report'

    export default {
        mixins: [ReportMixins],
        data: () => ({
            options: {
                payState: {
                    0: '申請成功',
                    1: '交易中',
                    2: '交易成功,未回調',
                    3: '交易結束',
                    4: '交易失敗'
                },
                paymentType: {
                    0: '支付方式',
                    6: 'QQ扫码',
                    9: '银联扫码',
                    20: '支付宝扫码',
                    21: '支付宝WAP'
                }
            },
            sort: {
                column: 'created_at',
                direction: 'desc'
            },
            pay_state: '',
            payment_type: 0,
            searchData: {
                keyword: ''
            },
            amount: 0,
            fee: 0
        }),
        methods: {
            async fetch() {
                var $companySelector = document.querySelector('#company_selection')
                let myCompany = $companySelector ? $companySelector.value : company
                var res = await this.post('/admin/data', {
                    start: this.startTime.startOf('day').format('YYYY-MM-DD HH:mm:ss'),
                    end: this.endTime.endOf('day').format('YYYY-MM-DD HH:mm:ss'),
                    // at laravel view logQuery
                    company: myCompany,
                    pay_state: this.pay_state,
                    payment_type: this.payment_type,
                    sort: this.sort.column,
                    direction: this.sort.direction
                })
                if (res.ok) {
                    this.datas = res.body.data
                    this.amount = res.body.amount
                    this.fee = res.body.fee
                    this.paginate.total = res.body.total
                }
            },
            showInfo(id) {
                this.modalProccess($('#show_Info'), '/admin/logQuery/showInfo/' + id)
            },
            showEdit(id) {
                this.modalProccess($('#stateEditModal'), '/admin/logQuery/showState/' + id)
            },
            async modalProccess($modal, url) {
                $modal.modal('show')
                $modal.find('.modal-content').html('')
                var res = await this.$http.get(url)
                $modal.find('.modal-content').html(res.body)
            },
            changeSort(column) {
                if (this.sort.column != column) {
                    this.sort.column = column
                    this.sort.direction = 'desc'
                } else {
                    this.sort.direction = this.sort.direction == 'desc' ? 'asc' : 'desc'
                }
                this.fetch()
            },
            search() {
                this.pageChange(1)
            },
            pageChange(page) {
                this.paginate.page = page
                this.fetch()
            }
        },
        mounted() {
            this.$root.$on('reload', this.fetch)
        },
        destroyed() {
            this.$root.$off('reload')
        }
    }
</script>
