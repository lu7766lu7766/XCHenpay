<template>
    <div class="date-select">
        <date-time-picker :type="type" :placeholder="placeholder" v-model="value"/>
    </div>
</template>
<script>
    export default {
        components: {
            DateTimePicker: require('@/DateTimePicker2')
        },
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
                requered: true
            }
        },
        watch: {
            value(newValue) {
                this.$emit('input', newValue)
            }
        }
    }
</script>
