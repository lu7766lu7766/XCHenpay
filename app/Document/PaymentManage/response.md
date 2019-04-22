# 系統設置 > 金流管理

> 列表

```
{
    "code": 200,
    "data": [
        {
            "id": 1,
            "name": "test",
            "status": "on",
            "vendor": "aliPay",
            "user_id": null,
            "max_deposit": 1000,
            "min_deposit": 100,
            "total_deposit": 10000,
            "withdraw": 100,
            "deposit_type": "daily",
            "created_at": "2019-04-11 13:47:17",
            "updated_at": "2019-04-11 13:47:17",
            "authcodes_count": 0
        }
}
```

> 總筆數

```
{
    "code": 200,
    "data": 1
}
```

> 單筆詳細資訊

```
{
    "code": 200,
    "data": {
        "id": 1,
        "name": "test",
        "status": "on",
        "vendor": "aliPay",
        "user_id": null,
        "max_deposit": 1000,
        "min_deposit": 100,
        "total_deposit": 10000,
        "withdraw": 100,
        "deposit_type": "daily",
        "conn_config": {
            "app_id": "123",
            "app_public_key": "123456",
            "private_key": "777"
        },
        "created_at": "2019-04-11 13:47:17",
        "updated_at": "2019-04-11 13:47:17"
    }
}
```

> 新增

```
{
    "code": 200,
    "data": {
        "name": "test21",
        "status": "on",
        "min_deposit": "100",
        "max_deposit": 10000,
        "total_deposit": "300000",
        "deposit_type": "daily",
        "withdraw": "1000",
        "vendor": "aliPay",
        "conn_config": {
            "app_id": "11111",
            "app_public_key": "1111111",
            "private_key": "777777"
        },
        "updated_at": "2019-04-11 14:54:27",
        "created_at": "2019-04-11 14:54:27",
        "id": 2
    }
}
```

> 更新

```
{
    "code": 200,
    "data": {
        "id": 1,
        "name": "test21",
        "status": "on",
        "vendor": "aliPay",
        "user_id": null,
        "max_deposit": 10000,
        "min_deposit": "100",
        "total_deposit": "300000",
        "withdraw": "1000",
        "deposit_type": "daily",
        "conn_config": {
            "app_id": "11111",
            "app_public_key": "1111111",
            "private_key": "777777"
        },
        "created_at": "2019-04-11 13:47:17",
        "updated_at": "2019-04-11 15:05:35"
    }
}
```

> 刪除

```
{
    "code": 200,
    "data": true
}
```

> 金流來源清單

```
{
    "code": 200,
    "data": [
        "aliPay",
        "weChatPay",
        "unionPay",
        "qqPay",
        "aliPayRedEnvelop",
        "aliPayPersonalBankAccount"
    ]
}
```
