<template>
    <div class="card m-b-30" v-if="options.length">
        <div class="card-header">
            商户筛选
        </div>
        <div class="card-body">
            <select class="form-control" v-model="company_id">
                <option :value="-1">請選擇商戶</option>
                <option v-for="company in options" :value="company.id">{{ company.company_name }}</option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            value: {
                type: String | Number,
                require: true
            },
            options: {
                type: Array,
                require: true
            }
        },
        data: () => ({
            company_id: ''
        }),
        watch:
            {
                company_id() {
                    this.$emit('input', this.company_id)
                }
            }
        ,
        mounted() {
            this.company_id = this.value
        }
    }
</script>

