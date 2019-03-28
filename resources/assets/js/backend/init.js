window._ = require('lodash')
window.Vue = require('vue')
window.moment = require('moment')
window.axios = require('axios')

// vue-bus
window.Vue.use(require('vue-bus'))

// UserInfo constant global
import UserInfo from 'config/UserInfo'

window.UserInfo = UserInfo
Vue.prototype.UserInfo = UserInfo

// permission constant global
import Permission from 'config/Permission'

window.Permission = Permission
Vue.prototype.Permission = Permission

// Roles constant global
import Roles from 'config/Roles'

window.Roles = Roles
Vue.prototype.Roles = Roles

// number format
import numFormat from 'vue-filter-number-format'

Vue.filter('numFormat', numFormat)

// vue init
Vue.config.productionTip = false

// lodash instance
Vue.prototype._ = _

// moment instance
Vue.prototype.moment = moment

// vue ajax loading
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'

Vue.use(Loading)

// call api setting
import apiConfs from 'config/api'

var $csrf = document.head.querySelector('meta[name="csrf-token"]')
axios.defaults.headers.common['X-CSRF-TOKEN'] = $csrf ? $csrf.content : ''

var qs = require('qs')
Vue.prototype.$callApi = async (key, data, loader, option = {}) => {
    let apiConf = apiConfs
    key.split(':').forEach(apiKey => {
        apiConf = apiConf[apiKey]
    })
    // console.log(apiKey, target, data, apiGroup, apiConf)

    if (typeof apiConf.uri == 'string') {
        return doRequest(apiConf.uri, apiConf.method, data, loader, option)
    } else if (typeof apiConf.uri == 'object') {
        let res = []
        for (const uri of apiConf.uri) {
            res.push(doRequest(uri, apiConf.method, data, loader, option))
        }
        // apiConf.uri.forEach(async uri => {
        //     res.push(await doRequest(uri, apiConf.method, data, loader))
        // })
        return axios.all(res)
    }
    return []
}

// linkTo instance func
Vue.prototype.$linkTo = function (uri) {
    setTimeout(() => {
        location.href = location.origin + uri
    })
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

async function doRequest(uri, method, data, loader, option) {
    let axiosBody = {
        url: replaceMatchData(uri, data),
        method: method,
        responseType: 'json',
        // headers: {
        //     'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
        // }
    }

    const {isShowAlert = true, throwRes = false} = option

    data = _.pickBy(data, x => x !== '' && !_.isNull(x) && !_.isUndefined(x))
    const isSendData = method === 'put' || method === 'post'
    const dataProperty = isSendData
        ? 'data'
        : 'params'
    axiosBody[dataProperty] = isSendData
        ? qs.stringify(data)
        : data

    const res = await axios(axiosBody).catch(err => {
        if (err.data && err.data.code && isShowAlert) {
            alert(errorCode[err.data.code] ? errorCode[err.data.code] : '伺服器忙碌中')
        } else if (isShowAlert) {
            alert('伺服器忙碌中')
        }
        if (loader) loader.hide()
        throw throwRes ? err.data : 'network error'
    })

    if (res.data && res.data.code && !_.includes([0, 200], res.data.code)) {
        if (isShowAlert) {
            alert(errorCode[res.data.code] ? errorCode[res.data.code] : '与服务器沟通错误')
        }
        if (loader) loader.hide()
        throw throwRes ? res.data : 'service error'
    }
    // console.log(res)

    return res.data
}


Vue.prototype.$open = function (url, title, config) {
    window.open(url, title, qs.stringify(config).replace('&', ','))
}
