<template>
    <div ref="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                            <div class="col-md-9">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="请输入手续费率" v-model="data.fee">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">状态</label>
                            <div class="col-md-9 p-t-7">
                                <label class="radio-inline">
                                    <input type="radio" value="1" v-model="data.status"> 开启
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" value="0" v-model="data.status"> 取消
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">描述</label>
                            <div class="col-md-9 p-t-7">{{ data.description }}</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" @click="update">确定
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
            onGetState(res) {
                this.data = res.payment
            },
            onUpdate() {
                this.updateSuccess()
                alert('成功')
                $(this.$refs.modal).modal('hide')
            },
            async getState(data) {
                this.proccessAjax('state', data, this.onGetState)
            },
            async update() {
                this.proccessAjax('update', {
                    id: this.data.id,
                    fee: this.data.fee,
                    status: this.data.status
                }, this.onUpdate)
            }
        },
        mounted() {
            this.$root.$on('feeState.show', payment => {
                this.getState({
                    payment
                })
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('feeState.show')
        }
    }
</script>

<style scoped>

</style>
