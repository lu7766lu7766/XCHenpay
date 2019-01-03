import './init'

import './outer' // 外部前端(不在vue component範疇中)

var $app = document.querySelector('#app')
if ($app) {
    new Vue({
        el: '#app',
        components: {
            ActivityLog: () => import('./pages/ActivityLog'),
            OrderSearch: () => import('./pages/OrderSearch'),
            LendList: () => import('./pages/LendList'),
            LendManage: () => import('./pages/LendManage'),
            BankAccountList: () => import('./pages/BankAccountList'),
            BankAccountBind: () => import('./pages/BankAccountBind'),
            ReportStatistics: () => import('./pages/Report/Statistics'),
            ReportSearch: () => import('./pages/Report/Search'),
            CompanyManage: () => import('./pages/CompanyManage'),
            WhiteList: () => import('./pages/WhiteList'),
            AccountManage: () => import('./pages/AccountManage'),
            Replenishment: () => import('./pages/Replenishment')
            // ActivityLog: resolve => {
            //     require(['./pages/ActivityLog'], resolve)
            // }
        }
    })
}

