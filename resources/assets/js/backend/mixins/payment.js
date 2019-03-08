export default {
    methods: {
        getPaymentName(payment) {
            return _.has(payment, '0.name')
                ? payment[0].name
                : ''
        },
        getCardID(payment) {
            return _.has(payment, '0.payment_information.payment_detail.card_id')
                ? payment[0].payment_information.payment_detail.card_id
                : ''
        }
    }
}
