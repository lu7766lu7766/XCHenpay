import './init'

import './outer' // 外部前端(不在vue component範疇中)
import './Gateway' // 行動支付轉銀行卡(全新頁面)

var $app = document.querySelector('#app')
import UserMixins from 'mixins/user'

import store from './store'

if ($app) {
    new Vue({
        el: '#app',
        mixins: [UserMixins],
        store,
        components: {
            /** 商戶功能 */
            CompanyData: () => import('./pages/Company/CompanyData'),
            CompanyManage: () => import('./pages/Company/CompanyManage'),
            BankAccountList: () => import('./pages/Company/BankAccountList'), // 行卡列表
            BankAccountBind: () => import('./pages/Company/BankAccountBind'), // 行卡綁定
            LendList: () => import('./pages/Company/LendList'), // 下發列表(申請)
            LendManage: () => import('./pages/Company/LendManage'), //  下發管理
            WhiteList: () => import('./pages/Company/WhiteList'),
            /** 通道管理 */
            FeeList: () => import('./pages/ChannelSetting/FeeList'), // 通道列表
            FeeManage: () => import('./pages/ChannelSetting/FeeManage'), // 通道管理
            /** 信息通知 */
            MessageList: () => import('./pages/MessageNotify/List'), // 信息列表
            MessageManage: () => import('./pages/MessageNotify/Manage'), // 信息管理
            /** 收款管理 */
            CompanyAccount: () => import('./pages/Cashier/CompanyAccount'),
            AccountSetting: () => import('./pages/Cashier/AccountSetting'),
            CashierAccountSetting: () => import('./pages/Cashier/AccountManage'),
            /** 查詢功能 */
            OrderSearch: () => import('./pages/Search/OrderSearch'),
            ReportStatistics: () => import('./pages/Search/Report/Statistics'), // 報表統計
            ReportSearch: () => import('./pages/Search/Report/Search'), // 報表查詢
            Replenishment: () => import('./pages/Search/Replenishment'), // 補單管理
            /** 歷程紀錄 */
            ActivityLog: () => import('./pages/History/ActivityLog'),
            NotifyOrderFailLog: () => import('./pages/History/NotifyOrderFailLog'),
            /** 系統設置 */
            AccountManage: () => import('./pages/SystemSetting/AccountManage'),
            PaymentManage: () => import('./pages/SystemSetting/PaymentManage'),
            // ActivityLog: resolve => {
            //     require(['./pages/ActivityLog'], resolve)
            // }
        },
        mounted() {
            this.getUserInfo()
        }
    })
}

