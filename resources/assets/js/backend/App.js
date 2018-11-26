import './init'

new Vue({
    el: '#app',
    components: {
        ActivityLog: () => import('./pages/ActivityLog'),
        OrderSearch: () => import('./pages/OrderSearch'),
        LendManage: () => import('./pages/LendManage')
        // ActivityLog: resolve => {
        //     require(['./pages/ActivityLog'], resolve)
        // }
    }
})
