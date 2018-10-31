export default {
    components: {
        Paginate: require('@/shared/Paginate.vue')
    },
    data: () => ({
        serchData: {},
        datas: [],
        paginate: {
            total: 0,
            page: 1,
            perpage: 10
        }
    }),
    methods: {
        async post(url, data) {
            let loader = this.$loading.show({
                container: this.$el,
            });
            var res = await this.$http.post(url, this.filterData(
                _.assign({}, data, this.searchData, this.paginate))
            ).catch(e => {
                this.isLoading = false
                alert("与服务器沟通错误")
                return false;
            })
            loader.hide()
            return res
        },
        // async get(url, params) {
        //     this.isLoading = true
        //     var res = await this.$http.get(url, {
        //         params: this.filterData(
        //             _.assign({}, params, this.searchData, this.paginate))
        //     }).catch(e => {
        //         this.isLoading = false
        //         alert("与服务器沟通错误")
        //         return false;
        //     })
        //     this.isLoading = false
        //     return res
        // },
        filterData(data) {
            return _.pickBy(data, x => x !== '' && !_.isNull(x) && !_.isUndefined(x))
        }
    },
    computed: {
        startIndex() {
            return (this.paginate.page - 1) * this.paginate.perpage + 1
        },
        lastPage() {
            return Math.ceil(this.paginate.total / this.paginate.perpage)
        }
    }
}
