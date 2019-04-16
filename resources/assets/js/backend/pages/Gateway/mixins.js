import ReqMixins from 'mixins/request'

export default {
    props: ['trade_seq'],
    mixins: [ReqMixins],
    components: {
        layout: require('./Layout')
    },
    data: () => ({
        data: {},
        timer: null,
        isExpire: false,
        expireTime: {
            hours: 0,
            minutes: 0,
            seconds: 0,
            totalSeconds: 0
        },
    }),
    watch: {
        'expireTime.totalSeconds'(sec) {
            if (sec <= 0) {
                location.reload()
            }
        }
    },
    methods: {
        show(id, value) {
            if (document.getElementById(id)) {
                document.getElementById(id).style.display = value ? 'block' : 'none'
            }
        },
        showView() {
            this.show('page', true)
            this.show('loading', false)
        },
        counter() {
            const diffMoment = moment(this.data.expired_time).diff(moment())
            const durationMoment = moment.duration(diffMoment)
            this.expireTime.hours = this.data.expired_time ? durationMoment.hours() : 0
            this.expireTime.minutes = this.data.expired_time ? durationMoment.minutes() : 0
            this.expireTime.seconds = this.data.expired_time ? durationMoment.seconds() : 0
            this.expireTime.totalSeconds = this.data.expired_time ? durationMoment.asSeconds() : 0
        }
    }
}
