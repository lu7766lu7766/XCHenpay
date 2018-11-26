<template>
    <div class="col-sm-6 view-page">
        每页显示
        <select class="form-control" v-model="perpage">
            <option v-for="page in [10,25,50,100]" :value="page">{{ page }}</option>
        </select>
        笔资料
    </div>
</template>

<script>
    export default {
        props: ['value'],
        data: () => ({
            perpage: ''
        }),
        watch: {
            perpage(newValue) {
                this.$emit('input', newValue)
            }
        },
        created() {
            this.perpage = this.value
        }
    }
</script>

<style scoped>

</style>
