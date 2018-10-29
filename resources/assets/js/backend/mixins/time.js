import PickerMixins from './picker'

export default {
    mixins: [PickerMixins],
    components: {
        DateTimePicker: require('../components/DateTimePicker')
    },
    data: () => ({
        startTime: '',
        endTime: ''
    }),
    computed: {
        timeContainer: {
            get() {
            },
            set(value) {
                this.startTime = value.start
                this.endTime = value.end
            }
        }
    },
}
