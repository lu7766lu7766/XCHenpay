export default class API {
    constructor() {
        this.cashier = {
            listenerSetting: new (require('./Request/Cashier/ListenerSetting').default),
            accountSetting: new (require('./Request/Cashier/AccountSetting').default),
            companyAccount: new (require('./Request/Cashier/CompanyAccount').default)
        }
    }
}
