import BaseRequest from '../../BaseRequest'
import _config from './config'

export default class User extends BaseRequest {
    get baseUrls() {
        return super.baseUrls.concat('/user/cashier/personal')
    }

    constructor() {
        super()
        this.config = _config
    }

    async getOptions() {
        return await axios.all([this.request('channel'), this.request('bank')])
    }

    async getList(data, options) {
        return await this.request('list', data, options)
    }

    async getListTotal(data, options) {
        return await this.request('total', data, options)
    }

    async create(data, options) {
        return await this.request('create', data, options)
    }

    async update(data, options) {
        return await this.request('update', data, options)
    }
}
