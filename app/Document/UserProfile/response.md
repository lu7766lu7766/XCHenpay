# 商戶資料

> 商戶資訊

```
{   
  "code": 200,
    "data": {
      "id": 1,
      "email": "admin@admin.com",
      "status": "on",
      "apply_status": "off",
      "QQ_id": "0000000000",
      "company_name": "\u7cfb\u7edf\u7ba1\u7406\u5458",
      "mobile": "0000000000",
      "company_service_id": "",
      "sceret_key": "",
      "account_id": null,
      "lend_fee": 0,
      "permissions": [
        
      ],
      "last_login": "2019-03-25 17:51:18",
      "created_at": "2018-11-26 18:57:14",
      "updated_at": "2019-03-25 17:51:18",
      "deleted_at": null,
      "secret_code": "$2y$10$Q1OjoEwqs4SllhuQt4LsYu5as0Og0ELmCv1Qbjc4D.uRZil2jKuK6",
      "roles": [
        {
          "id": 1,
          "slug": "admin",
          "name": "\u7ba1\u7406\u8005",
          "permissions": {
            "lendManage": true,
            "users.dataSwitch": true,
            "logQuery": true,
            "users": true,
            "lendApply": true,
            "activity_log": true,
            "account": true,
            "search": true,
            "whitelist": true,
            "systemSetting": true,
            "logQuery.callNotify": true,
            "merchants": true,
            "trashed.merchants": true,
            "channel.feeManagement": true,
            "notify.order.fail": true
          },
          "created_at": "2018-11-26 18:57:14",
          "updated_at": "2019-01-08 16:26:36",
          "pivot": {
            "user_id": 1,
            "role_id": 1,
            "created_at": "2018-11-26 18:57:14",
            "updated_at": "2018-11-26 18:57:14"
          }
        }
      ]
    }
}
```

> 更改密碼/安全碼

```
{   
     "code": 200,
     "data": true
}
```
