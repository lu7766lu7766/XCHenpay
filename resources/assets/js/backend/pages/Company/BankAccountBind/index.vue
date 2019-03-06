<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    卡号列表
                    <span class="refresh" @click="refresh">
                        <i class="mdi mdi-refresh"></i>刷新
                    </span>
                </div>
                <div class="card-body">
                    <div class="search-box">
                        <div class="search-select">
                            <select class="form-control" v-model="searchData.status">
                                <option value="">核卡状态</option>
                                <option v-for="key in options.status" :key="key" :value="key">
                                    {{ config.BankCardStatusSummary[key] }}
                                </option>
                            </select>
                        </div>
                        <div class="search-input">
                            <input type="text" class="form-control" placeholder="关键字" v-model="searchData.search">
                        </div>

                        <div>
                            <button type="button" class="btn btn-search" @click="search">搜寻</button>
                        </div>
                    </div>
                    <!-- search-box end -->
                    <div class="row view-btn-box card-box">
                        <div class="col-sm-6 view-btn">
                            <button class="btn btn-add btn-full" @click="$root.$emit('bankAccountBindCreate.show')">新增
                            </button>
                        </div>
                        <per-page-selector v-model="paginate.perpage"/>
                    </div>
                    <!-- view-box end -->
                    <div class="table-responsive">
                        <table class="table table-hover text-center table-bordered table-box table-sort">
                            <thead>
                            <tr>
                                <th class="width-40">#</th>
                                <th>核卡状态</th>
                                <th>开户名</th>
                                <th>银行卡号</th>
                                <th>银行名</th>
                                <th>开户支行</th>
                                <th class="width-date sorting" @click="changeSort('created_at')" :class="{
                                    'sort-asc': this.sort.column == 'created_at' && this.sort.direction == 'asc',
                                    'sort-desc': this.sort.column == 'created_at' && this.sort.direction == 'desc'
                                }">綁定時間
                                </th>
                                <th class="width-control">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(data, index) in datas" :key="index">
                                <td>{{ startIndex + index }}</td>
                                <td>
                                    <span class="badge badge-pill"
                                          :class="{
                                            'badge-warning': data.status == config.BankCardStatus.PENDING,
                                            'badge-danger': data.status == config.BankCardStatus.REJECT,
                                            'badge-success': data.status == config.BankCardStatus.APPROVAL
                                          }">
                                        {{ config.BankCardStatusSummary[data.status] }}
                                    </span>
                                </td>
                                <td>{{ data.name }}</td>
                                <td>{{ data.account }}</td>
                                <td>{{ data.bank_name }}</td>
                                <td>{{ data.bank_branch }}</td>
                                <td>{{ data.created_at }}</td>
                                <td class="width-control">
                                    <a @click="$root.$emit('bankAccountBindInfo.show', data)">
                                        <i class="mdi mdi-information-outline text-blue"></i></a>
                                    <a class="delete" @click="confirmDelete(data.id)">
                                        <i class="mdi mdi-delete-variant text-red"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <paginate :page="paginate.page" :lastPage="lastPage" @pageChange="pageChange"/>
                </div>
            </div>
            <!-- card end -->
        </div>
        <info/>
        <create/>
    </div>
</template>

<script>
    import ListMixins from "mixins/list"
    import BankCardStatus from 'config/BankCardStatus'

    export default {
        components: {
            Info: require('./modal/Info'),
            Create: require('./modal/Create')
        },
        api: "bankAccountBind",
        mixins: [ListMixins],
        data: () => ({
            options: {
                status: []
            },
            searchData: {
                status: '',
                search: ''
            },
            sort: {
                column: 'created_at'
            },
            config: {
                BankCardStatus,
                BankCardStatusSummary: BankCardStatus.summaryMap()
            }
        }),
        methods: {
            dataInit() {
                this.proccessAjax('dataInit', {}, res => {
                    this.options.status = res.data
                })
            },
            onGetTotal(res) {
                this.paginate.total = res.data
            },
            onGetList(res) {
                this.datas = res.data
            },
            confirmDelete(id) {
                swal(this.getDeleteConfig('删除行卡', '你确定要删除这个行卡吗？ 这个操作是不可逆转的。')).then(() => {
                    this.doDelete(id)
                }).catch(err => {
                })
            },
            doDelete(id) {
                this.proccessAjax('delete', {id}, this.deleteSuccess)
            }
        },
        computed: {
            customGetReqBody() {
                return {
                    sort: this.sort.direction.toUpperCase()
                }
            }
        },
        mounted() {
            this.dataInit()
            this.search()
        }
    }
</script>
