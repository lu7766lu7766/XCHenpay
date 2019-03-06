<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    信息管理
                </div>
                <div class="card-body">
                    <div class="search-box">
                        <div class="search-select">
                            <select class="form-control" v-model="searchData.category_id">
                                <option value="">类别</option>
                                <option v-for="category in options.category" :key="category.id"
                                        :value="category.id">
                                    {{ config.MessageCategorySummary[category.code] }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <button type="button" class="btn btn-search" @click="search">搜寻</button>
                        </div>
                    </div>
                    <!-- search-box end -->
                    <div class="row view-box">
                        <div class="col-sm-6 view-btn">
                            <button class="btn btn-add btn-full" @click="$root.$emit('messageManageCreate.show')">发送
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
                                <th class="width-tag">类别</th>
                                <th>信息</th>
                                <th class="width-date">发送时间</th>
                                <th class="width-control">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(data, index) in datas" :key="index">
                                <td>{{ startIndex + index }}</td>
                                <td>
                                    <span class="badge badge-pill" :class="{
                                        'badge-danger': data.category.code == config.MessageCategory.SYSTEM,
                                        'badge-success': data.category.code == config.MessageCategory.FILL_ORDER,
                                        'badge-info': data.category.code == config.MessageCategory.TRANSACTION,
                                    }">{{ config.MessageCategorySummary[data.category.code] }}</span>
                                </td>
                                <td class="text-left">{{ data.subject }}</td>
                                <td>{{ data.created_at }}</td>
                                <td class="width-control">
                                    <a @click="$root.$emit('messageManageInfo.show', data)">
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
    import MessageCategory from 'config/MessageCategory'

    export default {
        components: {
            Info: require('./modal/Info'),
            Create: require('./modal/Create')
        },
        api: "messageManage",
        mixins: [ListMixins],
        data: () => ({
            options: {
                roles: [],
                category: []
            },
            searchData: {
                category_id: ''
            },
            config: {
                MessageCategory,
                MessageCategorySummary: MessageCategory.summaryMap(),
                RolesSummary: Roles.summaryMap()
            }
        }),
        methods: {
            dataInit() {
                this.proccessAjax('dataInit', {}, res => {
                    this.options.roles = res[0].data
                    this.options.category = res[1].data
                })
            },
            onGetTotal(res) {
                this.paginate.total = res.data
            },
            onGetList(res) {
                this.datas = res.data
            },
            confirmDelete(id) {
                swal(this.getDeleteConfig('删除', '你确定要删除吗？')).then(() => {
                    this.doDelete(id)
                }).catch(err => {
                })
            },
            doDelete(id) {
                this.proccessAjax('delete', {id}, this.deleteSuccess)
            }
        },
        mounted() {
            this.dataInit()
            this.search()
        }
    }
</script>
