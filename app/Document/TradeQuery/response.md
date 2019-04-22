# 系統設置 > 金流管理

> 訂單資訊

```
{
    "authcode": {
        "id": 316977,
        "pay_state": 1,
        "pay_summary": "\u4ea4\u6613\u4e2d",
        "auth_code": "xktYbuzvwQ9HiQ4X4uOYdm9OrKATs8RzzMWMQujkb6ai634r1gZaw5AbwcU9iaWv",
        "trade_seq": "ec8879538c628543c4f54943fe4f4fcd",
        "company_service_id": "097a9e1172e2e5220c1f83b9d4f0cf28",
        "trade_service_id": "20190329162137550149",
        "trade_type": {
          "id": 1,
          "name": "web",
          "description": null
        },
        "customer_id": "3tWZtX4A",
        "item_code": "item_code",
        "item_name": "item_name",
        "amount": "1.000000",
        "fee": "0.000000",
        "currency_id": 1,
        "nonce_str": null,
        "finish_url": "https:\/\/www.youtube.com\/",
        "notify_url": "https:\/\/www.youtube.com\/",
        "account": null,
        "payment_type": 201,
        "pay_start_time": "2019-04-22 14:27:16",
        "pay_end_time": null,
        "error_msg": null,
        "manual_at": null,
        "created_at": "2019-04-22 16:27:16",
        "updated_at": "2019-04-22 14:27:16",
        "remark": "",
        "real_paid_amount": "0.000000",
        "rand_fee": "0.05",
        "currency": {
          "id": 1,
          "name": "CNY",
          "description": null
        }
      }
}
```

> 交易狀態修改頁面資訊

```
{
   "authcode": {
       "id": 316977,
       "pay_state": 1,
       "pay_summary": "\u4ea4\u6613\u4e2d",
       "auth_code": "xktYbuzvwQ9HiQ4X4uOYdm9OrKATs8RzzMWMQujkb6ai634r1gZaw5AbwcU9iaWv",
       "trade_seq": "ec8879538c628543c4f54943fe4f4fcd",
       "company_service_id": "097a9e1172e2e5220c1f83b9d4f0cf28",
       "trade_service_id": "20190329162137550149",
       "trade_type": 1,
       "customer_id": "3tWZtX4A",
       "item_code": "item_code",
       "item_name": "item_name",
       "amount": "1.000000",
       "fee": "0.000000",
       "currency_id": 1,
       "nonce_str": null,
       "finish_url": "https:\/\/www.youtube.com\/",
       "notify_url": "https:\/\/www.youtube.com\/",
       "account": null,
       "payment_type": 201,
       "pay_start_time": "2019-04-22 14:27:16",
       "pay_end_time": null,
       "error_msg": null,
       "manual_at": null,
       "created_at": "2019-04-22 16:27:16",
       "updated_at": "2019-04-22 14:27:16",
       "remark": "",
       "real_paid_amount": "0.000000",
       "rand_fee": "0.05"
     },
     "stateList": [
       "\u7533\u8bf7\u6210\u529f",
       "\u4ea4\u6613\u4e2d",
       "\u4ea4\u6613\u6210\u529f,\u672a\u56de\u8c03",
       "\u4ea4\u6613\u7ed3\u675f",
       "\u4ea4\u6613\u5931\u8d25"
     ]
}
```

> 交易狀態修改

```
{
    "id": 316977,
     "pay_state": "1",
     "pay_summary": "\u4ea4\u6613\u4e2d",
     "auth_code": "xktYbuzvwQ9HiQ4X4uOYdm9OrKATs8RzzMWMQujkb6ai634r1gZaw5AbwcU9iaWv",
     "trade_seq": "ec8879538c628543c4f54943fe4f4fcd",
     "company_service_id": "097a9e1172e2e5220c1f83b9d4f0cf28",
     "trade_service_id": "20190329162137550149",
     "trade_type": 1,
     "customer_id": "3tWZtX4A",
     "item_code": "item_code",
     "item_name": "item_name",
     "amount": "1.000000",
     "fee": "0.000000",
     "currency_id": 1,
     "nonce_str": null,
     "finish_url": "https:\/\/www.youtube.com\/",
     "notify_url": "https:\/\/www.youtube.com\/",
     "account": null,
     "payment_type": 201,
     "pay_start_time": "2019-04-22 14:27:16",
     "pay_end_time": null,
     "error_msg": null,
     "manual_at": "2019-04-22 17:51:06",
     "created_at": "2019-04-22 16:27:16",
     "updated_at": "2019-04-22 17:51:06",
     "remark": "",
     "real_paid_amount": "0",
     "rand_fee": "0.05"
}
```

