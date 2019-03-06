class Permission {
    static OrderNotify = 'logQuery.callNotify' // 'notify.order.fail'
    static CompanyChange = 'users.dataSwitch'
    static OrderSearch = 'logQuery'
    static OrderEdit = 'logQuery.showState'
    static LendManageIndex = 'lendManage.index'
    static LendManage = 'lendManage'
    static BankAccountList = 'bank.card.list'
}

export {Permission as default}
