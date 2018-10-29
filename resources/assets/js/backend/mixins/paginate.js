import Paginate from '../components/Paginate.vue';

export default {
    components: {
        Paginate
    },
    data: () => ({
        paginate: {
            total: 0,
            page: 1,
            perpage: 10
        }
    }),
    computed: {
        lastPage() {
            return Math.ceil(this.paginate.total / this.paginate.perpage)
        }
    }
}
