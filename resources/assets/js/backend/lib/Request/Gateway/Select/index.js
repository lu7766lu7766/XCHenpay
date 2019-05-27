import BaseRequest from '../../BaseRequest'
import _config from './config'

export default class OrderSearch extends BaseRequest {
    get baseUrls() {
        return super.baseUrls.concat('/pay/gateway')
    }

    constructor() {
        super()
        this.config = _config
    }

    async getData(data, options) {
        return await this.request('data', data, options)
    }

    async alipay(data, options) {
        return await this.request('alipay', data, options)
    }

    async taobo(data, options) {
        return await this.request('taobo', data, options)
    }
}
