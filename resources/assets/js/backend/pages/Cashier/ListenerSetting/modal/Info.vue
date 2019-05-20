<template>
    <div ref="modal" id="info" class="modal fade info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">內容</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">银行名称</label>
                            <div class="col-md-9 p-t-7">
                                {{ _(data).getVal('bank.0.name') }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">简讯格式</label>
                            <div class="col-md-9 p-t-7">
                                {{ data.contents }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">状态</label>
                            <div class="col-md-9 p-t-7">
                                <i class="mdi mdi-check-circle-outline text-green text-lg"
                                   v-if="data.status == 'Y'"></i>
                                <i class="mdi mdi-close-circle-outline text-red text-lg" v-else></i>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
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
        mounted() {
            this.$root.$on('listenerSettingInfo.show', data => {
                this.data = data
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('listenerSettingInfo.show')
        }
    }
</script>

