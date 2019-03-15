# 單管理

> 列表

```
{
  "code": 200,
  "data": [
    {
      "id": 22,
      "user_name": "333",
      "card_no": "333",
      "bank_name": "333",
      "status": "Y",
      "total_amount": 22222222,
      "minimum_amount": 1000,
      "maximum_amount": 2222,
      "statistics_type": "day",
      "created_at": "2019-02-23 16:30:47",
      "updated_at": "2019-03-05 14:30:30",
      "payment": [
        {
          "id": 9,
          "i6pay_id": 204,
          "name": "微信WAP(204)",
          "fee": 0,
          "activate": 1,
          "description": null,
          "payment_information": {
            "bank_card_account_id": 22,
            "payment_id": 204,
            "payment_detail": {
              "card_id": "56789"
            }
          }
        }
      ],
      "personal": [
        {
          "id": 8,
          "company_name": "测试商户",
          "company_service_id": "097a9e1172e2e5220c1f83b9d4f0cf28","pivot": {
            "bank_card_account_id": 22,
            "user_id": 8,
            "created_at": "2019-02-23 16:30:47",
            "updated_at": "2019-02-23 16:30:47"
          }
        }
      ]
    },
    {
      "id": 21,
      "user_name": "222",
      "card_no": "2222222222",
      "bank_name": "222",
      "status": "Y",
      "total_amount": 111111,
      "minimum_amount": 1,
      "maximum_amount": 2222,
      "statistics_type": "week",
      "created_at": "2019-02-23 16:30:01",
      "updated_at": "2019-02-23 16:30:01",
      "payment": [
        {
          "id": 9,
          "i6pay_id": 204,
          "name": "微信WAP(204)",
          "fee": 0,
          "activate": 1,
          "description": null,
          "payment_information": {
            "bank_card_account_id": 21,
            "payment_id": 204,
            "payment_detail": {
              "card_id": "222"
            }
          }
        }
      ],
      "personal": [
        {
          "id": 8,          
          "company_name": "测试商户",          
          "company_service_id": "097a9e1172e2e5220c1f83b9d4f0cf28",
          "pivot": {
            "bank_card_account_id": 21,
            "user_id": 8,
            "created_at": "2019-02-23 16:30:01",
            "updated_at": "2019-02-23 16:30:01"
          }
        }
      ]
    },
    {
      "id": 6,
      "user_name": "1412412",
      "card_no": "12412412",
      "bank_name": "124124",
      "status": "Y",
      "total_amount": 0,
      "minimum_amount": 111,
      "maximum_amount": 111,
      "statistics_type": "day",
      "created_at": "2019-02-13 16:53:33",
      "updated_at": "2019-02-23 16:29:20",
      "payment": [
        {
          "id": 10,
          "i6pay_id": 30,
          "name": "微信扫码(30)",
          "fee": 3.5,
          "activate": 1,
          "description": null,
          "payment_information": {
            "bank_card_account_id": 6,
            "payment_id": 30,
            "payment_detail": {
              "bank_mark": "testID"
            }
          }
        }
      ],
      "personal": [
        {
          "id": 8,
          "company_name": "测试商户",
          "company_service_id": "097a9e1172e2e5220c1f83b9d4f0cf28",
          "pivot": {
            "bank_card_account_id": 6,
            "user_id": 8,
            "created_at": "2019-02-13 16:53:33",
            "updated_at": "2019-02-13 16:53:33"
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
    "code": 200,
    "data": 1 // 筆數
}
```

> 單筆查詢

```
{
  "code": 200,
  "data": {
    "id": 22,
    "user_name": "333",
    "card_no": "333",
    "bank_name": "333",
    "status": "Y",
    "total_amount": 22222222,
    "minimum_amount": 1000,
    "maximum_amount": 2222,
    "statistics_type": "day",
    "created_at": "2019-02-23 16:30:47",
    "updated_at": "2019-03-05 14:30:30",
    "payment": [
      {
        "id": 9,
        "i6pay_id": 204,
        "name": "微信WAP(204)",
        "fee": 0,
        "activate": 1,
        "description": null,
        "payment_information": {
          "bank_card_account_id": 22,
          "payment_id": 204,
          "payment_detail": {
            "card_id": "56789"
          }
        }
      }
    ],
    "personal": [
      {
        "id": 8,
        "company_name": "测试商户",
        "company_service_id": "097a9e1172e2e5220c1f83b9d4f0cf28",
        "pivot": {
          "bank_card_account_id": 22,
          "user_id": 8,
          "created_at": "2019-02-23 16:30:47",
          "updated_at": "2019-02-23 16:30:47"
        }
      }
    ]
  }
}
```

> 商戶列表

```
{
  "code": 200,
  "data": [
    {
      "id": 8,
      "company_name": "测试商户",
      "company_service_id": "097a9e1172e2e5220c1f83b9d4f0cf28"
    },
    {
      "id": 9,
      "company_name": "棋牌-77娱乐",
      "company_service_id": "d88269f303e124031e31fcad84a5496c"
    },
    {
      "id": 13,
      "company_name": "彩99",
      "company_service_id": "47913fa4c49419d515fb36c22fe29f6c"
    },
    {
      "id": 14,
      "company_name": "金龙",
      "company_service_id": "3e3a7d6cfc29198bf3ee106b8b6d7303"
    },
    {
      "id": 15,
      "company_name": "彩16",
      "company_service_id": "401fd8bf8585504d63126bea5a1be5e1"
    }
  ]
}
```
