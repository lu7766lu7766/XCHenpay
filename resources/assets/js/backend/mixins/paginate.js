import Paginate from '../components/Paginate.vue';

export default {
    components: {
        Paginate
    },
    data: () => ({
        paginate: {
            total: 0,
            page: 1,
            perpage: 25
        }
    }),
    computed: {
        lastPage() {
            return Math.ceil(this.total / this.perpage)
        }
    }
}
