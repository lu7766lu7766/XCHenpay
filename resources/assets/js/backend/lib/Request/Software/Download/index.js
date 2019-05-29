import BaseRequest from '../../BaseRequest'
import _config from './config'

export default class Download extends BaseRequest {
    get baseUrls() {
        return super.baseUrls.concat('company/software/download')
    }

    constructor() {
        super()
        this.config = _config
    }

    async getData() {
        return await this.request('data')
    }
}
