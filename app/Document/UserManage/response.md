# 系統設置 > 帳號管理

> 列表

```
{
  "code": 200,
  "data": [
    {
      "id": 1, // 帳號流水號
      "company_name": "", // 商戶名稱
      "email": "admin@admin.com", //帳號
      "status": "on", // 狀態
      "roles": [ // 角色列表
        {
          "id": 1,
          "name": "管理者",
          "slug": "admin",
          "pivot": {
            "user_id": 1,
            "role_id": 1,
            "created_at": "2019-02-22 14:18:56",
            "updated_at": "2019-02-22 14:18:56"
          }
        }
      ]
    },
    {
      "id": 2,
      "company_name": "",
      "email": "ser@ser.com",
      "status": "on",
      "roles": [
        {
          "id": 2,
          "name": "客服",
          "slug": "customer_service",
          "pivot": {
            "user_id": 2,
            "role_id": 2,
            "created_at": "2019-02-22 14:18:56",
            "updated_at": "2019-02-22 14:18:56"
          }
        }
      ]
    },
    {
      "id": 3,
      "company_name": "",
      "email": "fan@fan.com",
      "status": "on",
      "roles": [
        {
          "id": 3,
          "name": "财务",
          "slug": "finance",
          "pivot": {
            "user_id": 3,
            "role_id": 3,
            "created_at": "2019-02-22 14:18:56",
            "updated_at": "2019-02-22 14:18:56"
          }
        }
      ]
    }
  ]
}
```

> 總筆數

```
{   
  "code":200,
  "data": {
    "total": 3
  }
}
```

> 單筆詳細資訊

```
{
    "code": 200,
    "data": {
        "id": 7,
        "company_name": "财务人员",
        "email": "finance@henpay.net",
        "status": "on",
        "roles": [
            {
                "name": "财务",
                "slug": "finance",
                "pivot": {
                    "user_id": 7,
                    "role_id": 3,
                    "created_at": "2018-11-30 00:40:42",
                    "updated_at": "2018-11-30 00:40:42"
                }
            }
        ]
    }
}
```

> 角色列表

```
{
  "code": 200,
  "data": [
    {
      "id": 1,
      "name": "管理者", // display name
      "slug": "admin" // 角色code
    },
    {
      "id": 2,
      "name": "客服",
      "slug": "customer_service"
    },
    {
      "id": 3,
      "name": "财务",
      "slug": "finance"
    }
  ]
}
```

> 新增

```
{
 "code": 200,
 "data": {
   "email": "test@test.cc",
   "status": "on",
   "apply_status": "off",
   "QQ_id": "",
   "company_name": "test",
   "mobile": "",
   "company_service_id": "",
   "lend_fee": 0,
   "sceret_key": "",
   "updated_at": "2019-04-01 15:00:11",
   "created_at": "2019-04-01 15:00:11",
   "id": 5,
   "roles": {
     "id": 3,
     "name": "财务",
     "slug": "finance"
   }
 }
}
```

> 修改

```
{
  "code": 200,
  "data": []
}
```

> 刪除

```
{   
  "code": 200,
  "data": []
}
```
