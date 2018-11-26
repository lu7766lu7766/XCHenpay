import './init'

new Vue({
    el: '#app',
    components: {
        ActivityLog: () => import('./pages/ActivityLog'),
        OrderSearch: () => import('./pages/OrderSearch'),
        ReportSearch: () => import('./pages/ReportSearch')
        // ActivityLog: resolve => {
        //     require(['./pages/ActivityLog'], resolve)
        // }
    }
})
