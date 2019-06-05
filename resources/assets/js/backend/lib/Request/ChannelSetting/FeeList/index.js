import BaseRequest from '../../BaseRequest'
import _config from './config'

export default class User extends BaseRequest {
    get baseUrls() {
        return super.baseUrls.concat('admin/channel')
    }

    constructor() {
        super()
        this.config = _config
    }

    async getList(data, options) {
        return await this.request('list', data, options)
    }
}
