import BaseRequest from '../BaseRequest'
import _config from './config'

export default class User extends BaseRequest {
    get baseUrls() {
        return super.baseUrls.concat('company/listener/setting/bank/template')
    }

    constructor() {
        super()
        this.config = _config
    }

    async getOptions(data, options) {
        return await this.request('options', data, options)
    }

    async getList(data, options) {
        return await this.request('list', data, options)
    }

    async getListTotal(data, options) {
        return await this.request('listTotal', data, options)
    }

    async getInfo(data, options) {
        return await this.request('info', data, options)
    }

    async create(data, options) {
        return await this.request('create', data, options)
    }

    async update(data, options) {
        return await this.request('update', data, options)
    }
}
