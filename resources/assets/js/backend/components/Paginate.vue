<template>
    <nav aria-label="Page navigation" class="page-bar" v-if="lastPage > 1">
        <ul class="pagination">
            <li class="page-item" :class="{
                    disabled: page === 1
                }" @click="page === 1 ? '' : pageChange(1)">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>

            <li class="page-item" v-for="p in _.range(startPage, endPage+1)"
                :key="p"
                :class="{active : p === page}"
                @click="p === page ? '' : pageChange(p)">
                <a class="page-link" href="javascript:;">{{ p }}</a>
            </li>

            <li class="page-item" :class="{
                    disabled: page === lastPage
                }"
                @click="page === lastPage ? '' : pageChange(lastPage)">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
</template>
<script>
    export default {
        props: {
            page: {
                type: Number,
                required: true
            },
            lastPage: {
                type: Number,
                required: true
            }
        },
        computed: {
            startPage() {
                const start = this.page - 3
                return start > 1
                    ? start
                    : 1
            },
            endPage() {
                const end = this.page + 3
                return end < this.lastPage
                    ? end
                    : this.lastPage
            }
        },
        methods: {
            pageChange(targetPage) {
                this.$emit('pageChange', targetPage)
            }
        }
    }
</script>

<style scoped>

</style>
