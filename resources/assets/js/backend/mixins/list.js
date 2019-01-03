import ReqMixins from 'mixins/request'
import PermissionMixins from 'mixins/permission'

export default {
    mixins: [ReqMixins, PermissionMixins],
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
        sort: {
            column: '',
            direction: 'desc'
        },
        config: {
            delete: {
                title: '删除用户',
                text: "你确定要删除这个用户吗？ 这个操作是不可逆转的。",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'm-l-10',
                confirmButtonColor: '#3eb7ba',
                cancelButtonColor: '#6c757d',
                cancelButtonText: '取消',
                confirmButtonText: '删除'
            }
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
        changeSort(column) {
            if (this.sort.column != column) {
                this.sort.column = column
                this.sort.direction = 'desc'
            } else {
                this.sort.direction = this.sort.direction == 'desc' ? 'asc' : 'desc'
            }
            this.getList()
        },
        refresh() {
            this.getTotal()
            this.getList()
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
            return this.convertMoment2String(_.assign({}, this.paginate, this.searchData, this.customGetReqBody))
        },
        startIndex() {
            return (this.paginate.page - 1) * this.paginate.perpage + 1
        },
        lastPage() {
            return Math.ceil(this.paginate.total / this.paginate.perpage)
        }
    }
}
