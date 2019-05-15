import ReqMixins from 'mixins/request'
import GatewayPaymentType from 'config/GatewayPaymentType'
import {getUrlParameter} from 'lib/myLib'

export default {
    mixins: [ReqMixins],
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
        },
        'isNone'(val) {
            document.getElementsByClassName('alipay-logo')[0].style.display = !val ? 'block' : 'none'
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
        },
        waitPageReady() {
            setTimeout(() => {
                if (document.getElementById('page')) {
                    this.showView()
                } else {
                    this.waitPageReady()
                }
            }, 200)
        }
    },
    computed: {
        paymentHook() {
            return _(GatewayPaymentType.Hook).getVal(this.data.payment_type, {
                component: 'None',
                title: ''
            })
        },
        isNone() {
            return this.paymentHook.component === 'None'
        },
        trade_seq() {
            return getUrlParameter('trade_seq')
        }
    },
    async mounted() {
        document.getElementsByClassName('alipay-logo')[0].style.display = 'none'
        try {
            var res = await this.$callApi(this.apiKey + ':data', {
                trade_seq: this.trade_seq
            }, null, {isShowAlert: false, throwRes: true})
            this.data = res.data
            this.isExpire = moment.duration(moment(this.data.expired_time).diff(moment())).asSeconds() <= 0
            if (!this.isExpire) {
                this.counter()
                this.timer = setInterval(this.counter, 1000)
            }
        } catch (e) {
            console.log(e)
            this.data = e.data
        }
        this.waitPageReady()
        document.title = this.paymentHook.title
    },
    destroyed() {
        clearInterval(this.timer)
    }
}
