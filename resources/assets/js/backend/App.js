import './init'

var $app = document.querySelector('#app')
if ($app) {
    new Vue({
        el: '#app',
        components: {
            ActivityLog: () => import('./pages/ActivityLog'),
            OrderSearch: () => import('./pages/OrderSearch'),
            LendList: () => import('./pages/LendList'),
            LendManage: () => import('./pages/LendManage'),
            ReportStatistics: () => import('./pages/ReportStatistics'),
            ReportSearch: () => import('./pages/ReportSearch')
            // ActivityLog: resolve => {
            //     require(['./pages/ActivityLog'], resolve)
            // }
        }
    })
}
