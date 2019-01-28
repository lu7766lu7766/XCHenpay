<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="search-box">
                        <div class="search-select">
                            <select class="form-control" v-model="searchData.status">
                                <option value="">状态</option>
                                <option v-for="(name, val) in options.status" :key="val" :value="val">{{ name }}</option>
                            </select>
                        </div>
                        <div class="search-input">
                            <input type="text"  class="form-control" placeholder="关键字" v-model="searchData.keyword">
                        </div>
                        <div>
                            <button type="button" class="btn btn-search" data-toggle="button" @click="search">搜寻</button>
                        </div>
                    </div>
                    <!-- search-box end -->
                    <div class="row view-btn-box">
                        <div class="col-sm-6 view-btn">
                            <button class="btn btn-add btn-half" @click="showDetail()">新增</button>
                        </div>
                        <per-page-selector v-model="paginate.perpage"/>
                    </div>
                    <!-- view-box end -->
                    <div class="table-responsive m-t-15">
                        <table class="table table-hover text-center table-bordered table-box">
                            <thead>
                            <tr>
                                <th class="width-40">#</th>
                                <th>名称</th>
                                <th>邮件</th>
                                <th>权限</th>
                                <th class="width-status">状态</th>
                                <th class="width-control-lg">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(data, index) in datas" :key="index">
                                <td>{{ startIndex + index }}</td>
                                <td>{{ data.company_name }}</td>
                                <td>{{ data.email }}</td>
                                <td>{{ data.roles[0].name }}</td>
                                <td>
                                    <i class="mdi mdi-check-circle-outline text-green" v-if="data.status == 'on'"></i>
                                    <i class="mdi mdi-close-circle-outline text-red" v-else></i>
                                </td>
                                <td>
                                    <a @click="showInfo(data)">
                                        <i class="mdi mdi-information-outline text-blue"></i></a>
                                    <a @click="showDetail(data)">
                                        <i class="mdi mdi-pencil-box-outline"></i></a>
                                    <a class="delete"
                                       v-if="canDelete(data.email)"
                                       @click="confirmDelete(data.id)">
                                        <i class="mdi mdi-delete-variant text-red"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- table-responsive end -->
                    <paginate :page="paginate.page" :last-page="lastPage" @pageChange="pageChange"/>
                    <!-- <nav aria-label="Page navigation" class="page-bar"> end -->
                </div>
            </div>
        </div>
        <info/>
        <detail/>
    </div>
</template>

<script>
    import ListMixins from 'mixins/list'

    export default {
        api: "accountManage",
        mixins: [ListMixins],
        components: {
            Info: require('./modal/Info'),
            Detail: require('./modal/Detail')
        },
        data: () => ({
            options: {
                roles: [],
                status: {
                    'on': '开启',
                    'off': '关闭'
                }
            },
            searchData: {
                keyword: '',
                status: ''
            }
        }),
        methods: {
            dataInit() {
                this.proccessAjax('dataInit', {}, res => {
                    this.options.roles = res.data
                }, false)
            },
            onGetTotal(res) {
                this.paginate.total = res.data.total
            },
            onGetList(res) {
                this.datas = res.data
            },
            showInfo(data) {
                this.$root.$emit('accountManageInfo.show', data)
            },
            showDetail(data) {
                this.$root.$emit('accountManageDetail.show', data)
            },
            confirmDelete(id) {
                swal(this.config.delete).then(() => {
                    this.doDelete(id)
                }).catch(err => {
                })
            },
            doDelete(id) {
                this.proccessAjax('delete', {id}, this.deleteSuccess)
            },
            canDelete(email) {
                return email !== 'admin@admin.com'
            }
        },
        mounted() {
            this.dataInit()
            this.search()
        }
    }
</script>
