import BaseRequest from '../../BaseRequest'
import _config from './config'

export default class OrderSearch extends BaseRequest {
    get baseUrls() {
        return super.baseUrls.concat('/admin')
    }

    constructor() {
        super()
        this.config = _config
    }

    async getDataInit() {
        return await this.request('dataInit')
    }

    async getPayment() {
        return await this.request('payment')
    }

    async getList(data) {
        return await axios.all([this.request('list', data), this.request('tradeInfo', data)])
    }

    async getListTotal(data, options) {
        return await this.request('listTotal', data, options)
    }

    async getInfo(data, options) {
        return await this.request('info', data, options)
    }

    async getState(data, options) {
        return await this.request('state', data, options)
    }

    async update(data, options) {
        return await this.request('update', data, options)
    }

    async notify(data, options) {
        return await this.request('notify', data, options)
    }
}
