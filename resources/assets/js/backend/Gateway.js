var $gateway = document.querySelector('#gateway')

if ($gateway) {
    Vue.config.ignoredElements = ['t']
    new Vue({
        el: '#gateway',
        api: 'gateway',
        components: {
            /** 行動支付轉銀行卡 */
            Alipay: () => import('./pages/Gateway/alipay'),
        }
    })
}
