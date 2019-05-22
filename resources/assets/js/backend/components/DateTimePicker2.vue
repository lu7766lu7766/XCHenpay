<template>
    <div class="input-group">
        <date-time-picker :type="type"
                          :placeholder="placeholder"
                          :value="value"
                          @input="newVal => $emit('input', newVal)"/>
        <div class="input-group-append">
            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
        </div>
    </div>
</template>
<script>
    export default {
        components: {
            DateTimePicker: require('@/DateTimePickerInput')
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
        }
    }
</script>
