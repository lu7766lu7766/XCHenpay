<template>
    <div ref="modal" class="modal fade hand-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">通道资讯: {{ data.name }}</h5>
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
                            <div class="col-md-9 p-t-7">{{ data.fee }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">状态</label>
                            <div class="col-md-9 p-t-7">{{ data.status ? '开启' : '关闭' }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">描述</label>
                            <div class="col-md-9">{{ data.description }}</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">确定
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</template>

<script>
    import DetailMixins from 'mixins/detail'

    export default {
        mixins: [DetailMixins],
        methods: {
            onGetInfo(res) {
                this.data = res.payment
            },
            async getInfo(data) {
                this.proccessAjax('info', data, this.onGetInfo)
            }
        },
        mounted() {
            this.$root.$on('feeInfo.show', payment => {
                this.getInfo({
                    payment
                })
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('feeInfo.show')
        }
    }
</script>
