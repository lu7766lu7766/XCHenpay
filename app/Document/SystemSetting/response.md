# 系統設置

##### 帳號管理 ##### 
---
`角色列表(非商戶)`
```
{
    "code": 200,
    "data": [
        {
            "id": 1,
            "name": "管理者"
        },
        {
            "id": 2,
            "name": "客服"
        },
        {
            "id": 3,
            "name": "财务"
        }
    ]
}
```

`帳號列表查詢(非商戶)`
```
{
    "code": 200,
    "data": [
        {
            "id": 1,
            "company_name": "系统管理员",
            "email": "admin@admin.com",
            "status": "on",
            "roles": [
                {
                    "name": "管理者",
                    "slug": "admin",
                    "pivot": {
                        "user_id": 1,
                        "role_id": 1,
                        "created_at": "2018-11-26 18:57:14",
                        "updated_at": "2018-11-26 18:57:14"
                    }
                }
            ]
        },
        {
            "id": 5,
            "company_name": "网站管理员",
            "email": "henpay@henpay.net",
            "status": "on",
            "roles": [
                {
                    "name": "管理者",
                    "slug": "admin",
                    "pivot": {
                        "user_id": 5,
                        "role_id": 1,
                        "created_at": "2018-11-30 00:39:26",
                        "updated_at": "2018-11-30 00:39:26"
                    }
                }
            ]
        }
    ]
}
```
`帳號列表總筆數(非商戶)`
```
{
    "code": 200,
    "data": {
        "total": 2
    }
}
```
`帳號資料明細(非商戶)`
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
`帳號新增(非商戶)`
```
{
    "code": 200,
    "data": {
        "email": "happy_fish@gmail.com",
        "status": "on",
        "apply_status": "off",
        "QQ_id": "",
        "company_name": "happy_fish",
        "mobile": "",
        "company_service_id": "",
        "lend_fee": 0,
        "sceret_key": "",
        "updated_at": "2018-12-28 15:09:25",
        "created_at": "2018-12-28 15:09:25",
        "id": 47,
        "roles": {
            "id": 3,
            "name": "财务",
            "slug": "finance"
        }
    }
}
```
`帳號更新(非商戶)`
```
{"code":200,"data":[]}
```
`帳號刪除(非商戶)`
```
{"code":200,"data":[]}
```
