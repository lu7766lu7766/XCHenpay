export default {
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
        },
        reqDateFormat: 'YYYY-MM-DD HH:mm:ss'
    }),
    methods: {
        onGetList() {
        },
        onGetTotal() {
        },
        async getList() {
            let loader = this.$loading.show();
            var res = await this.$callApi(`${this.apiKey}:list`, this.reqBody)
            this.onGetList(res)
            loader.hide()
        },
        async getTotal() {
            var res = await this.$callApi(`${this.apiKey}:total`, this.reqBody)
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
        reqBody() {
            var res = _.pickBy(_.assign({}, this.paginate, this.searchData))
            _.forEach(res, (val, key) => {
                if (moment.isMoment(val)) {
                    res[key] = val.format(this.reqDateFormat)
                }
            })
            return res
        },
        apiKey() {
            return this.$options.api
        },
        startIndex() {
            return (this.paginate.page - 1) * this.paginate.perpage + 1
        },
        lastPage() {
            return Math.ceil(this.paginate.total / this.paginate.perpage)
        }
    }
}
