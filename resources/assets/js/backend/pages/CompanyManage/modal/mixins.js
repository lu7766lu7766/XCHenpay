export default {
    rules: {
        'data.company_name': {
            require: {
                message: '商户名称 不得为空白'
            }
        },
        'data.mobile': {
            require: {
                message: '联络电话 不得为空白'
            }
        },
        'data.email': {
            require: {
                message: '电子邮箱 不得为空白'
            },
            email: {
                message: '电子邮箱 不符合规定'
            }
        },
        'data.status': {
            require: {
                message: '状态 不得为空白'
            }
        },
        'data.apply_status': {
            require: {
                message: '下发状态 不得为空白'
            }
        },
        'data.QQ_id': {
            require: {
                message: 'QQ号 不得为空白'
            }
        },
        'data.role_id': {
            require: {
                message: '角色 不得为空白'
            }
        }
    },
}
