<template>
    <div ref="modal" class="modal fade info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">商户资料</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">商戶名稱</label>
                            <div class="col-sm-9 p-t-7">
                                {{ data.company_name }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label text-break-all">company_service_id</label>
                            <div class="col-sm-9 p-t-7">
                                {{ data.company_service_id }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">sceret_key</label>
                            <div class="col-sm-9 p-t-7">
                                {{ data.sceret_key }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">状态</label>
                            <div class="col-sm-9 p-t-7">
                                <i class="mdi mdi-check-circle-outline text-green text-lg"
                                   v-if="data.status == 'on'"></i>
                                <i class="mdi mdi-close-circle-outline text-red text-lg"
                                   v-else></i>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">下发申请</label>
                            <div class="col-sm-9 p-t-7">
                                <i class="mdi mdi-check-circle-outline text-green text-lg"
                                   v-if="data.apply_status == 'on'"></i>
                                <i class="mdi mdi-close-circle-outline text-red text-lg"
                                   v-else></i>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">联络电话</label>
                            <div class="col-sm-9 p-t-7">
                                {{ data.mobile }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">电子邮箱</label>
                            <div class="col-sm-9 p-t-7">
                                {{ data.email }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">QQ号</label>
                            <div class="col-sm-9 p-t-7">{{ data.QQ_id }}</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">取消</button> -->
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">确定
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</template>

<script>
    import DetailMixins from 'mixins/detail'

    export default {
        mixins: [DetailMixins],
        methods: {
            getDetail(id) {
                this.proccessAjax('info', {id}, this.onGetDetail)
            },
            onGetDetail(res) {
                this.data = res.data
            },
        },
        mounted() {
            this.$root.$on('companyManageInfo.show', id => {
                this.getDetail(id)
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('companyManageInfo.show')
        }
    }
</script>

