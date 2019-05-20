<template>
    <div ref="modal" class="modal info fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">修改</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">银行名称 <b>*</b></label>
                            <div class="col-md-9">
                                <select class="form-control"
                                        v-model="data.bank_id">
                                    <option v-for="(bank, index) in $parent.options.banks"
                                            :key="index"
                                            :value="bank.id">{{ bank.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">监听格式 <b>*</b></label>
                            <div class="col-md-9">
                                <textarea cols="30" rows="5" class="form-control"
                                          v-model="data.contents"></textarea>
                                <div class="tips text-danger">
                                    <a style="cursor: pointer;" class="text-blue"
                                       @click="openTemplate()">监听格式填写说明，点击查看</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label required">状态 <b>*</b></label>
                            <div class="col-md-9 p-t-7">
                                <label class="radio-inline"
                                       v-for="(name, val) in $parent.options.status"
                                       :key="val">
                                    <input type="radio" v-model="data.status" :value="val">{{ name }}
                                </label>
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
    import ThisMixins from './mixins'

    export default {
        mixins: [DetailMixins, ThisMixins],
        rules: {
            "data.bank_id": {
                require: {
                    message: '银行 不得为空白'
                }
            },
            'data.contents': {
                require: {
                    message: '监听格式 不得为空白'
                }
            },
            'data.status': {
                require: {
                    message: '状态 不得为空白'
                }
            }
        },
        methods: {
            update() {
                try {
                    this.validate()
                } catch (e) {
                    return alert(e)
                }
                this.callApi(async () => {
                    await this.$api.listenerSetting.create(_.pick(this.data, [
                        'id',
                        'bank_id',
                        'contents',
                        'status'
                    ]), {
                        s: this.onUpdate
                    })
                })
            },
            onUpdate() {
                this.updateSuccess()
                $(this.$refs.modal).modal('hide')
            }
        },
        mounted() {
            this.$root.$on('listenerSettingEdit.show', data => {
                const tmpData = _.cloneDeep(data)
                tmpData.bank_id = _(tmpData).getVal('bank.0.id', 1)
                this.data = tmpData
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('listenerSettingEdit.show')
        }
    }
</script>

