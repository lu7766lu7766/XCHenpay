<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    白名单设定
                </div>
                <div class="card-body">
                    <div class="row view-box">
                        <per-page-selector v-model="paginate.perpage"/>
                    </div>
                    <!-- view-box end -->
                    <div class="table-responsive m-t-15">
                        <table class="table table-hover text-center table-bordered table-box">
                            <thead><tr>
                                <th class="width-40">#</th>
                                <th>商户名称</th>
                                <th>邮件</th>
                                <th>状态</th>
                                <th class="width-ip">允许IP</th>
                                <th class="control">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(data, index) in datas" :key="index">
                                <td>{{ startIndex + index }}</td>
                                <td>{{ data.company_name }}</td>
                                <td>{{ data.email }}</td>
                                <td class="width-status">
                                    <i class="mdi mdi-check-circle-outline text-green" v-if="data.status == 'on'"></i>
                                    <i class="mdi mdi-close-circle-outline text-red" v-else></i>
                                </td>
                                <td class="text-left">
                                    <div class="ip-list" v-if="data.whitelist">
                                        <span class="badge badge-info badge-pill"
                                              v-for="(ip,i) in data.whitelist.ip" :key="i">
                                            {{ ip }}
                                        </span>
                                    </div>
                                </td>
                                <td class="width-control">
                                    <a @click="showDetail(data)">
                                        <i class="mdi mdi-pencil-box-outline"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <paginate :page="paginate.page" :last-page="lastPage" @pageChange="pageChange"/>
                </div>
            </div>
            <!-- card end -->
        </div>
        <detail/>
    </div>
</template>

<script>
    import ListMixins from 'mixins/list'

    export default {
        api: "whiteList",
        mixins: [ListMixins],
        components: {
            Detail: require('./modal/Detail')
        },
        methods: {
            onGetTotal(res) {
                this.paginate.total = res.data.count
            },
            onGetList(res) {
                this.datas = res.data
            },
            showDetail(data) {
                this.$root.$emit('whiteListDetail.show', data)
            }
        },
        mounted() {
            this.search()
        }
    }
</script>

<style>
    .badge.badge-info.badge-pill {
        margin-right: 3px;
    }
</style>
