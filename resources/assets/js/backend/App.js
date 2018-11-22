import './init'

new Vue({
    el: '#app',
    components: {
        ActivityLog: () => import('./pages/ActivityLog')
        // ActivityLog: resolve => {
        //     require(['./pages/ActivityLog'], resolve)
        // }
    }
})
