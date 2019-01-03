import ReqMixins from 'mixins/request'
import PermissionMixins from 'mixins/permission'

export default {
    mixins: [ReqMixins, PermissionMixins],
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
