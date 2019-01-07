var $lendNotify = document.querySelector('#lendNotify')
if ($lendNotify) {
    new Vue({
        el: '#lendNotify',
        components: {
            LendNotify: require('./pages/outer/LendNotify')
        }
    })
}

var $headerInfo = document.querySelector('#headerInfo')
if ($headerInfo) {
    new Vue({
        el: '#headerInfo',
        components: {
            HeaderInfo: require('./pages/outer/HeaderInfo')
        }
    })
}
