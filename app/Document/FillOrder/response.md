# 單管理

> 列表

```
{   
    "code": 200,
    "data": [
        {
            "id": 3, // 注單ID
            "pay_state": 1, // 支付狀態
            "pay_summary": "交易中", // 支付狀態對應的文字描述
            "auth_code": "", 
            "trade_seq": "5eca7682d1296122db04376aa3e4ff17", // 系統交易號
            "company_service_id": "cdaecb46830eb3cb920d8b9856e6438e", // 商戶id
            "trade_service_id": "355.222", // 商戶交易號
            "trade_type": 5, // 交易類型
            "customer_id": null,
            "item_code": "",
            "item_name": "",
            "amount": "1000.555000", // 交易金額
            "fee": "10.555000", // 手續費
            "currency_id": 1, // 幣別
            "nonce_str": null,
            "finish_url": "",
            "notify_url": "",
            "account": null,
            "payment_type": 6, // 支付類型
            "pay_start_time": "2018-09-09 01:01:01", 
            "pay_end_time": "2018-09-09 01:01:01",// 交易時間
            "error_msg": null,
            "manual_at": null,
            "created_at": "2018-12-27 14:21:19",
            "updated_at": "2018-12-27 14:34:00",
            "remark": "test", // 備註
            "company": { // 商戶資訊
                "id": 4,
                "company_service_id": "cdaecb46830eb3cb920d8b9856e6438e",
                "email": "UUU@uuu.com",
                "QQ_id": "",
                "mobile": "",
                "company_name": "99_API_test"
            },
            "payment": { // 支付類型詳細資訊
                "id": 2,
                "i6pay_id": 6,
                "name": "QQ扫码",
                "fee": 1.5,
                "activate": 1,
                "description": null
            }
        }
    ]
}
```

> 總筆數

```
{   
    "code": 200,
    "data": 1 // 筆數
}
```

> 編輯

```
{   
    "code": 200,
    "data": {
        "id": 3,
        "pay_state": "1",
        "pay_summary": "交易中",
        "auth_code": "",
        "trade_seq": "5eca7682d1296122db04376aa3e4ff17",
        "company_service_id": "cdaecb46830eb3cb920d8b9856e6438e",
        "trade_service_id": "355.222",
        "trade_type": 5,
        "customer_id": null,
        "item_code": "",
        "item_name": "",
        "amount": "1000.555",
        "fee": "10.555",
        "currency_id": 1,
        "nonce_str": null,
        "finish_url": "",
        "notify_url": "",
        "account": null,
        "payment_type": "6",
        "pay_start_time": "2018-09-09 01:01:01",
        "pay_end_time": "2018-09-09 01:01:01",
        "error_msg": null,
        "manual_at": null,
        "created_at": "2018-12-27 14:21:19",
        "updated_at": "2018-12-27 16:31:54",
        "remark": "test",
        "company": {
            "id": 4,
            "email": "UUU@uuu.com",
            "status": "on",
            "apply_status": "on",
            "QQ_id": "",
            "company_name": "99_API_test",
            "mobile": "",
            "company_service_id": "cdaecb46830eb3cb920d8b9856e6438e",
            "sceret_key": "97bc26ce95637a9114fce9d72bde884f",
            "account_id": null,
            "lend_fee": 0.0002,
            "permissions": [],
            "last_login": null,
            "created_at": "2018-11-26 15:10:49",
            "updated_at": "2018-11-26 15:10:49",
            "deleted_at": null
        },
        "payment": {
            "id": 2,
            "i6pay_id": 6,
            "name": "QQ扫码",
            "fee": 1.5,
            "activate": 1,
            "description": null
        }
    }
}
```

> 單筆查詢

```
{   
    "code": 200,
    "data": {
        "id": 3,
        "pay_state": "1",
        "pay_summary": "交易中",
        "auth_code": "",
        "trade_seq": "5eca7682d1296122db04376aa3e4ff17",
        "company_service_id": "cdaecb46830eb3cb920d8b9856e6438e",
        "trade_service_id": "355.222",
        "trade_type": 5,
        "customer_id": null,
        "item_code": "",
        "item_name": "",
        "amount": "1000.555",
        "fee": "10.555",
        "currency_id": 1,
        "nonce_str": null,
        "finish_url": "",
        "notify_url": "",
        "account": null,
        "payment_type": "6",
        "pay_start_time": "2018-09-09 01:01:01",
        "pay_end_time": "2018-09-09 01:01:01",
        "error_msg": null,
        "manual_at": null,
        "created_at": "2018-12-27 14:21:19",
        "updated_at": "2018-12-27 16:31:54",
        "remark": "test",
        "company": {
            "id": 4,
            "email": "UUU@uuu.com",
            "status": "on",
            "apply_status": "on",
            "QQ_id": "",
            "company_name": "99_API_test",
            "mobile": "",
            "company_service_id": "cdaecb46830eb3cb920d8b9856e6438e",
            "sceret_key": "97bc26ce95637a9114fce9d72bde884f",
            "account_id": null,
            "lend_fee": 0.0002,
            "permissions": [],
            "last_login": null,
            "created_at": "2018-11-26 15:10:49",
            "updated_at": "2018-11-26 15:10:49",
            "deleted_at": null
        },
        "payment": {
            "id": 2,
            "i6pay_id": 6,
            "name": "QQ扫码",
            "fee": 1.5,
            "activate": 1,
            "description": null
        }
    }
}
```

> 查詢/新增/編輯 選項

```
{
    "code": 200,
    "data": {
        "merchants": [
            {
                "id": 4,
                "company_service_id": "cdaecb46830eb3cb920d8b9856e6438e",
                "email": "UUU@uuu.com",
                "QQ_id": "",
                "mobile": "",
                "company_name": "99_API_test"
            }
        ],
        "pay_states": [
            0,
            1,
            2,
            3,
            4
        ],
        "payment": [
            {
                "id": 2,
                "i6pay_id": 6,
                "name": "QQ扫码",
                "fee": 1.5,
                "activate": 1,
                "description": null
            },
            {
                "id": 3,
                "i6pay_id": 9,
                "name": "银联扫码",
                "fee": 1.5,
                "activate": 1,
                "description": null
            },
            {
                "id": 4,
                "i6pay_id": 20,
                "name": "支付宝扫码",
                "fee": 2.2,
                "activate": 1,
                "description": null
            },
            {
                "id": 5,
                "i6pay_id": 21,
                "name": "支付宝WAP",
                "fee": 2.2,
                "activate": 1,
                "description": null
            }
        ]
    }
}
```