> 商戶注單總數

```
{
    "code": 200,
      "data": "8"
}
```

> 訂單交易資訊

```
{
     "code": 200,
     "data": {
       "fee": "0.000",
       "successful_deal": "0.000",
       "failure_deal": "404.000"
     }
}
```

> 訂單銀行卡資訊

```
{
     "code": 200,
        "data": {
            "id": 1,
            "user_name": "11",
            "card_no": "11",
            "bank_name": "11",
            "status": "Y",
            "total_amount": 14,
            "minimum_amount": 1,
            "maximum_amount": 1000,
            "statistics_type": "day",
            "created_at": "2019-01-31 18:51:30",
            "updated_at": "2019-01-31 18:51:30",
            "payment": [
                {
                    "id": 7,
                    "i6pay_id": 201,
                    "name": "支付宝转银行卡",
                    "fee": 1.1,
                    "activate": 1,
                    "description": null,
                    "payment_information": {
                        "bank_card_account_id": 1,
                        "payment_id": 201,
                        "payment_detail": {
                            "bank_mark": "ICBC",
                            "card_id": "testID"
                        }
                    }
                }
            ]
        }
}
```

> 支付方式列表

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
       }
     ]
}
```

> 訂單列表

```
{
     "data": [
        {
          "id": 316977,
          "pay_state": 1,
          "pay_summary": "\u4ea4\u6613\u4e2d",
          "trade_seq": "ec8879538c628543c4f54943fe4f4fcd",
          "company_service_id": "097a9e1172e2e5220c1f83b9d4f0cf28",
          "trade_service_id": "20190329162137550149",
          "amount": "1.000000",
          "currency_id": 1,
          "payment_type": 201,
          "fee": "0.000000",
          "created_at": "2019-04-22 16:27:16",
          "pay_start_time": "2019-04-22 14:27:16",
          "pay_end_time": null,
          "real_paid_amount": "0.000000",
          "rand_fee": "0.05",
          "i6payment": {
            "id": 7,
            "i6pay_id": 201,
            "name": "\u652f\u4ed8\u5b9d\u8f6c\u94f6\u884c\u5361(201)",
            "fee": 0,
            "activate": 1,
            "description": null
          },
          "company": {
            "id": 8,
            "email": "test@henpay.net",
            "status": "on",
            "apply_status": "on",
            "QQ_id": "0000000000",
            "company_name": "\u6d4b\u8bd5\u5546\u6237",
            "mobile": "13227884080",
            "company_service_id": "097a9e1172e2e5220c1f83b9d4f0cf28",
            "sceret_key": "f361a123fa2ec3d978deb902ae992555",
            "account_id": null,
            "lend_fee": 0.0002,
            "permissions": [
              
            ],
            "last_login": "2019-04-22 17:32:25",
            "created_at": "2018-11-30 00:41:10",
            "updated_at": "2019-04-22 17:32:25",
            "deleted_at": null,
            "secret_code": "$2y$10$Hd7sPGqSOQIx\/GA9FwIB4eOkTuIdUi3FzRiO3D0EC69fyulnEqdC2"
          },
          "currency": {
            "id": 1,
            "name": "CNY",
            "description": null
          },
          "bank_card_account": [
            {
              "id": 28,
              "user_name": "\u9648\u5fe0\u6839",
              "card_no": "6217993900059152516",
              "bank_name": "\u4e2d\u56fd\u90ae\u653f",
              "status": "Y",
              "total_amount": 100000,
              "minimum_amount": 1,
              "maximum_amount": 100000,
              "statistics_type": "day",
              "created_at": "2019-04-16 12:55:12",
              "updated_at": "2019-04-16 12:55:12",
              "gateway_uri": {
                "authcode_id": 316977,
                "bank_card_id": 28,
                "uri": "alipays:\/\/platformapi\/startapp?appId=09999988&actionType=toCard&sourceId=bill&bankAccount=%E9%99%88%E5%BF%A0%E6%A0%B9&money=0.95&amount=0.95&bankMark=PSBC&bankName=%E4%B8%AD%E5%9B%BD%E9%82%AE%E6%94%BF&cardNoHidden=1&cardChannel=HISTORY_CARD&orderSource=from&cardNo=6217993900059152516"
              },
              "payment": [
                {
                  "id": 7,
                  "i6pay_id": 201,
                  "name": "\u652f\u4ed8\u5b9d\u8f6c\u94f6\u884c\u5361(201)",
                  "fee": 0,
                  "activate": 1,
                  "description": null,
                  "payment_information": {
                    "bank_card_account_id": 28,
                    "payment_id": 201,
                    "payment_detail": {
                      "card_id": null,
                      "bank_mark": "PSBC"
                    }
                  }
                }
              ]
            }
          ]
        },
        {
          "id": 316983,
          "pay_state": 1,
          "pay_summary": "\u4ea4\u6613\u4e2d",
          "trade_seq": "e07ba95179edaf946c03f46968211e7a",
          "company_service_id": "097a9e1172e2e5220c1f83b9d4f0cf28",
          "trade_service_id": "XC2019042212300001",
          "amount": "100.000000",
          "currency_id": 1,
          "payment_type": 201,
          "fee": "0.000000",
          "created_at": "2019-04-22 15:45:19",
          "pay_start_time": "2019-04-22 15:45:19",
          "pay_end_time": null,
          "real_paid_amount": "0.000000",
          "rand_fee": "0.05",
          "i6payment": {
            "id": 7,
            "i6pay_id": 201,
            "name": "\u652f\u4ed8\u5b9d\u8f6c\u94f6\u884c\u5361(201)",
            "fee": 0,
            "activate": 1,
            "description": null
          },
          "company": {
            "id": 8,
            "email": "test@henpay.net",
            "status": "on",
            "apply_status": "on",
            "QQ_id": "0000000000",
            "company_name": "\u6d4b\u8bd5\u5546\u6237",
            "mobile": "13227884080",
            "company_service_id": "097a9e1172e2e5220c1f83b9d4f0cf28",
            "sceret_key": "f361a123fa2ec3d978deb902ae992555",
            "account_id": null,
            "lend_fee": 0.0002,
            "permissions": [
              
            ],
            "last_login": "2019-04-22 17:32:25",
            "created_at": "2018-11-30 00:41:10",
            "updated_at": "2019-04-22 17:32:25",
            "deleted_at": null,
            "secret_code": "$2y$10$Hd7sPGqSOQIx\/GA9FwIB4eOkTuIdUi3FzRiO3D0EC69fyulnEqdC2"
          },
          "currency": {
            "id": 1,
            "name": "CNY",
            "description": null
          },
          "bank_card_account": [
            {
              "id": 29,
              "user_name": "\u9648\u51a0\u7ff0",
              "card_no": "6217001830036765827",
              "bank_name": "\u5efa\u8bbe\u94f6\u884c",
              "status": "Y",
              "total_amount": 100000,
              "minimum_amount": 1,
              "maximum_amount": 50000,
              "statistics_type": "day",
              "created_at": "2019-04-22 14:36:56",
              "updated_at": "2019-04-22 14:36:56",
              "gateway_uri": {
                "authcode_id": 316983,
                "bank_card_id": 29,
                "uri": "alipays:\/\/platformapi\/startapp?appId=09999988&actionType=toCard&sourceId=bill&bankAccount=%E9%99%88%E5%86%A0%E7%BF%B0&money=99.95&amount=99.95&bankMark=CCB&bankName=%E5%BB%BA%E8%AE%BE%E9%93%B6%E8%A1%8C&cardNoHidden=1&cardChannel=HISTORY_CARD&orderSource=from&cardNo=6217001830036765827"
              },
              "payment": [
                {
                  "id": 7,
                  "i6pay_id": 201,
                  "name": "\u652f\u4ed8\u5b9d\u8f6c\u94f6\u884c\u5361(201)",
                  "fee": 0,
                  "activate": 1,
                  "description": null,
                  "payment_information": {
                    "bank_card_account_id": 29,
                    "payment_id": 201,
                    "payment_detail": {
                      "card_id": null,
                      "bank_mark": "CCB"
                    }
                  }
                }
              ]
            }
          ]
        }
      ],
      "can_edit": true
}
```

> 取得初始資料

```
{
   "companies": [
       {
         "id": 8,
         "email": "test@henpay.net",
         "status": "on",
         "apply_status": "on",
         "QQ_id": "0000000000",
         "company_name": "\u6d4b\u8bd5\u5546\u6237",
         "mobile": "13227884080",
         "company_service_id": "097a9e1172e2e5220c1f83b9d4f0cf28",
         "sceret_key": "f361a123fa2ec3d978deb902ae992555",
         "account_id": null,
         "lend_fee": 0.0002,
         "permissions": [
           
         ],
         "last_login": "2019-04-22 17:32:25",
         "created_at": "2018-11-30 00:41:10",
         "updated_at": "2019-04-22 17:32:25",
         "deleted_at": null,
         "secret_code": "$2y$10$Hd7sPGqSOQIx\/GA9FwIB4eOkTuIdUi3FzRiO3D0EC69fyulnEqdC2"
       },
       {
         "id": 9,
         "email": "283021849@qq.com",
         "status": "on",
         "apply_status": "on",
         "QQ_id": "283021849",
         "company_name": "\u68cb\u724c-77\u5a31\u4e50",
         "mobile": "13128736098",
         "company_service_id": "d88269f303e124031e31fcad84a5496c",
         "sceret_key": "2c77da5310bb7d27f9725c3132c9a959",
         "account_id": null,
         "lend_fee": 0.0002,
         "permissions": [
           
         ],
         "last_login": "2019-04-15 14:38:52",
         "created_at": "2018-12-21 00:56:42",
         "updated_at": "2019-04-15 14:38:52",
         "deleted_at": null,
         "secret_code": "$2y$10$A.yXPQNxZxsmnM3xCuzryupIJxQVT09EyzhHPnak6SAfrMgsAHO.e"
       },
       {
         "id": 13,
         "email": "fire20170101b@gmail.com",
         "status": "on",
         "apply_status": "on",
         "QQ_id": "2463947996",
         "company_name": "\u5f6999",
         "mobile": "18502188503",
         "company_service_id": "47913fa4c49419d515fb36c22fe29f6c",
         "sceret_key": "43c7e2a3020c1cf2363016464314b395",
         "account_id": null,
         "lend_fee": 0.0002,
         "permissions": [
           
         ],
         "last_login": "2019-04-15 14:40:52",
         "created_at": "2018-12-22 17:38:15",
         "updated_at": "2019-04-15 14:40:52",
         "deleted_at": null,
         "secret_code": "$2y$10$J9SsRS7ZFewcHUw62kTPGePLEaW9by5K0rMg6Spggdda62JGy0Qhe"
       },
       {
         "id": 14,
         "email": "gl99vip@163.com",
         "status": "on",
         "apply_status": "on",
         "QQ_id": "3337641185",
         "company_name": "\u91d1\u9f99",
         "mobile": "13235651142",
         "company_service_id": "3e3a7d6cfc29198bf3ee106b8b6d7303",
         "sceret_key": "36d0c3737ddee0f7b1b84615e458df23",
         "account_id": null,
         "lend_fee": 0.0002,
         "permissions": [
           
         ],
         "last_login": "2019-01-09 15:13:20",
         "created_at": "2018-12-22 17:39:03",
         "updated_at": "2019-01-09 15:13:20",
         "deleted_at": null,
         "secret_code": null
       },
       {
         "id": 15,
         "email": "anlele199212@163.com",
         "status": "on",
         "apply_status": "on",
         "QQ_id": "2656689465",
         "company_name": "\u5f6916",
         "mobile": "13551021743",
         "company_service_id": "401fd8bf8585504d63126bea5a1be5e1",
         "sceret_key": "6981c791d349baa5221580a1d2436aaa",
         "account_id": null,
         "lend_fee": 0.0002,
         "permissions": [
           
         ],
         "last_login": "2019-03-08 15:20:55",
         "created_at": "2018-12-22 17:39:47",
         "updated_at": "2019-03-08 15:20:55",
         "deleted_at": null,
         "secret_code": null
       }
     ],
     "user": {
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
       "last_login": "2019-04-22 17:32:41",
       "created_at": "2018-11-26 18:57:14",
       "updated_at": "2019-04-22 17:32:41",
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
             "whitelist": true,
             "logQuery.callNotify": true,
             "merchants": true,
             "trashed.merchants": true,
             "channel.feeManagement": true,
             "notify.order.fail": true,
             "system.setting.user.manage": true,
             "report.search": true
           },
           "created_at": "2018-11-26 18:57:14",
           "updated_at": "2019-04-11 15:50:35",
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

> 回調通知

```
{
     "code": 200,
     "data": true
}
```
