<template>
    <div class="date-select">
        <div class="input-group">
            <input type='text' class="form-control" ref="picker" :placeholder="placeholder"/>
            <div class="input-group-append">
                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'datetimepicker'
            },
            placeholder: {
                type: String,
                default: ''
            },
            value: {
                type: Object,
                required: true
            }
        },
        watch: {
            value(newValue) {
                $(this.$refs.picker).val(newValue.format('YYYY-MM-DD HH:mm:ss'))
            }
        },
        mounted() {
            $(this.$refs.picker).datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                date: this.value,
                locale: moment.locale('zh-cn')//'zh_CN'
            })
            $(this.$refs.picker).on("dp.change", e => {
                // console.log(e.date)
                this.$emit('input', e.date)
            })
        },
        destroyed() {
            $(this.$refs.picker).off("dp.change")
        }
    }
</script>

<style scoped>

</style>
