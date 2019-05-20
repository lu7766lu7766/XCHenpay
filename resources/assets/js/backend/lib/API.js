export default class API {
    constructor() {
        this.listenerSetting = new (require('./Request/ListenerSetting').default)
    }
}
