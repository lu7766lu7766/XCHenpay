import './init'

new Vue({
    el: '#app',
    components: {
        ActivityLog: () => import('./pages/ActivityLog'),
        OrderSearch: () => import('./pages/OrderSearch'),
        LendList: () => import('./pages/LendList'),
        LendManage: () => import('./pages/LendManage')
        // ActivityLog: resolve => {
        //     require(['./pages/ActivityLog'], resolve)
        // }
    }
})
