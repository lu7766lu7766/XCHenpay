window._ = require('lodash')
window.Vue = require('vue')
window.moment = require('moment')
window.axios = require('axios')


// 匯入 Report.vue 檔，不需加副檔名
import numFormat from 'vue-filter-number-format'

Vue.config.productionTip = false
Vue.filter('numFormat', numFormat)
Vue.prototype._ = _
Vue.prototype.moment = moment

import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'

Vue.use(Loading)

import apiConfs from 'config/api'

// console.log(document.head.querySelector('[name="csrf-token"]'))
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content

var qs = require('qs')
Vue.prototype.$callApi = async (key, data) => {
    const {0: apiKey, 1: target} = key.split(':')
    const apiGroup = apiConfs[apiKey]
    const apiConf = apiGroup[target]
    // console.log(apiKey, target, data, apiGroup, apiConf)

    let axiosBody = {
        url: replaceMatchData(apiConf.uri, data),
        method: apiConf.method,
        responseType: 'json',
        // headers: {
        //     'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
        // }
    }
    const isSendData = apiConf.method === 'put' || apiConf.method === 'post'
    const dataProperty = isSendData
        ? 'data'
        : 'params'
    axiosBody[dataProperty] = isSendData
        ? qs.stringify(data)
        : data

    const res = await axios(axiosBody)

    if (res.status !== 200) {
        alert("网路异常")
        throw 'network error'
    }
    if (!_.includes([0, 200], res.data.code)) {
        alert("与服务器沟通错误")
        throw 'service error'
    }
    // console.log(res)

    return res.data
}

// request.headers.set('X-CSRF-TOKEN', document.head.querySelector('meta[name="csrf-token"]').content);

function replaceMatchData(uri, data) {
    var ts = uri.match(/({[\w]+})/g)
    if (ts) {
        ts.forEach(key => {
            key = key.replace(/[{}]/g, '')
            if (data[key]) {
                uri = uri.replace(`{${key}}`, data[key])
                delete data[key]
            }
        })
    }
    return uri
}
