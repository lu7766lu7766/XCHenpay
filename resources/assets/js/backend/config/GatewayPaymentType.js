class GatewayPaymentType {
    static Hook = {
        '203': {
            component: 'WeChatPay',
            title: '在线支付 - 微信支付 - 网上支付 安全快速！'
        },
        '205': {
            component: 'AlipayRedEnvelope',
            title: '在线支付 - 支付宝 - 网上支付 安全快速！'
        },
        '24': {
            component: 'NewBank',
            title: '在线支付 - 支付宝 - 网上支付 安全快速！'
        }
    }
}

export {GatewayPaymentType as default}
