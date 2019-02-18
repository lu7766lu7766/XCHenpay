<template>
    <div ref="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">信息发送</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-sm-2 control-label required">标题 <b>*</b></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" v-model="data.subject">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label required">类别 <b>*</b></label>
                            <div class="col-sm-10">
                                <select class="form-control" v-model="data.category_id">

                                    <option value="">请选择</option>
                                    <option v-for="category in $parent.options.category" :key="category.id"
                                            :value="category.id">
                                        {{ $parent.config.MessageCategorySummary[category.code] }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label required">发送对象 <b>*</b></label>
                            <div class="col-sm-10 p-t-7">
                                <label class="check-inline" v-for="role in $parent.options.roles" :key="role">
                                    <input type="checkbox" v-model="data.role" :value="role">
                                    {{ $parent.config.RolesSummary[role] }}
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label required">內容 <b>*</b></label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="5" v-model="data.content"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" @click="create">发送</button>
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
            'data.subject': {
                require: {
                    message: '标题 不得为空白'
                }
            },
            'data.category_id': {
                require: {
                    message: '类别 不得为空白'
                }
            },
            'data.role': {
                require: {
                    message: '发送对象 不得为空白'
                },
                min: {
                    value: 1,
                    message: '发送对象 不得为空白'
                }
            },
            'data.content': {
                require: {
                    message: '內容 不得为空白'
                }
            }
        },
        methods: {
            dataInit() {
                this.data = {
                    subject: '',
                    category_id: '',
                    role: [],
                    content: ''
                }
            },
            create() {
                try {
                    this.validate()
                } catch (e) {
                    return alert(e)
                }
                this.proccessAjax('create', this.data, this.onCreate)
            },
            onCreate() {
                this.createSuccess()
                $(this.$refs.modal).modal('hide')
            },
        },
        mounted() {
            this.$root.$on('messageManageCreate.show', () => {
                this.dataInit()
                $(this.$refs.modal).modal('show')
            })
        },
        destroyed() {
            this.$root.$off('messageManageCreate.show')
        }
    }
</script>

