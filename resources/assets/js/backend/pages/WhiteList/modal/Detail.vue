<template>
    <div ref="modal" class="modal fade modal-box" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">白名单修改</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">允许IP <b>*</b></label>
                            <div class="col-md-9">
                                <textarea class="form-control" rows="6" v-model="data.ips"></textarea>
                                <div class="tips">
                                    若无需限制，请留空;若要限制，请输入IP，多个IP请使用「,」分隔，如192.168.0.1,192.168.0.3依此类推
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" @click="update">确定</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</template>

<script>
    import DetailMixins from 'mixins/detail'

    export default {
        mixins: [DetailMixins],
        rules: {
            'data.ips': {
                ips: {
                    message: '请填入合法的ip格式'
                }
            },
        },
        methods: {
            update() {
                if (this.data.ips == '') {
                    this.proccessAjax('delete', {
                        user_id: this.data.id
                    }, this.onUpdate)
                } else {
                    try {
                        this.validate()
                    } catch (e) {
                        return alert(e)
                    }
                    this.proccessAjax('update', {
                        user_id: this.data.id,
                        ips: this.data.ips.split(',')
                    }, this.onUpdate)
                }
            },
            onUpdate() {
                this.$parent.refresh()
                $(this.$refs.modal).modal('hide')
            }
        },
        mounted() {
            this.$root.$on('whiteListDetail.show', data => {
                data = _.cloneDeep(data)
                data.ips = data.whitelist ? data.whitelist.ip.join(',') : ''
                this.data = data
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('whiteListDetail.show')
        }
    }
</script>
