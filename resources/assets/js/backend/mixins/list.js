import ReqMixins from 'mixins/request'

export default {
    mixins: [ReqMixins],
    components: {
        DateTimePicker: require('@/DateTimePicker'),
        Paginate: require('@/Paginate.vue'),
        PickerButton: require('@/PickerButton'),
        PerPageSelector: require('@/PerPageSelector')
    },
    watch: {
        'paginate.perpage'() {
            this.search()
        }
    },
    data: () => ({
        searchData: {},
        datas: [],
        paginate: {
            total: 0,
            page: 1,
            perpage: 10
        }
    }),
    methods: {
        onGetList() {
        },
        onGetTotal() {
        },
        async getList() {
            let loader = this.$loading.show({
                container: this.$el,
            })
            var res = await this.$callApi(`${this.apiKey}:list`, this.getReqBody, loader)
            this.onGetList(res)
            loader.hide()
        },
        async getTotal() {
            var res = await this.$callApi(`${this.apiKey}:total`, this.getReqBody)
            this.onGetTotal(res)
        },
        search() {
            this.getTotal()
            this.pageChange(1)
        },
        pageChange(page) {
            this.paginate.page = page
            this.getList()
        }
    },
    computed: {
        customGetReqBody() {
            return {}
        },
        getReqBody() {
            return this.convertMoment2String(_.assign({}, this.customGetReqBody, this.paginate, this.searchData))
        },
        startIndex() {
            return (this.paginate.page - 1) * this.paginate.perpage + 1
        },
        lastPage() {
            return Math.ceil(this.paginate.total / this.paginate.perpage)
        }
    }
}
