<template>
    <div ref="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">被删除的商户</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row view-box">
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
                                <th class="width-status">删除时间</th>
                                <th class="width-control">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(data, index) in datas" :key="index">
                                <td>{{ startIndex + index }}</td>
                                <td>{{ data.company_name }}</td>
                                <td>{{ data.email }}</td>
                                <td>{{ data.deleted_at }}</td>
                                <td>
                                    <a @click="restore(data.id)">
                                        <i class="mdi mdi-replay text-green"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- table-responsive end -->
                    <paginate :page="paginate.page" :lastPage="lastPage" @pageChange="pageChange"/>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</template>

<script>
    import ListMixins from 'mixins/list'
    import DetailMixins from 'mixins/detail'

    export default {
        api: 'restore',
        mixins: [ListMixins, DetailMixins],
        methods: {
            onGetList(res) {
                this.datas = res.data
            },
            onGetTotal(res) {
                this.paginate.total = res.data.total
            },
            restore(id) {
                this.proccessAjax('restore', {id}, () => {
                    this.updateSuccess()
                    $(this.$refs.modal).modal('hide')
                })
            }
        },
        mounted() {
            this.$root.$on('companyManageRestore.show', () => {
                this.datas = []
                this.search()
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('companyManageRestore.show')
        }
    }
</script>

