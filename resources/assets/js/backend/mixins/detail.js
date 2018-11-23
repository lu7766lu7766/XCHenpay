import ReqMixins from 'mixins/request'

export default {
    mixins: [ReqMixins],
    data: () => ({
        data: {},
    }),
    methods: {
        async proccessAjax(target, data, cb) {
            let loader = this.$loading.show({
                container: this.$el,
            })
            this.data = {}
            var res = await this.$callApi(`${this.apiKey}:${target}`, this.createReqBody(data), loader)
            cb(res)
            loader.hide()
        },
        createReqBody(data) {
            return this.convertMoment2String(_.assign({}, data))
        }
    }
}
