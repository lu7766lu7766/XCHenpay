import ReqMixins from 'mixins/request'

export default {
    mixins: [ReqMixins],
    data: () => ({
        data: {}
    }),
    methods: {
        createSuccess() {
            this.reqSuccess('新增')
        },
        updateSuccess() {
            this.reqSuccess('更新')
        },
        reqSuccess(msg) {
            alert(`${msg}成功`)
            this.data = {}
            this.$parent.refresh()
        }
    }
}
