<template>
    <div ref="modal" class="modal fade modal-box" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">內容</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group row">
                            <label class="col-md-3 control-label">API编号</label>
                            <div class="col-md-9 p-t-7">{{ data.i6pay_id }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">通道名称</label>
                            <div class="col-md-9 p-t-7">{{ data.name }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">手续费率</label>
                            <div class="col-md-9 p-t-7">
                                <span>{{ data.fee | numFormat('0,0.00') }}%</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">状态</label>
                            <div class="col-md-9 p-t-7">
                                <i class="mdi mdi-check-circle-outline text-green text-lg" v-if="data.status"></i>
                                <i class="mdi mdi-close-circle-outline text-red text-lg" v-else></i>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">描述</label>
                            <div class="col-md-9 p-t-7">{{ data.description }}</div>
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
    import FeeMixins from '../../FeeMixins'

    export default {
        mixins: [DetailMixins, FeeMixins],
        mounted() {
            this.$root.$on('feeListDetail.show', data => {
                this.data = this.initData(data)
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('feeListDetail.show')
        }
    }
</script>
