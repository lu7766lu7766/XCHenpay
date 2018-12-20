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

var $csrf = document.head.querySelector('meta[name="csrf-token"]')
axios.defaults.headers.common['X-CSRF-TOKEN'] = $csrf ? $csrf.content : ''

var qs = require('qs')
Vue.prototype.$callApi = async (key, data, loader) => {
    let apiConf = apiConfs
    key.split(':').forEach(apiKey => {
        apiConf = apiConf[apiKey]
    })
    // console.log(apiKey, target, data, apiGroup, apiConf)

    if (typeof apiConf.uri == 'string') {
        return doRequest(apiConf.uri, apiConf.method, data, loader)
    } else if (typeof apiConf.uri == 'object') {
        let res = []
        for (const uri of apiConf.uri) {
            res.push(doRequest(uri, apiConf.method, data, loader))
        }
        // apiConf.uri.forEach(async uri => {
        //     res.push(await doRequest(uri, apiConf.method, data, loader))
        // })
        return axios.all(res)
    }
    return []
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
        // uri = uri.replace(/\/({[\w]+})/g, '')
    }
    return uri
}

import errorCode from 'config/error'

axios.interceptors.response.use((response) => {
    return response
}, function (error) {
    return Promise.reject(error.response)
})

async function doRequest(uri, method, data, loader) {
    let axiosBody = {
        url: replaceMatchData(uri, data),
        method: method,
        responseType: 'json',
        // headers: {
        //     'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
        // }
    }

    data = _.pickBy(data, x => x !== '' && !_.isNull(x) && !_.isUndefined(x))
    const isSendData = method === 'put' || method === 'post'
    const dataProperty = isSendData
        ? 'data'
        : 'params'
    axiosBody[dataProperty] = isSendData
        ? qs.stringify(data)
        : data

    const res = await axios(axiosBody).catch(err => {
        if (err.data && err.data.code) {
            alert(errorCode[err.data.code] ? errorCode[err.data.code] : '伺服器忙碌中')
        } else {
            alert('伺服器忙碌中')
        }
        if (loader) loader.hide()
        throw 'network error'
    })

    if (res.data && res.data.code && !_.includes([0, 200], res.data.code)) {
        alert(errorCode[res.data.code] ? errorCode[res.data.code] : '与服务器沟通错误')
        if (loader) loader.hide()
        throw 'service error'
    }
    // console.log(res)

    return res.data
}
