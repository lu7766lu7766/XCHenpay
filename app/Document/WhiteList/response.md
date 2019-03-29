# 商戶功能 > 白名單設定

> 列表

```
{
  "code": 200,
  "data": [
    {
      "id": 4, // 使用者id
      "company_name": "99_API_test",
      "company_service_id": "cdaecb46830eb3cb920d8b9856e6438e",
      "whitelist": { // 白名單設定
        "id": 3,
        "user_id": 4,
        "ip": [
          "1.1.1.1"
        ],
        "created_at": "2019-03-29 16:25:47",
        "updated_at": "2019-03-29 16:25:47"
      }
    },
    {
      "id": 3,
      "company_name": "",
      "company_service_id": "",
      "whitelist": null
    },
    {
      "id": 2,
      "company_name": "",
      "company_service_id": "",
      "whitelist": null
    },
    {
      "id": 1,
      "company_name": "",
      "company_service_id": "",
      "whitelist": null
    }
  ]
}
```

> 總筆數

```
{
  "code": 200,
  "data": {
    "count": 4
  }
}
```

> 修改ip

```
{
  "code": 200,
  "data": {
    "user_id": 4, // 使用者id
    "ip": [ // 白ip列表
      "1.1.1.1"
    ],
    "updated_at": "2019-03-29 16:25:47",
    "created_at": "2019-03-29 16:25:47",
    "id": 3 // 白ip資料流水號
  }
}
```

> 清空ip

```
{
  "code": 200,
  "data": {
    "count": 1
  }
}
```
