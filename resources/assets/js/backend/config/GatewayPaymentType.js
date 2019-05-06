class GatewayPaymentType {
    static Hook = {
        '22': {
            component: 'HTian',
            title: '在线支付 - 海天支付 - 网上支付 安全快速！'
        },
        '23': {
            component: 'Redirect',
            title: '在线支付 - 海天支付 - 网上支付 安全快速！'
        },
        '24': {
            component: 'NewBank',
            title: '在线支付 - 支付宝 - 网上支付 安全快速！'
        },
        '50': {
            component: 'Redirect',
            title: '在线支付 - 微信固码 - 网上支付 安全快速！'
        },
        '55': {
            component: 'Redirect',
            title: '在线支付 - 蚕宝宝支付 - 网上支付 安全快速！'
        },
        '201': {
            component: 'Alipay',
            title: '在线支付 - 支付宝 - 网上支付 安全快速！'
        },
        '203': {
            component: 'WeChatPay',
            title: '在线支付 - 微信支付 - 网上支付 安全快速！'
        },
        '205': {
            component: 'AlipayRedEnvelope',
            title: '在线支付 - 支付宝 - 网上支付 安全快速！'
        },
        '208': {
            component: 'Unionpay',
            title: '在线支付 - 云闪付 - 网上支付 安全快速！'
        }
    }
}

export {GatewayPaymentType as default}
