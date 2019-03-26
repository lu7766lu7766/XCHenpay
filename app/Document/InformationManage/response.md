# 信息通知 > 信息管理

> 列表

```
{   
   "code": 200,
    "data": [
      {
        "id": 53,
        "category_id": 1,
        "subject": "\u9019\u662f\u6e2c\u8a66",
        "content": "\u9019\u662f\u6e2c\u8a66",
        "created_at": "2019-03-11 13:29:54",
        "updated_at": "2019-03-11 13:29:54",
        "category": {
          "id": 1,
          "code": 0,
          "created_at": "2019-02-14 14:43:04",
          "updated_at": "2019-02-14 14:43:04"
        },
        "role_group": [
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
              "information_notify_id": 53,
              "relate_id": 1,
              "created_at": "2019-03-11 13:29:54",
              "updated_at": "2019-03-11 13:29:54"
            }
          }
        ]
      }
    ]
}
```

> 列表總數

```
{   
  "code":200,
  "data":"1"
}
```

> 信息類別

```
{   
    "code": 200,
      "data": [
        {
          "id": 1,
          "code": 0,
          "created_at": "2019-02-14 14:43:04",
          "updated_at": "2019-02-14 14:43:04"
        },
        {
          "id": 2,
          "code": 1,
          "created_at": "2019-02-14 14:43:04",
          "updated_at": "2019-02-14 14:43:04"
        },
        {
          "id": 3,
          "code": 2,
          "created_at": "2019-02-14 14:43:04",
          "updated_at": "2019-02-14 14:43:04"
        }
      ]
}
```

> 新增

```
{   
    "code": 200,
     "data": {
       "data": null
     }
}
```

> 刪除

```
{   
   "code": 200,
   "data": "1"
}
```
