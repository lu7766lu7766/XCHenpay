# 收款管理 > 帳戶設置

> 列表

```
{   
  "code": 200,
  "data": [
    {
      "id": 26,
      "user_name": "999",
      "card_no": "888",
      "bank_name": "777",
      "status": "Y",
      "total_amount": 1000000,
      "minimum_amount": 555,
      "maximum_amount": 55555,
      "statistics_type": "day",
      "created_at": "2019-03-15 17:40:27",
      "updated_at": "2019-03-15 17:42:04",
      "payment": [
        {
          "id": 2,
          "i6pay_id": 6,
          "name": "QQ\u626b\u7801(6)",
          "fee": 1.5,
          "activate": 1,
          "description": null,
          "payment_information": {
            "bank_card_account_id": 26,
            "payment_id": 6,
            "payment_detail": {
              "card_id": null
            }
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
  "data":"5"
}
```

> 單筆資訊

```
{   
  "code": 200,
  "data": {
      "id": 32,
      "user_name": "ho",
      "card_no": "6230520210024216874",
      "bank_name": "jaccbank",
      "status": "Y",
      "total_amount": 10000,
      "minimum_amount": 1000,
      "maximum_amount": 1000,
      "statistics_type": "day",
      "created_at": "2019-02-23 14:09:02",
      "updated_at": "2019-03-13 13:53:25"
  }
}
```

> 取得通道類型

```
{   
  "code": 200,
  "data": [
    {
      "id": 2,
      "i6pay_id": 6,
      "name": "QQ\u626b\u7801(6)",
      "fee": 1.5,
      "activate": 1,
      "description": null
    },
    {
      "id": 3,
      "i6pay_id": 9,
      "name": "\u94f6\u8054\u626b\u7801(9)",
      "fee": 1.5,
      "activate": 1,
      "description": null
    },
    {
      "id": 4,
      "i6pay_id": 20,
      "name": "\u652f\u4ed8\u5b9d\u626b\u7801(20)",
      "fee": 2.2,
      "activate": 1,
      "description": null
    }
  ]
}
```

> 新增

```
{   
 "code": 200,
 "data": {
   "user_name": "asd",
   "card_no": "asda",
   "bank_name": "sdasdasd",
   "status": "N",
   "minimum_amount": "100",
   "maximum_amount": "1000",
   "statistics_type": "day",
   "total_amount": "2000",
   "updated_at": "2019-03-19 18:02:25",
   "created_at": "2019-03-19 18:02:25",
   "id": 27
 }
}
```

> 更新

```
{   
   "code": 200,
   "data": {
     "user_name": "asd",
     "card_no": "asda",
     "bank_name": "sdasdasd",
     "status": "N",
     "minimum_amount": "100",
     "maximum_amount": "1000",
     "statistics_type": "day",
     "total_amount": "2000",
     "updated_at": "2019-03-19 18:02:25",
     "created_at": "2019-03-19 18:02:25",
     "id": 27
   }
}
```
> status

```
{
    "code": 200,
    "data": [
        "N",
        "Y"
    ]
}
```
