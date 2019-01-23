import store from './store'

var $headerInfo = document.querySelector('#headerInfo')
if ($headerInfo) {
    new Vue({
        el: '#headerInfo',
        store,
        components: {
            HeaderInfo: require('./pages/HeaderInfo')
        }
    })
}
