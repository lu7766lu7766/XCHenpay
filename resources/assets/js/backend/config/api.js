export default {
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
            list: {
                uri: '/admin/data',
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
        userInfo: {
            uri: '/admin/lendList/userInfo',
            method: 'get'
        },
        amountInfo: {
            uri: '/admin/lendList/amountInfo',
            method: 'get'
        },
        lendStatus: {
            uri: '/admin/lendList/lendStatus',
            method: 'get'
        },
        bankAccountInfo: {
            uri: '/admin/lendList/backAccountInfo',
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
            uri: '/admin/account/getCompany',
            method: 'get'
        },
        list: {
            uri: '/admin/account/accountData',
            method: 'post'
        },
        total: {
            uri: '/admin/account/total',
            method: 'post'
        },
        delete: {
            uri: '/admin/account/deleteAccount',
            method: 'delete'
        }
    },
    /** 行卡綁定 */
    bankAccountBind: {
        list: {
            uri: '/admin/account/accountList',
            method: 'post'
        },
        total: {
            uri: '/admin/account/listTotal',
            method: 'post'
        },
        create: {
            uri: '/admin/account/addAccount',
            method: 'post'
        },
        verify: {
            uri: '/admin/account/sendVerifyCode',
            method: 'post'
        },
        delete: {
            uri: '/admin/account/deleteAccountData',
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
        dataInit: {
            uri: ['/admin/users/getThisUser', '/admin/users/getRolesList'],
            method: 'get'
        },
        list: {
            uri: '/admin/users/data',
            method: 'post'
        },
        total: {
            uri: '/admin/users/dataTotal',
            method: 'post'
        },
        create: {
            uri: '/admin/users/dataAdd',
            method: 'post'
        },
        info: {
            uri: '/admin/users/dataDetail',
            method: 'post'
        },
        update: {
            uri: '/admin/users/dataUpdate',
            method: 'post'
        },
        delete: {
            uri: '/admin/users/dataDel',
            method: 'post'
        },
        updateStatus: {
            uri: '/admin/users/applyStatusUpdate',
            method: 'post'
        },
        trashedList: {
            uri: '/admin/users/dataTrashed',
            method: 'post'
        },
        trashedTotal: {
            uri: '/admin/users/dataTrashedTotal',
            method: 'post'
        },
        restore: {
            uri: '/admin/users/dataRestore',
            method: 'post'
        }
    },
    /** 外部view */
    outer: {
        /** 下發申請數量 */
        lendApplyNotify: {
            uri: '/admin/lendManage/applyNotice',
            method: 'get'
        }
    }
}
