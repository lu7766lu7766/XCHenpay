export default {
    userInfo: {
        uri: '/admin/user/info',
        method: 'get'
    },
    /** 帳戶歷程 */
    activityLog: {
        list: {
            uri: '/admin/activity_log/data',
            method: 'post',
        },
        total: {
            uri: '/admin/activity_log/data/total',
            method: 'post',
        }
    },
    /** 訂單查詢 */
    orderSearch: {
        dataInit: {
            uri: '/admin/logQuery/dataInit',
            method: 'get'
        },
        order: {
            dataInit: {
                uri: '/admin/logQuery/payment',
                method: 'get'
            },
            list: {
                uri: ['/admin/data', '/admin/orderTradeInfo'],
                method: 'post'
            },
            total: {
                uri: '/admin/dataTotal',
                method: 'post'
            },
            info: {
                uri: '/admin/logQuery/showInfo/{authcode}',
                method: 'get'
            },
            state: {
                uri: '/admin/logQuery/showState/{authcode}',
                method: 'get'
            },
            update: {
                uri: '/admin/logQuery/updateState',
                method: 'post'
            },
            notify: {
                uri: '/admin/logQuery/callNotify',
                method: 'post'
            }
        },
        fee: {
            list: {
                uri: '/admin/logQuery/feeData',
                method: 'post'
            },
            info: {
                uri: '/admin/logQuery/showFeeInfo/{payment}',
                method: 'get'
            },
            state: {
                uri: '/admin/logQuery/editFeeInfo/{payment}',
                method: 'get'
            },
            update: {
                uri: '/admin/logQuery/updateFeeInfo',
                method: 'post'
            }
        }
    },
    /** 下發列表 */
    lendList: {
        amountInfo: {
            uri: '/admin/lendList/amountInfo',
            method: 'get'
        },
        lendStatus: {
            uri: '/admin/lendList/lendStatus',
            method: 'get'
        },
        bankAccountInfo: {
            uri: '/admin/lendList/bankCardInfo',
            method: 'get'
        },
        list: {
            uri: '/admin/lendList',
            method: 'post'
        },
        total: {
            uri: '/admin/lendList/total',
            method: 'post'
        },
        info: {
            uri: '/admin/lendList/{id}',
            method: 'get'
        },
        apply: {
            uri: '/admin/lendList/apply',
            method: 'post'
        },
        sendVerifyCode: {
            uri: '/admin/lendList/sendVerifyCode',
            method: 'post'
        }
    },
    /** 下發管理 */
    lendManage: {
        dataInit: {
            uri: '/admin/lendManage/data',
            method: 'get'
        },
        list: {
            uri: '/admin/lendManage/data',
            method: 'post'
        },
        total: {
            uri: [
                '/admin/lendManage/dataTotal',
                '/admin/lendManage/total'
            ],
            method: 'post'
        },
        // applyTotal: {
        //     uri: '/admin/lendManage/total',
        //     method: 'post'
        // },
        update: {
            uri: '/admin/lendManage',
            method: 'post'
        }
    },
    /** 行卡列表 */
    bankAccountList: {
        dataInit: {
            uri: ['/admin/bankCard/getCompany', '/admin/bankCard/status'],
            method: 'get'
        },
        list: {
            uri: '/admin/bankCard',
            method: 'post'
        },
        total: {
            uri: '/admin/bankCard/total',
            method: 'post'
        },
        update: {
            uri: '/admin/bankCard',
            method: 'put'
        },
        delete: {
            uri: '/admin/bankCard',
            method: 'delete'
        }
    },
    /** 行卡綁定 */
    bankAccountBind: {
        dataInit: {
            uri: '/user/bankCard/bind/status',
            method: 'get'
        },
        list: {
            uri: '/user/bankCard/bind',
            method: 'post'
        },
        total: {
            uri: '/user/bankCard/bind/total',
            method: 'post'
        },
        info: {
            uri: '/user/bankCard/bind/info',
            method: 'post'
        },
        create: {
            uri: '/user/bankCard/bind/binding',
            method: 'post'
        },
        verify: {
            uri: '/user/bankCard/bind/sendVerifyCode',
            method: 'post'
        },
        delete: {
            uri: '/user/bankCard/bind',
            method: 'delete'
        }
    },
    /** 報表統計 */
    reportStatistics: {
        list: {
            uri: '/admin/search/reportStatQuery',
            method: 'post'
        }
    },
    /** 報表查詢 */
    reportSearch: {
        list: {
            uri: '/admin/search/reportQuery',
            method: 'post'
        }
    },
    /** 商戶管理 */
    companyManage: {
        list: {
            uri: '/admin/merchants',
            method: 'post'
        },
        total: {
            uri: '/admin/merchants/total',
            method: 'post'
        },
        create: {
            uri: '/admin/merchants/maintain',
            method: 'post'
        },
        info: {
            uri: '/admin/merchants/maintain/{id}',
            method: 'get'
        },
        update: {
            uri: '/admin/merchants/maintain',
            method: 'put'
        },
        delete: {
            uri: '/admin/merchants/maintain',
            method: 'delete'
        },
        updateStatus: {
            uri: '/admin/merchants/maintain/applyStatus',
            method: 'put'
        },
        restore: {
            list: {
                uri: '/admin/trashedMerchants',
                method: 'post'
            },
            total: {
                uri: '/admin/trashedMerchants/total',
                method: 'post'
            },
            restore: {
                uri: '/admin/trashedMerchants/restore',
                method: 'post'
            }
        }
    },
    /** 白名單管理 */
    whiteList: {
        list: {
            uri: '/admin/whitelist',
            method: 'post'
        },
        total: {
            uri: '/admin/whitelist/total',
            method: 'post'
        },
        detail: {
            uri: '/admin/whitelist/maintain/{user_id}',
            method: 'get'
        },
        update: {
            uri: '/admin/whitelist/maintain',
            method: 'post'
        },
        delete: {
            uri: '/admin/whitelist/maintain',
            method: 'delete'
        }
    },
    /** 回调错误记录 */
    notifyOrderFail: {
        list: {
            uri: '/admin/notifyOrderFail',
            method: 'post'
        },
        total: {
            uri: '/admin/notifyOrderFail/total',
            method: 'post'
        }
    },
    /** 帳號管理 */
    accountManage: {
        dataInit: {
            uri: '/admin/systemSetting/getRolesList',
            method: 'get'
        },
        list: {
            uri: '/admin/systemSetting/userList',
            method: 'post'
        },
        total: {
            uri: '/admin/systemSetting/userTotal',
            method: 'post'
        },
        detail: {
            uri: '/admin/systemSetting/userDetail',
            method: 'post'
        },
        create: {
            uri: '/admin/systemSetting/userAdd',
            method: 'post'
        },
        update: {
            uri: '/admin/systemSetting/userUpdate',
            method: 'post'
        },
        delete: {
            uri: '/admin/systemSetting/userDel',
            method: 'post'
        }
    },
    /** 補單管理 */
    replenishment: {
        list: {
            uri: '/admin/order/fill/index',
            method: 'post'
        },
        total: {
            uri: '/admin/order/fill/total',
            method: 'post'
        },
        update: {
            uri: '/admin/order/fill/edit',
            method: 'post'
        },
        detail: {
            uri: '/admin/order/fill/info/{id}',
            method: 'get'
        },
        dataInit: {
            uri: '/admin/order/fill/options',
            method: 'get'
        }
    },
    /** 通道列表 */
    feeList: {
        list: {
            uri: '/admin/channel/feeList',
            method: 'post'
        }
    },
    /** 通道管理 */
    feeManage: {
        dataInit: {
            uri: '/admin/channel/feeManagement/merchantList',
            method: 'get'
        },
        list: {
            uri: '/admin/channel/feeManagement',
            method: 'post'
        },
        update: {
            uri: '/admin/channel/feeManagement/maintain',
            method: 'put'
        }
    },
    /** 商戶資料 */
    companyData: {
        update: {
            uri: '/admin/user/profile/password',
            method: 'put'
        }
    },
    /** 商戶帳號 */
    companyAccount: {
        dataInit: {
            uri: '/admin/cashier/company/channel',
            method: 'get'
        },
        list: {
            uri: '/admin/cashier/company',
            method: 'post'
        },
        total: {
            uri: '/admin/cashier/company/total',
            method: 'post'
        },
        create: {
            uri: '/admin/cashier/company/create',
            method: 'post'
        },
        update: {
            uri: '/admin/cashier/company',
            method: 'put'
        }
    },
    /** 帳戶設置 */
    accountSetting: {
        dataInit: {
            uri: '/user/cashier/personal/channel',
            method: 'get'
        },
        list: {
            uri: '/user/cashier/personal',
            method: 'post'
        },
        total: {
            uri: '/user/cashier/personal/total',
            method: 'post'
        },
        create: {
            uri: '/user/cashier/personal/create',
            method: 'post'
        },
        update: {
            uri: '/user/cashier/personal',
            method: 'put'
        }
    },
    /** 行動支付轉銀行卡 */
    gateway: {
        alipay: {
            data: {
                uri: '/pay/gateway/to_bank_card/data',
                method: 'get'
            }
        },
        relay: {
            data: {
                uri: '/pay/gateway/relay/data',
                method: 'get'
            }
        }
    },
    /** 帳戶管理 */
    cashierAccountManage: {
        dataInit: {
            uri: '/admin/cashier/manage/merchant',
            method: 'get'
        },
        list: {
            uri: '/admin/cashier/manage',
            method: 'post'
        },
        total: {
            uri: '/admin/cashier/manage/total',
            method: 'post'
        },
        info: {
            uri: '/admin/cashier/manage/info',
            method: 'post'
        }
    },
    /** 信息管理 */
    messageManage: {
        dataInit: {
            uri: ['/admin/informationManage/roles', '/admin/informationManage/category'],
            method: 'get'
        },
        list: {
            uri: '/admin/informationManage',
            method: 'post'
        },
        total: {
            uri: '/admin/informationManage/total',
            method: 'post'
        },
        create: {
            uri: '/admin/informationManage/notify',
            method: 'post'
        },
        delete: {
            uri: '/admin/informationManage',
            method: 'delete'
        }
    },
    /** 信息列表 */
    messageList: {
        dataInit: {
            uri: '/user/informationLists/category',
            method: 'get'
        },
        list: {
            uri: '/user/informationLists',
            method: 'post'
        },
        total: {
            uri: '/user/informationLists/total',
            method: 'post'
        },
        info: {
            uri: '/user/informationLists/{id}/info',
            method: 'get'
        },
        delete: {
            uri: '/user/informationLists',
            method: 'delete'
        }
    },
    /** 金流管理 */
    paymentManage: {
        list: {
            uri: '/admin/payment/manage/dataList',
            method: 'post'
        },
        total: {
            uri: '/admin/payment/manage/dataTotal',
            method: 'post'
        },
        detail: {
            uri: '/admin/payment/manage/detail',
            method: 'post'
        },
        create: {
            uri: '/admin/payment/manage/add',
            method: 'post'
        },
        update: {
            uri: '/admin/payment/manage/update',
            method: 'post'
        },
        delete: {
            uri: '/admin/payment/manage/del',
            method: 'post'
        }
    },
    /** 外部view */
    outer: {
        notify: {
            /** 下發申請數量 */
            lendManage: {
                uri: '/admin/lendManage/applyNotice',
                method: 'get'
            },
            /** 行卡綁定處理中數量 */
            bankAccountList: {
                uri: '/admin/pendingCount',
                method: 'get'
            },
            /** 未讀訊息 */
            unread: {
                uri: '/admin/unreadCount',
                method: 'get'
            }
        },
        /** 表頭資訊 */
        headerInfo: {
            uri: '/admin/tradeInfoOnToday',
            method: 'get'
        }
    }
}
