export default {
    methods: {
        yesterday() {
            return {
                start: moment().subtract(1, 'days'),
                end: moment().subtract(1, 'days').endOf('day')
            }
        },
        today() {
            return {
                start: moment().startOf('day'),
                end: moment().endOf('day')
            }
        },
        lastWeek() {
            return {
                start: moment().subtract(1, 'weeks').startOf('isoWeek'),
                end: moment().subtract(1, 'weeks').endOf('isoWeek')
            }
        },
        thisWeek() {
            return {
                start: moment().startOf('isoWeek'),
                end: moment().endOf('isoWeek')
            }
        },
        lastMonth() {
            return {
                start: moment().subtract(1, 'months').startOf('month'),
                end: moment().subtract(1, 'months').endOf('month')
            }
        },
        thisMonth() {
            return {
                start: moment().startOf('month'),
                end: moment().endOf('month')
            }
        }
    }
}
