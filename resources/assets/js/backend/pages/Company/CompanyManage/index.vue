<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="search-box">
                        <div class="search-select">
                            <select class="form-control" v-model="searchData.status">
                                <option value="">状态</option>
                                <option v-for="(name, val) in options.status" :key="val" :value="val">{{ name }}
                                </option>
                            </select>
                        </div>
                        <div class="search-select">
                            <select class="form-control" v-model="searchData.apply_status">
                                <option value="">下发申请</option>
                                <option v-for="(name, val) in options.applyStatus" :key="val" :value="val">{{ name }}
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
                    <div class="row view-btn-box">
                        <div class="col-sm-6 view-btn">
                            <button class="btn btn-add btn-half" v-if="isAdmin" @click="showAdd">新增</button>
                            <button class="btn btn-replay btn-half" v-if="isAdmin" @click="showRestore">回复
                            </button>
                        </div>
                        <per-page-selector v-model="paginate.perpage"/>
                    </div>
                    <!-- view-box end -->
                    <div class="table-responsive m-t-15">
                        <table class="table table-hover text-center table-bordered table-box">
                            <thead>
                            <tr>
                                <th class="width-40">#</th>
                                <th>商户名称</th>
                                <th>邮件</th>
                                <th>QQ号</th>
                                <th class="width-status">状态</th>
                                <th class="width-status">下发申请</th>
                                <th class="width-control-lg">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(data, index) in datas" :key="index">
                                <td>{{ startIndex + index }}</td>
                                <td>{{ data.company_name }}</td>
                                <td>{{ data.email }}</td>
                                <td>{{ data.QQ_id }}</td>
                                <td>
                                    <i class="mdi mdi-check-circle-outline text-green"
                                       v-if="data.status == 'on'"></i>
                                    <i class="mdi mdi-close-circle-outline text-red" v-else></i>
                                </td>
                                <td>
                                    <i class="mdi mdi-check-circle-outline text-green"
                                       v-if="data.apply_status == 'on'"></i>
                                    <i class="mdi mdi-close-circle-outline text-red" v-else></i>
                                </td>
                                <td>
                                    <a v-if="isAdmin" @click="showInfo(data.id)">
                                        <i class="mdi mdi-information-outline text-blue"></i></a>
                                    <a v-if="isAdmin" @click="showEdit(data.id)">
                                        <i class="mdi mdi-pencil-box-outline"></i></a>
                                    <a v-if="isAdmin" class="delete" @click="confirmDelete(data.id)">
                                        <i class="mdi mdi-delete-variant text-red"></i></a>
                                    <a v-if="isAdmin || isFinancial" @click="showApplyEdit(data)">
                                        <i class="mdi mdi-database text-orange"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- table-responsive end -->
                    <paginate :page="paginate.page" :lastPage="lastPage" @pageChange="pageChange"/>
                    <!-- <nav aria-label="Page navigation" class="page-bar"> end -->
                </div>
            </div>
        </div>
        <company-manage-info/>
        <company-manage-add/>
        <company-manage-edit/>
        <company-manage-restore/>
        <company-manage-apply-edit/>
    </div>
</template>

<script>
    import ListMixins from 'mixins/list'
    import Roles from 'config/roles'

    export default {
        api: "companyManage",
        mixins: [ListMixins],
        components: {
            CompanyManageInfo: require('./modal/Info'),
            CompanyManageAdd: require('./modal/Add'),
            CompanyManageEdit: require('./modal/Edit'),
            CompanyManageRestore: require('./modal/Restore'),
            CompanyManageApplyEdit: require('./modal/ApplyEdit'),
        },
        data: () => ({
            options: {
                status: {
                    'on': '开启',
                    'off': '关闭'
                },
                applyStatus: {
                    'on': '开启',
                    'off': '关闭'
                }
            },
            searchData: {
                status: '',
                apply_status: '',
                keyword: ''
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
                swal(this.getDeleteConfig()).then(() => {
                    this.doDelete(id)
                }).catch(err => {
                })
            },
            doDelete(id) {
                this.proccessAjax('delete', {id}, this.deleteSuccess)
            },
            showAdd() {
                this.$root.$emit('companyManageAdd.show')
            },
            showRestore() {
                this.$root.$emit('companyManageRestore.show')
            },
            showInfo(id) {
                this.$root.$emit('companyManageInfo.show', id)
            },
            showEdit(data) {
                this.$root.$emit('companyManageEdit.show', data)
            },
            showApplyEdit(data) {
                this.$root.$emit('companyManageApplyEdit.show', data)
            }
        },
        computed: {
            isAdmin() {
                return this.$parent.userInfo.roles && this.$parent.userInfo.roles[0].slug === Roles.ADMIN
            },
            isFinancial() {
                return this.$parent.userInfo.roles && this.$parent.userInfo.roles[0].slug === Roles.FINANCE
            }
        },
        mounted() {
            this.search()
        }
    }
</script>
