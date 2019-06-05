import BaseRequest from '../../BaseRequest'
import _config from './config'

export default class User extends BaseRequest {
    get baseUrls() {
        return super.baseUrls.concat('admin/channel/feeManagement')
    }

    constructor() {
        super()
        this.config = _config
    }

    async getOptions(options) {
        return await this.request('options', {}, options)
    }

    async getList(data, options) {
        return await this.request('list', data, options)
    }

    async update(data, options) {
        return await this.request('update', data, options)
    }
}
