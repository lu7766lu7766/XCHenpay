import {createApiBody, roopParse} from 'lib/myLib'
import {SuccessCodes} from 'config/api'
import errorCode from 'config/error'

var path = require('path')

axios.defaults.baseURL = `/`
axios.interceptors.response.use((response) => {
    return response
}, function (error) {
    return Promise.reject(error.response)
})

export default class BaseRequest {
    get baseUrls() {
        return []
    }

    constructor() {
    }

    convertMoment2String(res) {
        _.forEach(res, (val, key) => {
            if (typeof val === 'object' && (moment.isMoment(val) || typeof val.getMonth === 'function')) {
                res[key] = moment(val).format('YYYY-MM-DD HH:mm:ss')
            }
        })
        return res
    }

    async request(key, data = {}, options = {}) {
        if (typeof this.config !== 'object') throw 'please init this apiFetch'
        const conf = this.config[key]
        if (!conf) throw 'not found the config'

        const successF = options.success || options.s
        const failF = options.fail || options.f

        // console.log(createApiBody(conf.method, conf.uri, _.merge(_.pickBy(data), conf.data), conf.header))

        let res
        try {
            res = await axios(createApiBody(
                conf.method,
                path.join(...this.baseUrls, conf.uri),
                _.merge(
                    _.pickBy(this.convertMoment2String(data), x => x !== '' && !_.isNull(x) && !_.isUndefined(x)), conf.data),
                conf.header))
        } catch (e) {
            alert('system error!! please try again later')
            throw e
            return
        }

        let errorMessages = []
        _.forEach(res.data.code, code => {
            switch (code) {
                case SuccessCodes:
                    break
                default:
                    errorMessages.push(errorCode[code]
                        ? errorCode[code]
                        : 'have error!')
                    break
            }
        })
        return errorMessages.length
            ? failF
                ? failF(errorMessages)
                : this.errorHandle(errorMessages)
            : successF
                ? successF(roopParse(res.data))
                : roopParse(res.data)

    }

    errorHandle(errorMessages) {
        const msg = errorMessages.join('\n')
        alert(msg)
        throw msg
    }
}
