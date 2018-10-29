import PaginateMixins from './paginate'

export default {
    mixins: [PaginateMixins],
    data: () => ({
        isLoading: false,
        serchData: {}
    }),
    methods: {
        async post(url, data) {
            this.isLoading = true
            var res = await this.$http.post(url, this.filterData(
                _.assign({}, data, this.searchData, this.paginate))
            ).catch(e => {
                this.isLoading = false
                alert("与服务器沟通错误")
                return false;
            })
            this.isLoading = false
            return res
        },
        async get(url, params) {
            this.isLoading = true
            var res = await this.$http.get(url, {
                params: this.filterData(
                    _.assign({}, params, this.searchData, this.paginate))
            }).catch(e => {
                this.isLoading = false
                alert("与服务器沟通错误")
                return false;
            })
            this.isLoading = false
            return res
        },
        filterData(data) {
            return _.pickBy(data, x => x !== '' && !_.isNull(x) && !_.isUndefined(x))
        }
    }
}
