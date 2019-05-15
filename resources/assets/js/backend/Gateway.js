var $gateway = document.querySelector('#gateway')

if ($gateway) {
    Vue.config.ignoredElements = ['t']
    new Vue({
        el: '#gateway',
        api: 'gateway',
        components: {
            /** 行動支付轉銀行卡 */
            StartupSelect: () => import('./pages/Gateway/Select'),
            StartupToBankCard: () => import('./pages/Gateway/Select/ToBankCard'),
            /** 行動掃碼 */
            Relay: () => import('./pages/Gateway/Relay'),
        }
    })
}
