<template>
    <div aria-label="Page navigation" class="page-box" v-if="lastPage > 1">
        <ul class="pagination">
            <li :class="{
                    disabled: page === 1
                }"
                @click="page === 1 ? '' : pageChange(1)"
            >
                <a href="javascript:;" aria-label="Previous">
                    <span aria-hidden="true">«</span>
                </a>
            </li>
            <li v-for="p in _.range(startPage, endPage+1)"
                :key="p"
                :class="{active : p === page}"
                @click="p === page ? '' : pageChange(p)">
                <a href="javascript:;">{{ p }}</a>
            </li>
            <li :class="{
                    disabled: page === lastPage
                }"
                @click="page === lastPage ? '' : pageChange(lastPage)">
                <a href="javascript:;" aria-label="Next">
                    <span aria-hidden="true">»</span>
                </a>
            </li>
        </ul>
    </div>
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
