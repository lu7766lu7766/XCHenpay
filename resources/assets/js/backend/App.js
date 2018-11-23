import './init'

new Vue({
    el: '#app',
    components: {
        ActivityLog: () => import('./pages/ActivityLog'),
        OrderSearch: () => import('./pages/OrderSearch')
        // ActivityLog: resolve => {
        //     require(['./pages/ActivityLog'], resolve)
        // }
    }
})
