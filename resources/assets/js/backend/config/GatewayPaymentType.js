class GatewayPaymentType {
    static Hook = {
        // 海天支付(qrcode_url直接是圖片)
        '22': {
            component: 'HTian',
            title: '在线支付 - 海天支付 - 网上支付 安全快速！'
        },
        // 直接跳轉
        '23': {
            component: 'Redirect',
            title: '在线支付 - 海天支付 - 网上支付 安全快速！'
        },
        // 普通顯示
        '24': {
            component: 'NewBank',
            title: '在线支付 - 支付宝 - 网上支付 安全快速！'
        },
        // 直接跳轉
        '50': {
            component: 'Redirect',
            title: '在线支付 - 微信固码 - 网上支付 安全快速！'
        },
        // 直接跳轉
        '52': {
            component: 'Redirect',
            title: '在线支付 - 農信易掃 - 网上支付 安全快速！'
        },
        // 直接跳轉
        '53': {
            component: 'Redirect',
            title: '在线支付 - 農信易掃 - 网上支付 安全快速！'
        },
        // 直接跳轉
        '54': {
            component: 'Redirect',
            title: '在线支付 - 農信易掃 - 网上支付 安全快速！'
        },
        // 直接跳轉
        '55': {
            component: 'Redirect',
            title: '在线支付 - 蚕宝宝支付 - 网上支付 安全快速！'
        },
        // 支轉銀
        '201': {
            component: 'Alipay',
            title: '在线支付 - 支付宝 - 网上支付 安全快速！'
        },
        // 微信支付
        '203': {
            component: 'WeChatPay',
            title: '在线支付 - 微信支付 - 网上支付 安全快速！'
        },
        // 支付寶紅包
        '205': {
            component: 'AlipayRedEnvelope',
            title: '在线支付 - 支付宝 - 网上支付 安全快速！'
        },
        // 支付寶收款(固碼)
        '206': {
            component: 'NewBank',
            title: '在线支付 - 支付宝 - 网上支付 安全快速！'
        },
        // 微信收款(固碼)
        '207': {
            component: 'WeChatPay',
            title: '在线支付 - 微信支付 - 网上支付 安全快速！'
        },
        // 云闪付
        '208': {
            component: 'Unionpay',
            title: '在线支付 - 云闪付 - 网上支付 安全快速！'
        },
        // 支付寶轉支付寶
        '209': {
            component: 'AlipayForwardAlipay',
            title: '在线支付 - 支付宝 - 网上支付 安全快速！'
        },
        // 支轉銀(商戶)
        '210': {
            component: 'Alipay',
            title: '在线支付 - 支付宝 - 网上支付 安全快速！'
        },
        // 支付寶轉帳
        '211': {
            component: 'AlipayForwardAlipay',
            title: '在线支付 - 支付宝 - 网上支付 安全快速！'
        },
    }
}

export {GatewayPaymentType as default}
