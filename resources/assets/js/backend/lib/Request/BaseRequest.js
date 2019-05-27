import {createApiBody, roopParse} from 'lib/myLib'
import {SuccessCodes} from 'config/api'
import errorCode from 'config/error'

var path = require('path')

axios.defaults.baseURL = `/`
// asign in init.js
// axios.interceptors.response.use((response) => {
//     return response
// }, function (error) {
//     return Promise.reject(error.response)
// })

export default class BaseRequest {
    get baseUrls() {
        return []
    }

    constructor() {
    }

    convertMoment2String(res) {
        _.forEach(res, (val, key) => {
            if (val && typeof val === 'object' && (moment.isMoment(val) || typeof val.getMonth === 'function')) {
                res[key] = moment(val).format('YYYY-MM-DD HH:mm:ss')
            }
        })
        return res
    }

    async request(key, data = {}, options = {}) {
        if (typeof this.config !== 'object') throw 'please init this apiFetch'
        const conf = this.config[key]
        if (!conf) throw 'not found the config'

        let res
        try {
            res = await axios(createApiBody(
                conf.method,
                path.join(...this.baseUrls, conf.uri),
                _.merge(
                    _.pickBy(this.convertMoment2String(data), x => x !== '' && !_.isNull(x) && !_.isUndefined(x)), conf.data),
                conf.header)
            )
        } catch (e) {
            return this.resultProccess(e, options)
        }

        return this.resultProccess(res, options)
    }

    resultProccess(res, options) {
        const successF = options.success || options.s
        const failF = options.fail || options.f

        let errorMessages = []
        _.forEach(res.data.code, code => {
            switch (code) {
                case SuccessCodes:
                    break
                default:
                    errorMessages.push(errorCode[code]
                        ? errorCode[code]
                        : 'system error!! please try again later')
                    break
            }
        })
        return errorMessages.length
            ? failF
                ? failF(res.data, errorMessages)
                : this.errorHandle(res.data, errorMessages)
            : successF
                ? successF(roopParse(res.data))
                : roopParse(res.data)
    }

    errorHandle(res, errorMessages) {
        const msg = errorMessages.join('\n')
        alert(msg)
        throw {message: msg, ...res}
    }
}
