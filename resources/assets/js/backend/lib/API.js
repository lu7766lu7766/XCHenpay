export default class API {
    constructor() {
        this.cashier = {
            listenerSetting: new (require('./Request/Cashier/ListenerSetting').default),
            accountSetting: new (require('./Request/Cashier/AccountSetting').default),
            companyAccount: new (require('./Request/Cashier/CompanyAccount').default)
        }
        this.search = {
            orderSearch: new (require('./Request/Search/OrderSearch').default)
        }
        this.gateway = {
            select: new (require('./Request/Gateway/Select').default),
            relay: new (require('./Request/Gateway/Relay').default)
        }
        this.software = {
            download: new (require('./Request/Software/Download').default)
        }
    }
}
