<template>
    <div class="row">
        <div class="col-lg-12">
            <company-selector v-model="searchData.user_id" :options="options.companies"/>
            <!-- card end -->
            <div class="card m-b-30" v-if="searchData.user_id !== -1">
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
                    <div class="row view-box m-t-15">
                        <per-page-selector v-model="paginate.perpage"/>
                    </div>
                    <div class="table-responsive m-t-15">
                        <table class="table table-hover text-center table-bordered table-box table-sort">
                            <thead>
                            <tr>
                                <th class="width-40">#</th>
                                <th>核卡状态</th>
                                <th>商户名称</th>
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
                                <td>{{ data.user.company_name }}</td>
                                <td>{{ data.name }}</td>
                                <td>{{ data.account }}</td>
                                <td>{{ data.bank_name }}</td>
                                <td>{{ data.bank_branch }}</td>
                                <td>{{ data.created_at }}</td>
                                <td class="width-control">
                                    <a @click="$root.$emit('bankAccountListInfo.show', data)">
                                        <i class="mdi mdi-information-outline text-blue"></i>
                                    </a>
                                    <a @click="$root.$emit('bankAccountListUpdate.show', data)">
                                        <i class="mdi mdi-pencil-box-outline"></i>
                                    </a>
                                    <a class="delete" @click="confirmDelete(data.id)">
                                        <i class="mdi mdi-delete-variant text-red"></i>
                                    </a>
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
        <update/>
    </div>
</template>

<script>
    import ListMixins from 'mixins/list'
    import BankCardStatus from 'config/BankCardStatus'

    export default {
        api: 'bankAccountList',
        mixins: [ListMixins],
        components: {
            CompanySelector: require('@/CompanySelector'),
            Info: require('./modal/Info'),
            Update: require('./modal/Update')
        },
        data: () => ({
            options: {
                status: [],
                companies: []
            },
            searchData: {
                user_id: -1,
                search: '',
                status: ''
            },
            sort: {
                column: 'created_at'
            },
            config: {
                BankCardStatus: BankCardStatus,
                BankCardStatusSummary: BankCardStatus.summaryMap()
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
                this.proccessAjax('dataInit', {}, res => {
                    this.options.companies = _.concat({value: '', company_name: '全部'}, res[0].data)
                    this.options.status = res[1].data
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
        }
    }
</script>
