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
                            <button class="btn btn-add btn-full" @click="showCreate">新增</button>
                        </div>
                        <per-page-selector v-model="paginate.perpage"/>
                    </div>
                    <!-- view-box end -->
                    <div class="table-responsive">
                        <table class="table table-hover text-center table-bordered table-box table-sort">
                            <thead>
                            <tr>
                                <th class="width-40">#</th>
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
                                <td>{{ data.name }}</td>
                                <td>{{ data.account }}</td>
                                <td>{{ data.bank_name }}</td>
                                <td>{{ data.bank_branch }}</td>
                                <td>{{ data.created_at }}</td>
                                <td class="width-control">
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
        <create/>
    </div>
</template>

<script>
    import ListMixins from "mixins/list"

    export default {
        components: {
            Create: require('./modal/Create')
        },
        api: "bankAccountBind",
        mixins: [ListMixins],
        data: () => ({
            searchData: {
                search: ''
            },
            sort: {
                column: 'created_at'
            }
        }),
        methods: {
            onGetTotal(res) {
                this.paginate.total = res.data
            },
            onGetList(res) {
                this.datas = res.data
            },
            confirmDelete(id) {
                swal({
                    title: '删除用户',
                    text: "你确定要删除这个用户吗？ 这个操作是不可逆转的。",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'm-l-10',
                    confirmButtonColor: '#3eb7ba',
                    cancelButtonColor: '#6c757d',
                    cancelButtonText: '取消',
                    confirmButtonText: '删除'
                }).then(() => {
                    this.doDelete(id)
                }).catch(err => {
                })
            },
            doDelete(id) {
                this.proccessAjax('delete', {
                    bank_account_id: id
                }, this.refresh)
            },
            showCreate() {
                this.$root.$emit('bankAccountBindCreate.show')
            }
        },
        computed: {
            customGetReqBody() {
                return {
                    sort: this.sort.direction.toUpperCase()
                }
            }
        },
    }
</script>
