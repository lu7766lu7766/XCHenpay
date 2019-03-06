import store from '../store'

class UserInfo {

    static user = store.state.userInfo ? store.state.userInfo : {}

    static getThisUser() {
        return store.state.userInfo ? store.state.userInfo : {}
    }

    static this() {
        this.user = this.getThisUser()
        return this
    }

    static setUser(user) {
        this.user = user
        return this
    }

    static getUser() {
        return this.user
    }

    static getID() {
        return this.getUser().id
    }

    static getApplyStatus() {
        return this.getUser().apply_status
    }

    static getCompanyName() {
        return this.getUser().company_name
    }

    static getRole() {
        return this.getUser().roles && this.getUser().roles[0] ? this.getUser().roles[0] : {}
    }

    ////////////////////////////////////////////////////////////////////////////

    static is(role) {
        return this.getRole().slug === role
    }

    static has(key) {
        return !!this.getRole().permissions[key]
    }
}

export {UserInfo as default}
