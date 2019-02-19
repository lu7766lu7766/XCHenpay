export default {
    methods: {
        getPaymentName(payment) {
            return payment && payment[0] ?
                payment[0].name :
                ''
        },
        getCardID(payment) {
            return payment && payment[0] &&
            payment[0].payment_information &&
            payment[0].payment_information.payment_detail &&
            payment[0].payment_information.payment_detail.card_id ?
                payment[0].payment_information.payment_detail.card_id :
                ''
        }
    }
}
